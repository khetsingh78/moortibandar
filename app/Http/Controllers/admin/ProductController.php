<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gsttax;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductImages;
use App\Models\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::select('id', "name")->where('parent_id', '!=', null)->get();
        $discount = ProductDiscount::get();
        // dd(json_decode($discount));
        $gst = Gsttax::get();
        return view('admin.products.create', compact('category', 'discount', 'gst'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'heading' => 'required',
                'sortdescription' => 'required',
                'longdescription' => 'required',
                'category' => 'required',
                // 'discount' => 'required',
                // 'gst' => 'required',
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
                // 'discount_id' => $request->discount,
                // 'gst_id' => $request->gst,
                'height' => $request->height,
                'dimension' => $request->dimension,
                'marbaltype' => $request->marbaltype,
                'paintingtype' => $request->paintingtype,
                'cover_image' => trim($coverimageurl),
                'alt_image' => trim($request->coverimagealt),
            ]);

            ProductInventory::create([
                'product_id' => $product->id,
                'quantity' => intval(trim($request->quantity)),
                'price' => number_format((float)trim($request->price), 2, '.', ''),
                "discount_type" => $request->discount_type,
                "discount_value" => (float)trim($request->discount_value ?? 00),
                "gsttax" => (float)trim($request->gsttax ?? 00),
            ]);

            $images = [];
            foreach ($AllProductImageArray as $key => $value) {
                $images[] =  [
                    'product_id' => $product->id,
                    'image_name' => trim($value),
                    'image_alt' =>  trim($request->coverimagealt)
                ];
            }
            ProductImages::insert($images);
            return redirect()->back()->with('SuccessMessage', 'Successfully  added.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with("ErrorMessage", "Something went wrong try again.")->withInput();
        }
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
        $category = Category::select('id', "name", "parent_id")->where('parent_id', '!=', null)->get();
        $discount = ProductDiscount::get();
        $gst = Gsttax::get();
        $products = Product::with(['category', 'gst', 'inventory', 'images'])->findOrFail($id);
        // dd(json_decode($products));
        return view('admin.products.edit', compact('products', 'category', 'discount', 'gst'));
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
                // dd($request->all());
                $validator = $request->validate([
                    'quantity' => 'required',
                    'price' => 'required',
                ]);

                $inventory = ProductInventory::where('product_id', '=', $request->productId)->first();
                $inventory->quantity = intval(trim($request->quantity));
                $inventory->price = number_format((float)trim($request->price), 2, '.', '');
                $inventory->discount_type = $request->discount_type;
                $inventory->discount_value = (float)trim($request->discount_value);
                $inventory->gsttax = (float)trim($request->gsttax);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with("successMessage", "Deleted successfully.");
    }
}
