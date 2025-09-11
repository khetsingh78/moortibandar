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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(ProductDiscount::class, 'discount_id', 'id');
    }
    public function gst()
    {
        return $this->belongsTo(Gsttax::class, 'gst_id', 'id');
    }

    public function inventory()
    {
        return $this->hasOne(ProductInventory::class, 'product_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }
}
