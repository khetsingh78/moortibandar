<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $guarded = [];
    // protected $fillable = [
    //     'title',
    //     'short_description',
    //     'SKU',
    //     'cover_image',
    //     'image_alt',
    //     'category_id',
    //     'inventory_id',
    //     'discount_id',
    //     'long_description',
    // ];

    public function parentcategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }
    public function childcategory()
    {
        return $this->belongsTo(Category::class, 'child_category_id', 'id');
    }
    public function discount()
    {
        return $this->belongsTo(ProductDiscount::class, 'discount_id', 'id');
    }
    // public function SGST()
    // {
    //     return $this->belongsTo(ProductDiscount::class, 'discount_id', 'id');
    // }

    public function inventory()
    {
        return $this->hasOne(ProductInventory::class, 'product_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }
}
