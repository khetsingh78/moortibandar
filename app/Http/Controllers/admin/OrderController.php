<?php

namespace App\Http\Controllers\admin;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\CreateShiprocketShipment;
use App\Models\Order;
use App\Models\Shipment;
use App\Services\Shiprocket\ShiprocketClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.orders.index');
        // return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems', 'shipping', 'payment', 'shipment']);

        // dd(json_decode($order, true));
        return view('admin.orders.show', compact('order'));
    }

    public function couriers(Request $request, Order $order, ShiprocketClient $shiprocket)
    {
   
        $paymentMethod = $this->eligiblePaymentMethod($order);
        $address = $order->shipping;
        if (!$address || !$address->zip) {
            return response()->json(['message' => 'A delivery postal code is required.'], 422);
        }

        $parcel = $request->validate([
            'weight' => ['required', 'numeric', 'min:0.01', 'max:1000'],
            'length' => ['required', 'numeric', 'min:1', 'max:500'],
            'breadth' => ['required', 'numeric', 'min:1', 'max:500'],
            'height' => ['required', 'numeric', 'min:1', 'max:500'],
        ]);

        try {
            $couriers = $shiprocket->availableCouriers($address, $parcel, $paymentMethod);
        } catch (Throwable $exception) {
            Log::warning('Shiprocket courier lookup failed', [
                'order_id' => $order->id,
                'message' => $exception->getMessage(),
            ]);

            return response()->json(['message' => 'Could not retrieve courier options. Check Shiprocket configuration and try again.'], 502);
        }

        return response()->json(['couriers' => $couriers]);
    }

    public function createShipment(Request $request, Order $order, ShiprocketClient $shiprocket)
    {
        // dd($request->all(), $order->toArray());
        $paymentMethod = $this->eligiblePaymentMethod($order);
        $parcel = $request->validate([
            'weight' => ['required', 'numeric', 'min:0.01', 'max:1000'],
            'length' => ['required', 'numeric', 'min:1', 'max:500'],
            'breadth' => ['required', 'numeric', 'min:1', 'max:500'],
            'height' => ['required', 'numeric', 'min:1', 'max:500'],
            'courier_id' => ['required', 'string', 'max:50'],
        ]);

        if (!$order->shipping || !$order->shipping->zip) {
            return back()->with('ErrorMessage', 'This order is missing its delivery postal code.');
        }

        try {
            $couriers = $shiprocket->availableCouriers($order->shipping, $parcel, $paymentMethod);
        } catch (Throwable $exception) {
            Log::warning('Shiprocket courier revalidation failed', [
                'order_id' => $order->id,
                'message' => $exception->getMessage(),
            ]);

            return back()->with('ErrorMessage', 'Could not verify the selected courier. Please load courier options again.');
        }

        $courier = collect($couriers)->firstWhere('id', $parcel['courier_id']);
        if (!$courier) {
            return back()->with('ErrorMessage', 'That courier is no longer available. Please select another courier.');
        }

        try {
            $shipment = DB::transaction(function () use ($order, $parcel, $courier) {
                $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
                $shipment = Shipment::where('order_id', $lockedOrder->id)->lockForUpdate()->first();

                if ($shipment && in_array($shipment->status, ['pending', 'processing', 'booked'], true)) {
                    throw ValidationException::withMessages([
                        'shipment' => 'A shipment already exists or is currently being created for this order.',
                    ]);
                }

                if (!$shipment) {
                    $shipment = new Shipment(['order_id' => $lockedOrder->id]);
                }

                $shipment->fill([
                    'provider' => 'shiprocket',
                    'courier_id' => $courier['id'],
                    'courier_name' => $courier['name'],
                    'weight' => $parcel['weight'],
                    'length' => $parcel['length'],
                    'breadth' => $parcel['breadth'],
                    'height' => $parcel['height'],
                    'status' => 'pending',
                    'last_error' => null,
                ])->save();

                return $shipment;
            });
        } catch (ValidationException $exception) {
            return back()->with('ErrorMessage', $exception->getMessage());
        }

        try {
            CreateShiprocketShipment::dispatch($shipment->id);
        } catch (Throwable $exception) {
            Log::error('Shiprocket shipment dispatch failed', [
                'shipment_id' => $shipment->id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('orders.show', $order)->with('ErrorMessage', 'Shipment creation failed. Review the shipment status and retry.');
        }

        return redirect()->route('orders.show', $order)->with('SuccessMessage', 'Shiprocket shipment request submitted.');
    }

    private function eligiblePaymentMethod(Order $order): string
    {
        $paymentMethod = strtolower((string) optional($order->payment)->payment_method);

        if ($paymentMethod === 'cod') {
            return 'cod';
        }

        if ($order->payment_status !== 'paid') {
            throw ValidationException::withMessages([
                'payment' => 'Prepaid orders must have a confirmed payment before shipment creation.',
            ]);
        }

        return 'prepaid';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
