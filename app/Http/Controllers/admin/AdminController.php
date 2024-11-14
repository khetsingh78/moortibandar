<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductImages;
use App\Models\ProductInventory;
use Illuminate\Http\Request;
use App\Helper\ImageUpload;
use Spatie\FlareClient\Http\Exceptions\InvalidData;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('admin/dashboard');
    }

    //product methods

    public function addPrduct(Request $request)
    {

        if ($request->isMethod('post')) {


            $quantity = trim($request->quantity);
            $price = trim($request->price);
            $CoverImageName = ImageUpload::uploadImage($_FILES["coverimageurl"]);
            // print_r($CoverImageName); 

            if ($CoverImageName["status"] == "success") {
                $CoverImageName = $CoverImageName["newNameOfFile"];
            } else {
                echo $CoverImageName["message"];
            }

            $AllProductImageArray = ImageUpload::uploadImage($_FILES["allImagesOfProduct"]);
            if ($AllProductImageArray["status"] == "success") {
                $AllProductImageArray = $AllProductImageArray["allImage"];
            } else {
                echo $AllProductImageArray["message"];
            }
            // print_r($AllProductImageArray);
            // die();
            $images = [];

            // $isExist =  Category::where('name', $request->category)->exists();
            // if (!$isExist) {
            $product = Product::create([
                'SKU' => "7877264322",
                'title' => trim($request->heading),
                'short_description' =>  trim($request->sortdescription),
                'long_description' => trim($request->longdescription),
                'parent_category_id' => $request->parentcategory,
                'child_category_id' => $request->childcategory,
                'discount_id' => $request->discount,
                'SGST' => $request->sgst,
                'CGST' => $request->cgst,
                'height' => $request->height,
                'dimension' => $request->dimension,
                'marbaltype' => $request->marbaltype,
                'paintingtype' => $request->paintingtype,
                'cover_image' => trim($CoverImageName),
                'alt_image' => trim($request->coverimagealt),
            ]);


            if ($product->id !== "" && $product->id > 0) {

                $inventory =  ProductInventory::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);


                foreach ($AllProductImageArray as $key => $value) {
                    $images[] =  [
                        'product_id' => $product->id,
                        'image_name' => trim($value),
                        'image_alt' =>  trim($request->coverimagealt)
                    ];
                }
                // dd($images);
                $result =  ProductImages::insert($images);
                // print_r($images);
                // echo 'successfull';
            }


            // echo $product;
            return redirect()->back()->with('SuccessMessage', 'Successfully  added!');
            // } else {
            //     return redirect()->back()->with('ErrorMessage', 'Already Exists!');
            // }

        } else {
            $category = Category::get()->toArray();
            $discount = ProductDiscount::get()->toArray();


            // print_r($discount);
            return view('admin/product/addProduct', compact('category', 'discount'));
        }
    }


    public function editProduct(Request $request)
    {

        if ($request->isMethod('post')) {
            if (isset($request->id)) {
                $isExist =  Product::with("inventory")->find($request->id);
                // print_r($isExist);
                $isExist->title = trim($request->heading);
                $isExist->short_description =  trim($request->sortdescription);
                $isExist->long_description = trim($request->longdescription);
                $isExist->parent_category_id = intval($request->parentcategory);
                $isExist->child_category_id = intval($request->childcategory);
                $isExist->discount_id = intval($request->discount);
                $isExist->SGST = intval($request->sgst);
                $isExist->CGST = intval($request->cgst);
                $isExist->height = $request->height;
                $isExist->dimension = $request->dimension;
                $isExist->marbaltype = $request->marbaltype;
                $isExist->paintingtype = $request->paintingtype;

                $preQuantity = $isExist["inventory"]["quantity"];
                $prePrice = $isExist["inventory"]["price"];

                $result = $isExist->save();
                if ($result) {
                    if ($preQuantity !== intval($request->quantity) || $prePrice !== $request->price) {
                        $isInventory = ProductInventory::find($isExist["inventory"]["id"]);
                        $isInventory->quantity = $request->quantity;
                        $isInventory->price = $request->price;
                        $result = $isInventory->save();

                        return redirect()->route('admin.listProduct');
                    } else {
                        return redirect()->route('admin.listProduct');
                    }
                } else {
                    return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
                }
            } else {
                return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
            }
        } else {

            if (isset($request->productId)) {
                // echo "conditon is true";
                $result = Product::with("parentcategory", "childcategory", "discount", "inventory")->find($request->productId)->toArray();
                $category = Category::get()->toArray();
                $discount = ProductDiscount::get()->toArray();


                // print_r($result);
                return view('admin/product/editProduct', compact('result', 'category', 'discount'));
            } else {
                return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
            }
        }
        // return view('admin/product/editProduct');
    }

    public function listProduct(Request $request)
    {


        //$products = Product::get()->toArray();
        $products = Product::with(['parentcategory', 'childcategory', 'discount', 'inventory', 'images'])->get()->toArray();
        // print_r($products);
        // die();
        return view('admin/product/ListProduct', compact('products'));
    }

    //Category methods

    public function listCategory(Request $request)
    {
        $categoryList = Category::get()->toArray();

        // print_r($categoryList, );
        return view('admin/product/allCategory', compact('categoryList'));
    }
    public function addCategory(Request $request)
    {

        if ($request->isMethod('post')) {


            // print_r($request->all());
            // die();
            // $category = Category::all();

            //    echo var_dump($category);


            $isExist =  Category::where('name', $request->category)->exists();
            if (!$isExist) {
                $user = Category::create([
                    'name' => $request->category,
                    'description' => $request->description,
                    'type' => $request->type,
                ]);
                return redirect()->back()->with('SuccessMessage', 'Added Successfully!');
            } else {
                return redirect()->back()->with('ErrorMessage', 'Already Exists!');
            }
        } else {
            return view('admin/product/addCategory');
        }
    }

    public function editCategory(Request $request)
    {

        if ($request->isMethod('post')) {
            if (isset($request->id)) {
                $isExist =  Category::find($request->id);
                // print_r($isExist);
                $isExist->name = $request->category;
                $isExist->description = $request->description;
                $result = $isExist->save();
                // echo $request;

                return redirect()->route('admin.listCategory');
                // return view('admin/product/editCategory', compact('result'));

            } else {
                return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
            }
        } else {

            if (isset($request->category)) {
                // echo "conditon is true";
                $result = Category::find($request->category)->toArray();
                // print_r($result);
                return view('admin/product/editCategory', compact('result'));
            } else {
                return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
            }
        }
    }

    public function deletedCategory(Request $request)
    {

        if (isset($request->category)) {
            $isExist =  Category::find($request->category)->delete();
            // print_r($isExist);
            // echo $request;

            return redirect()->route('admin.listCategory');
            // return view('admin/product/editCategory', compact('result'));

        } else {
            return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
        }
    }
}
