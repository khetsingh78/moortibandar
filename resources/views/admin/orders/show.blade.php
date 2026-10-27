@extends('admin/comman/layout')
@section('title', 'Admin panel')

@push('header')
    <style>

    </style>
@endpush
@section('content')
    @php
        $shipment = $order->shipment;
        $isCod = strtolower((string) optional($order->payment)->payment_method) === 'cod';
        $canCreateShipment = $isCod || $order->payment_status === 'paid';
    @endphp

    <div class="container-fluid pt-4 px-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-secondary rounded p-4 mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h4 class="mb-1">Order {{ $order->invoice_no }}</h4>
                    <div class="text-muted">Placed {{ optional($order->created_at)->format('d M Y, h:i A') }}</div>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-light">Back to orders</a>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <h6>Customer</h6>
                    <div>{{ $order->user->name ?? 'Customer' }}</div>
                    <div>{{ $order->user->email ?? '' }}</div>
                    <div>Payment: {{ strtoupper(optional($order->payment)->payment_method ?? 'unknown') }} ({{ $order->payment_status }})</div>
                </div>
                <div class="col-md-4">
                    <h6>Delivery address</h6>
                    @if ($order->shipping)
                        <div>{{ $order->shipping->name }}</div>
                        <div>{{ $order->shipping->house_no }} {{ $order->shipping->address }}</div>
                        <div>{{ $order->shipping->city }}, {{ $order->shipping->state }} {{ $order->shipping->zip }}</div>
                        <div>{{ $order->shipping->country }} · {{ $order->shipping->phone }}</div>
                    @else
                        <div>No shipping address on this order.</div>
                    @endif
                </div>
                <div class="col-md-4">
                    <h6>Order total</h6>
                    <div>Subtotal: ₹{{ number_format((float) $order->subtotal, 2) }}</div>
                    <div>Discounts: ₹{{ number_format((float) $order->discount + (float) $order->coupon, 2) }}</div>
                    <div>GST: ₹{{ number_format((float) $order->gst, 2) }}</div>
                    <strong>Total: ₹{{ number_format((float) $order->total, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="bg-secondary rounded p-4 mb-4">
            <h5 class="mb-3">Items</h5>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>Item</th><th>Product ID</th><th>Qty</th><th>Unit price</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems ?? [] as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->product_id ?: 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format((float) $item->price, 2) }}</td>
                                <td>₹{{ number_format((float) $item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-secondary rounded p-4 mb-4" id="shipment-panel">
            <h5 class="mb-3">Shiprocket shipment</h5>
            @if ($shipment && $shipment->status === 'booked')
                <div class="row g-3">
                    <div class="col-md-3"><span class="text-muted">Status</span><div>{{ $shipment->provider_status ?? $shipment->status }}</div></div>
                    <div class="col-md-3"><span class="text-muted">Courier</span><div>{{ $shipment->courier_name }}</div></div>
                    <div class="col-md-3"><span class="text-muted">AWB</span><div>{{ $shipment->awb_code }}</div></div>
                    <div class="col-md-3"><span class="text-muted">Tracking</span><div><a href="{{ $shipment->tracking_url }}" target="_blank" rel="noopener">Track shipment</a></div></div>
                </div>
            @else
                @if (!$canCreateShipment)
                    <div class="alert alert-warning">Shipment creation is available after the prepaid payment is confirmed.</div>
                @elseif ($shipment && in_array($shipment->status, ['pending', 'processing'], true))
                    <div class="alert alert-info">Shipment request is {{ $shipment->status }}. Refresh this page shortly for the result.</div>
                @else
                    @if ($shipment && $shipment->last_error)
                        <div class="alert alert-danger">Previous attempt failed: {{ $shipment->last_error }}</div>
                    @endif
                    @if (!$order->shipping || !$order->shipping->zip)
                        <div class="alert alert-warning">A delivery address with postal code is required before shipment creation.</div>
                    @else
                        <p class="text-muted">Enter the packed parcel measurements, check available couriers, then select one to create the shipment and request an AWB.</p>
                        <form method="POST" action="{{ route('orders.shiprocket.store', $order) }}" id="shiprocket-form" data-couriers-url="{{ route('orders.shiprocket.couriers', $order) }}">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-sm-6 col-md-2">
                                    <label class="form-label" for="shipment-weight">Weight (kg)</label>
                                    <input class="form-control" id="shipment-weight" name="weight" type="number" min="0.01" step="0.001" required value="{{ old('weight', $shipment->weight ?? '') }}">
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <label class="form-label" for="shipment-length">Length (cm)</label>
                                    <input class="form-control" id="shipment-length" name="length" type="number" min="1" step="0.1" required value="{{ old('length', $shipment->length ?? '') }}">
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <label class="form-label" for="shipment-breadth">Breadth (cm)</label>
                                    <input class="form-control" id="shipment-breadth" name="breadth" type="number" min="1" step="0.1" required value="{{ old('breadth', $shipment->breadth ?? '') }}">
                                </div>
                                <div class="col-sm-6 col-md-2">
                                    <label class="form-label" for="shipment-height">Height (cm)</label>
                                    <input class="form-control" id="shipment-height" name="height" type="number" min="1" step="0.1" required value="{{ old('height', $shipment->height ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-light" type="button" id="find-couriers">Find couriers</button>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label" for="courier-id">Available couriers</label>
                                    <select class="form-select" id="courier-id" name="courier_id" required disabled>
                                        <option value="">Find couriers first</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success" type="submit" id="create-shipment" disabled>Create shipment and request AWB</button>
                                </div>
                                <div class="col-12" id="courier-message" role="status" aria-live="polite"></div>
                            </div>
                        </form>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endsection
@push('footer')
    <script>
        (() => {
            const form = document.getElementById('shiprocket-form');
            // alert('testing');
            if (!form) return;

            const courierSelect = document.getElementById('courier-id');
            const submitButton = document.getElementById('create-shipment');
            const message = document.getElementById('courier-message');

            document.getElementById('find-couriers').addEventListener('click', async () => {
                // alert('Finding couriers...');
                message.textContent = 'Checking serviceable couriers...';
                submitButton.disabled = true;
                courierSelect.disabled = true;

                const values = Object.fromEntries(new FormData(form).entries());
                try {
                    const response = await fetch(form.dataset.couriersUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(values)
                    });
                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || 'Could not retrieve courier options.');

                    courierSelect.replaceChildren(new Option('Select a courier', ''));
                    result.couriers.forEach((courier) => {
                        const delivery = courier.estimated_delivery ? ` · ${courier.estimated_delivery}` : '';
                        const rate = Number(courier.rate || 0).toFixed(2);
                        courierSelect.add(new Option(`${courier.name} · ₹${rate}${delivery}`, courier.id));
                    });

                    courierSelect.disabled = result.couriers.length === 0;
                    message.textContent = result.couriers.length ? 'Choose a courier to continue.' : 'No couriers are available for this parcel and address.';
                } catch (error) {
                    message.textContent = error.message;
                }
            });

            courierSelect.addEventListener('change', () => {
                submitButton.disabled = !courierSelect.value;
            });
        })();
    </script>
@endpush
