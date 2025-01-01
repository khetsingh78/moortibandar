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
use App\Models\Gsttax;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\Http\Exceptions\InvalidData;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('admin/dashboard');
    }

    //product methods

    public function addPrduct(Request $request)
    {
        try {

            if ($request->isMethod('post')) {
                // dd(request()->all());
                $validator = $request->validate([
                    "coverimageurl" => "required|mimes:jpeg,png,jpg,svg",
                    'allImagesOfProduct' => 'required|array', // Ensure it's an array
                    'allImagesOfProduct.*' => 'required|mimes:jpeg,png,jpg,svg',
                    'heading' => 'required',
                    'sortdescription' => 'required',
                    'longdescription' => 'required',
                    // 'parentcategory' => 'required',
                    'category' => 'required',
                    'discount' => 'required',
                    'sgst' => 'required',
                    'cgst' => 'required',
                    'cgst' => 'required',
                    'height' => 'required',
                    'dimension' => 'required',
                    'marbaltype' => 'required',
                    'coverimagealt' => 'required',

                ]);

                $coverimageurl = $request->file("coverimageurl")->store("public/products/coverImage");
                $coverimageurl = removeStorageFolderaImage($coverimageurl);
                // $coverimageurl = Storage::url($coverimageurl);
                $AllProductImageArray = [];
                foreach ($request->allImagesOfProduct as $key => $image) {
                    $imgpath = $image->store("public/products/featuredImage");
                    $imgpath = removeStorageFolderaImage($imgpath);
                    $AllProductImageArray[] = $imgpath;
                }

                $product = Product::create([
                    'SKU' => "7877264322",
                    'title' => trim($request->heading),
                    'slug' => Str::slug(trim($request->heading), '-'),
                    'short_description' =>  trim($request->sortdescription),
                    'long_description' => trim($request->longdescription),
                    'category_id' => $request->category,
                    'discount_id' => $request->discount,
                    'sgst_id' => $request->sgst,
                    'cgst_id' => $request->cgst,
                    'height' => $request->height,
                    'dimension' => $request->dimension,
                    'marbaltype' => $request->marbaltype,
                    'paintingtype' => $request->paintingtype,
                    'cover_image' => trim($coverimageurl),
                    'alt_image' => trim($request->coverimagealt),
                ]);


                if ($product->id !== "" && $product->id > 0) {

                    $inventory =  ProductInventory::create([
                        'product_id' => $product->id,
                        'quantity' => intval(trim($request->quantity)),
                        'price' => number_format((float)trim($request->price), 2, '.', ''),
                    ]);

                    $images = [];
                    foreach ($AllProductImageArray as $key => $value) {
                        $images[] =  [
                            'product_id' => $product->id,
                            'image_name' => trim($value),
                            'image_alt' =>  trim($request->coverimagealt)
                        ];
                    }
                    $result =  ProductImages::insert($images);
                    return redirect()->back()->with('SuccessMessage', 'Successfully  added!');
                } else {

                    return redirect()->back()->with('ErrorMessage', 'Something went wrong!');
                }
            } else {


                $category = Category::select('id', "name", "parent_id")->get()->toArray();
                $discount = ProductDiscount::get();
                $gst = Gsttax::get();

                $category = array_filter($category, function ($value) {
                    if (isset($value["parent_id"])) {
                        return  $value;
                    }
                });
                // $parentCategory = array_filter($category, function ($value) {
                //     if (!isset($value["parent_id"])) {
                //         return  $value;
                //     }
                // });

                return view('admin/product/addProduct', compact('category', 'discount', 'gst'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with("ErrorMessage", $th->getMessage());
            // die($th->getMessage());
        }
    }


    public function editProduct(Request $request)
    {

        try {
            if ($request->isMethod('post')) {

                if (isset($request->productId)) {
                    if ($request->updateType == "productDetails") {
                        $validator = $request->validate([
                            'heading' => 'required',
                            'sortdescription' => 'required',
                            'longdescription' => 'required',
                            'category' => 'required',
                            'discount' => 'required',
                            'sgst' => 'required',
                            'cgst' => 'required',
                            'cgst' => 'required',
                            'height' => 'required',
                            'dimension' => 'required',
                            'marbaltype' => 'required',

                            // 'allImagesOfProduct' => 'required|array',
                            // 'allImagesOfProduct.*' => 'required|mimes:jpeg,png,jpg,svg',

                        ]);

                        $isExist =  Product::findOrFail($request->productId);
                        $isExist->title = trim($request->heading);
                        $isExist->short_description =  trim($request->sortdescription);
                        $isExist->long_description = trim($request->longdescription);
                        $isExist->category_id = intval($request->category);
                        $isExist->discount_id = intval($request->discount);
                        $isExist->sgst_id = intval($request->sgst);
                        $isExist->cgst_id = intval($request->cgst);
                        $isExist->height = $request->height;
                        $isExist->dimension = $request->dimension;
                        $isExist->marbaltype = $request->marbaltype;
                        $isExist->paintingtype = $request->paintingtype;
                        $isExist->save();
                        return redirect()->back()->with("SuccessMessage", "Successfully Updated!");
                    } elseif ($request->updateType == "inventory") {
                        $validator = $request->validate([
                            'quantity' => 'required',
                            'price' => 'required',
                        ]);

                        $inventory = ProductInventory::where('product_id', '=', $request->productId)->first();
                        $inventory->quantity = intval(trim($request->quantity));
                        $inventory->price = number_format((float)trim($request->price), 2, '.', '');
                        $inventory->save();
                        return redirect()->back()->with("SuccessMessage", "Successfully Updated Inventory!");
                    } elseif ($request->updateType == "coverimageurl") {
                        dd($request->updateType);
                    } elseif ($request->updateType == "featuredImage") {
                        dd($request->updateType);
                    }


                    // $isExist =  Product::with("inventory")->find($request->id);
                    // print_r($isExist);
                    // $isExist->title = trim($request->heading);
                    // $isExist->short_description =  trim($request->sortdescription);
                    // $isExist->long_description = trim($request->longdescription);
                    // $isExist->parent_category_id = intval($request->parentcategory);
                    // $isExist->child_category_id = intval($request->childcategory);
                    // $isExist->discount_id = intval($request->discount);
                    // $isExist->SGST = intval($request->sgst);
                    // $isExist->CGST = intval($request->cgst);
                    // $isExist->height = $request->height;
                    // $isExist->dimension = $request->dimension;
                    // $isExist->marbaltype = $request->marbaltype;
                    // $isExist->paintingtype = $request->paintingtype;

                    // $preQuantity = $isExist["inventory"]["quantity"];
                    // $prePrice = $isExist["inventory"]["price"];

                    // $result = $isExist->save();
                    // if ($result) {
                    //     if ($preQuantity !== intval($request->quantity) || $prePrice !== $request->price) {
                    //         $isInventory = ProductInventory::find($isExist["inventory"]["id"]);
                    //         $isInventory->quantity = $request->quantity;
                    //         $isInventory->price = $request->price;
                    //         $result = $isInventory->save();

                    //         return redirect()->route('admin.listProduct');
                    //     } else {
                    //         return redirect()->route('admin.listProduct');
                    //     }
                    // } else {
                    //     return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
                    // }


                } else {
                    return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
                }
            } else {

                if (isset($request->productId)) {
                    $category = Category::select('id', "name", "parent_id")->get()->toArray();
                    $discount = ProductDiscount::get();
                    $gst = Gsttax::get();

                    $category = array_filter($category, function ($value) {
                        if (isset($value["parent_id"])) {
                            return  $value;
                        }
                    });

                    $products = Product::with(['category', 'discount', 'sgst', 'cgst', 'discount', 'inventory', 'images'])->find($request->productId);
                    // dd($products);
                    if ($products) {
                        return view('admin/product/editProduct', compact('products', 'category', 'discount', 'gst'));
                    }
                } else {
                    return redirect()->back()->with('ErrorMessage', 'Invalid Details!');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with("ErrorMessage", $th->getMessage());
        }
    }

    public function deleteProduct(Request $request)
    {
        try {

            if (isset($request->productId)) {
                $featuredImage = ProductImages::where('product_id', '=', $request->productId)->get()->toArray();
                foreach ($featuredImage as $key => $value) {
                    if (Storage::disk('public')->exists($value["image_name"] ?? false)) {
                        dd("file extis");
                        // Storage::disk('public')->delete($value["image_name"] ?? false);
                    }
                }
                dd($featuredImage);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with("ErrorMessage", $th->getMessage());
        }
    }

    public function viewProduct(Request $request)
    {
        try {

            if (isset($request->productId)) {
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with("ErrorMessage", $th->getMessage());
        }
    }

    public function listProduct(Request $request)
    {

        try {
            $products = Product::with(['category', 'discount', 'sgst', 'cgst', 'inventory', 'images'])->get();
            if (count($products) > 0) {
                return view('admin/product/ListProduct', compact('products'));
            }
            return redirect()->back()->with("ErrorMessage", "Product not found");
        } catch (\Throwable $th) {
            return redirect()->back()->with("ErrorMessage", $th->getMessage());
        }
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
