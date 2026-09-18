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


    //Category methods


}
