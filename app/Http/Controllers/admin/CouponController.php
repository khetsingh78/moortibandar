<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CouponDataTable $dataTable)
    {
        // dd($dataTable);
        // return view('admin.coupon.index');
        return $dataTable->render('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
            'expire_at' => 'required',
        ]);

        Coupon::create([
            "title" => $request->title,
            "code" => $request->code,
            "type" => $request->type,
            "value" => $request->value,
            "expire_at" => $request->expire_at,
        ]);

        return redirect()->back()->with('SuccessMessage', "Coupon created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $coupon = Coupon::find($id);
        // dd($coupon);

        return view('admin.coupons.edit', compact('coupon'));
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
        // dd($id);
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
            'expire_at' => 'required',
        ]);

        // Coupon::create([
        //     "title" => $request->title,
        //     "code" => $request->code,
        //     "type" => $request->type,
        //     "value" => $request->value,
        //     "expire_at" => $request->expire_at,
        // ]);
        $coupon = Coupon::find($id);
        $coupon->title = $request->title;
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->expire_at = $request->expire_at;
        $coupon->save();

        return redirect()->back()->with('SuccessMessage', "Coupon is updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $isDeleted =  Coupon::destroy($id);
        // dd($isDeleted);
        if (!$isDeleted) {

            return redirect()->back()->with('ErrorMessage', "Somthing Went wrong.");
        }

        return redirect()->back()->with('SuccessMessage', "Coupon is updated successfully.");
    }
}
