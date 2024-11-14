<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['parentcategory', 'childcategory', 'discount', 'inventory', 'images'])->get()->toArray();
        // print_r($products);
        // die();
        return view('welcome', compact('products'));
    }
    public function shop(Request $request)
    {

        $category = $request->category;
        $subcategory = $request->subcategory;

        if (isset($subcategory)) {
            $catid = Category::where('name', '=', $subcategory)->first()->toArray();
            $columnname = "child_category_id";
        } else {
            $catid = Category::where('name', '=', $category)->first()->toArray();
            $columnname = "parent_category_id";
        }
        $products = Product::with(['parentcategory', 'childcategory', 'discount', 'inventory', 'images'])->where([
            [$columnname, '=', $catid],
            // ['child_category_id', '=', $childcategory],
        ])->get()->toArray();

        if (count($products) > 0) {
            return view('shop', compact('products', 'category'));
        } else {
            echo "Records Not Found";
        }
    }

    public function productDetails(Request $request)
    {

        $category = $request->category;
        $childcategory = $request->childcategory;
        $title = $request->title;


        $products = Product::with(['parentcategory', 'childcategory', 'discount', 'inventory', 'images'])->where([
            // ['parent_category_id', '=', $category],
            // ['child_category_id', '=', $childcategory],
            ['title', '=', $title],
        ])->get()->toArray();

        $relevant = Product::with(['parentcategory', 'childcategory', 'discount', 'inventory', 'images'])->where([
            ['title', 'like', "%{$title}%"],
            // ['child_category_id', '=', $childcategory],
        ])->get()->toArray();

        // print_r($relevant);
        // die();
        if ($products) {
            return view('product-details', compact('products', 'relevant'));
        }
    }

    public function shopCart(Request $request)
    {

        // $subcategory = $request->subcategory;

        return view('shop-cart');
    }
    public function checkout(Request $request)
    {

        return view('checkout');
    }
    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            print_r($request->all());
            die();
        }

        return view('contact');
    }

    public function login(Request $request)
    {

        if (Auth::check()) {
            if (Auth::user()->role == 'user') {
                return redirect()->route('user.profile');
            } elseif (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
        } else {
            return view('admin/login');
        }
    }

    public function register(Request $request)
    {


        // if ($request->isMethod('post')) {
        // }
        return view('admin/register');
    }




    //login method with details verification

    public function loginRequest(Request $request)
    {
        // Retrieve data from the request
        $email = $request->input('email');
        $password = $request->input('password');

        if (!empty($email) && !empty($password)) {

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Authentication passed...
                // return redirect()->intended('dashboard');
                $responseData = [
                    'status' => 200,
                    'message' => 'Login successfully',
                    'data' => [
                        'text' => "Show description"
                    ],
                ];
            } else {

                $responseData = [
                    'status' => 400,
                    'message' => 'Invalid Credencial',
                    'data' => [
                        'text' => "Show description"
                    ],
                ];
            }
        } else {
            $responseData = [
                'status' => 400,
                'message' => "Invalid Detail's"
            ];
        }

        return response()->json($responseData);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->to('/');
    }
}
