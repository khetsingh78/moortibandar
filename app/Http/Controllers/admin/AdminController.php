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
use Illuminate\Support\Facades\Log;
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
                $request->validate([
                    'heading' => 'required',
                    'sortdescription' => 'required',
                    'longdescription' => 'required',
                    'category' => 'required',
                    'discount' => 'required',
                    'gst' => 'required',
                    'height' => 'required',
                    'dimension' => 'required',
                    'marbaltype' => 'required',
                    'coverimagealt' => 'required',

                    "coverimageurl" => "required|mimes:jpeg,png,jpg,svg",
                    'allImagesOfProduct' => 'required|array',
                    'allImagesOfProduct.*' => 'required|mimes:jpeg,png,jpg,svg',
                ]);

                $coverimageurl = $request->file("coverimageurl")->store("product", 'public');
                $coverimageurl = asset($coverimageurl);

                $AllProductImageArray = [];
                foreach ($request->allImagesOfProduct as $key => $image) {
                    $imgpath = $image->store("prodcut_gallery", 'public');
                    $AllProductImageArray[] = asset($imgpath);
                }

                $product = Product::create([
                    'SKU' => "7877264322",
                    'title' => trim($request->heading),
                    'slug' => Str::slug(trim($request->heading), '-'),
                    'short_description' =>  trim($request->sortdescription),
                    'long_description' => trim($request->longdescription),
                    'category_id' => $request->category,
                    'discount_id' => $request->discount,
                    'gst_id' => $request->gst,
                    'height' => $request->height,
                    'dimension' => $request->dimension,
                    'marbaltype' => $request->marbaltype,
                    'paintingtype' => $request->paintingtype,
                    'cover_image' => trim($coverimageurl),
                    'alt_image' => trim($request->coverimagealt),
                ]);

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
                return redirect()->back()->with('SuccessMessage', 'Successfully  added.');
            } else {
                $category = Category::select('id', "name")->where('parent_id', '!=', null)->get();
                $discount = ProductDiscount::get();
                $gst = Gsttax::get();
                return view('admin/product/addProduct', compact('category', 'discount', 'gst'));
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with("ErrorMessage", "Something went wrong try again.")->withInput();
        }
    }


    public function editProduct(Request $request)
    {

        if ($request->isMethod('post')) {
            // dd($request->all());
            try {
                if ($request->updateType == "productDetails") {
                    $validator = $request->validate([
                        'heading' => 'required',
                        'sortdescription' => 'required',
                        'longdescription' => 'required',
                        'category' => 'required',
                        'discount' => 'required',
                        'gst' => 'required',
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
                    $isExist->gst_id = intval($request->gst);
                    $isExist->height = $request->height;
                    $isExist->dimension = $request->dimension;
                    $isExist->marbaltype = $request->marbaltype;
                    $isExist->paintingtype = $request->paintingtype;
                    $isExist->save();
                    return redirect()->back()->with("SuccessMessage", "Successfully Updated.");
                } elseif ($request->updateType == "inventory") {
                    $validator = $request->validate([
                        'quantity' => 'required',
                        'price' => 'required',
                    ]);

                    $inventory = ProductInventory::where('product_id', '=', $request->productId)->first();
                    $inventory->quantity = intval(trim($request->quantity));
                    $inventory->price = number_format((float)trim($request->price), 2, '.', '');
                    $inventory->save();
                    return redirect()->back()->with("SuccessMessage", "Successfully Updated Inventory");
                } elseif ($request->updateType == "coverImage") {
                    $isExist =  Product::findOrFail($request->productId);
                    $previous_img = explode($request->getSchemeAndHttpHost(), $isExist->cover_image)[1];
                    if (Storage::disk('public')->exists($previous_img)) {
                        Storage::disk('public')->delete($previous_img);
                    }
                    $cover_image_url = $request->file("coverimageurl")->store("product", 'public');
                    $cover_image_url = asset($cover_image_url);
                    $isExist->cover_image = $cover_image_url;
                    $isExist->save();
                    return redirect()->back()->with("SuccessMessage", "Successfully Updated.");
                } elseif ($request->updateType == "featuredImage") {
                    $images = [];
                    foreach ($request->allImagesOfProduct as $key => $image) {
                        $imgpath = $image->store("prodcut_gallery", 'public');
                        $images[] =  [
                            'product_id' => $request->productId,
                            'image_name' => asset($imgpath),
                            'image_alt' =>  trim($request->coverimagealt)
                        ];
                    }
                    $result =  ProductImages::insert($images);
                    return redirect()->back()->with('SuccessMessage', 'Updated successfully.');
                }
            } catch (\Throwable $th) {
                Log::info($th->getMessage());
                return redirect()->back()->with("ErrorMessage", "Something went wrong. try again.");
            }
        }
        $category = Category::select('id', "name", "parent_id")->where('parent_id', '!=', null)->get();
        $discount = ProductDiscount::get();
        $gst = Gsttax::get();
        $products = Product::with(['category', 'discount', 'gst', 'discount', 'inventory', 'images'])->findOrFail($request->productId);
        return view('admin/product/editProduct', compact('products', 'category', 'discount', 'gst'));
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
        $products = Product::with(['category', 'discount', 'gst', 'inventory', 'images'])->get();
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
