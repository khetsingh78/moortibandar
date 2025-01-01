<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'discount', 'sgst', 'cgst', 'inventory', 'images'])->get();
        // print_r($products);
        // die();
        return view('welcome', compact('products'));
    }

    public function shop(Request $request)
    {

        $category = $request->category;

        // echo $category ;



        // $id = Category::where("name", $request->category)->first();
        // $ids = Category::where("parent_id", $id->id)->pluck("id");

        $id = Category::with("childCategories")->where("name", $request->category)->firstOrFail()->toArray();
        $ids = array_map(function ($item) {
            return $item["id"];
        }, $id["child_categories"]);

        $products = Product::with(['category', 'discount', 'sgst', 'cgst', 'inventory', 'images'])->whereIn('category_id', $ids)->get();
        // dd($products);


        // $products = Product::with(['parentcategory', 'childcategory', 'discount', 'inventory', 'images'])->where([
        //     [$columnname, '=', $catid],
        //     // ['child_category_id', '=', $childcategory],
        // ])->get()->toArray();

        // if (count($products) > 0) {
            return view('shop', compact('products', 'category'));
        // } else {
        //     echo "Records Not Found";
        // }

    }

    public function productDetails(Request $request)
    {


        $product = Product::with(['category', 'discount', 'sgst', 'cgst', 'inventory', 'images'])->where("slug", '=', $request->slug)->firstOrFail();
        $relevant = [];
        return view('product-details', compact('product', 'relevant'));
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


        if ($request->isMethod("post")) {

            $validator = $request->validate([
                "email" => "required|max:225",
                "password" => "required"
            ]);

            try {

                $isExits = User::where("email", $validator["email"])->first();
                if ($isExits) {
                    if (!$isExits["email_verified_at"]) {
                        return "send email to verify the";
                    } else {

                        if (Auth::attempt($validator, true)) {

                            $result = User::select("id")->with("roles:id,name", "roles.permissions:id,name")->find(Auth::user()->id)->toArray();

                            Session::put("roleName", $result["roles"][0]["name"]);
                            Session::put("rolePermission", $result["roles"][0]["permissions"]);
                            if ($result["roles"][0]["name"] === "user") {
                                return redirect("/")->with("SuccessMessage", "User is logged successfully!");
                            }
                            return redirect()->route("admin.dashboard")->with("SuccessMessage", "Admin is logged successfully!");
                        } else {

                            return redirect("/login")->with("ErrorMessage", "User details are invalid!");
                        }

                        // $Email = $validator["email"];
                        // return view("admin/otp", compact("Email"));
                    }
                }
            } catch (\Throwable $th) {
                return redirect()->back()->with("ErrorMessage", "Something went wrong try again!.");
            }
        }
        // dd("login page");
        return view('admin/login');
    }

    public function register(Request $request)
    {


        if ($request->isMethod('post')) {

            $validator = $request->validate([
                "name" => 'required|max:225',
                "email" => 'required|unique:users,email',
                "password" => 'required'
            ]);


            try {
                $user = User::create([
                    "name" => $validator["name"],
                    "email" => $validator["email"],
                    "password" => bcrypt($validator["password"])
                ]);


                // if (Auth::attempt($validator)) {
                return redirect("/")->with("SuccessMessage", "Add email verification functionality");
                // } else {
                //     return redirect("/login")->with("SuccessMessage", "registered successfully!");
                // }
            } catch (\Throwable $th) {
                return redirect()->back()->with("ErrorMessage", "Can't register");
                // echo "exception is executed";
            }
        }

        return view('admin/register');
    }
    public function VerifyOtp(Request $request)
    {


        if ($request->isMethod('post')) {

            $validator = $request->validate([
                "email" => 'required|unique:users,email',
                "otp" => 'required|max:6'
            ]);


            try {


                // if (Auth::attempt($validator)) {
                //     return redirect("/")->with("SuccessMessage", "registered successfully!");
                // } else {
                //     return redirect("/login")->with("SuccessMessage", "registered successfully!");
                // }
                return print_r($request);
            } catch (\Throwable $th) {
                return redirect()->back()->with("ErrorMessage", "Can't Verify Try Again!.");
                // echo "exception is executed";
            }
        }

        return view('admin/otp');
    }

    public function logout(Request $request)
    {
        // print_r(Auth::user());
        $request->session()->flush();
        Auth::logout();
        return redirect()->to('/');
    }
}
