<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'discount', 'gst', 'inventory', 'images'])->latest()->get();
        // dd(json_decode($products));
        return view('welcome', compact('products'));
    }

    public function shop(Request $request)
    {

        if (isset($request->subcategory)) {
            $name = $request->subcategory;
        } else {
            $name = $request->category;
        }

        $category = Category::with('childCategories')->where('parent_id', null)->get();
        if ($name == "all-product") {
            $products = Product::with(['category', 'discount', 'gst', 'inventory'])
                ->paginate(20);
        } else {
            $products = Product::with(['category', 'discount', 'gst', 'inventory'])
                ->whereHas('category', function ($query) use ($name) {
                    $query->where('name', $name);
                })->paginate(20);
        }

        return view('shop', compact('products', 'category'));
    }

    public function productDetails(Request $request)
    {

        $product = Product::with(['category', 'discount', 'gst', 'inventory', 'images'])->where("slug", '=', $request->slug)->firstOrFail();
        $relevant = Product::with(['discount', 'gst',])->where("category_id", '=', $product->category_id)->get();

        return view('product-details', compact('product', 'relevant'));
    }

       public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                Contact::create([
                    "name" => $request->name,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "subject" => $request->subject,
                    "message" => $request->message
                ]);
                return back()->with("SuccessMessage", "Inquire has beed sent.");
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return back()->with("ErrorMessage", "Something went wrong try again.");
            }
        }

        return view('contact');
    }
}
