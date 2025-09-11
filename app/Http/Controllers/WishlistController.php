<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{

    public function index()
    {
        $data = $this->wishlistDetails();
        // dd($data);
        return view('wishlist.index', compact('data'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {

            $product = Product::with('inventory')->findOrFail($request->id);
            CartFacade::session('wishlist')->add([
                'id'         => $product->id,
                'name'       => $product->title,
                'price'      => $product->inventory->price,
                'quantity'   => 1,
                'attributes' => ["image" => $product->cover_image],
            ]);

            $data = $this->wishlistDetails();
            return response()->json(["status" => "success", "message" => "Item added wishlist.", "data" => $data]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong."]);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id) {}


    public function destroy($id)
    {
        try {
            CartFacade::session('wishlist')->remove($id);
            return response()->json(["status" => "success", "message" => "Item removed successfully."]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(["status" => "error", "message" => "Something went wrong."]);
        }
    }

    public function wishlistDetails()
    {
        return [
            "count" => CartFacade::session('wishlist')->getTotalQuantity(),
            "data" => CartFacade::session('wishlist')->getContent()
        ];
    }
}
