<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_category';

    protected $guarded = [];

    public function childCategories()
    {
        return $this->hasMany(Category::class, "parent_id");
    }

    public function parentCategory() {
        return $this->belongsTo(Category::class, "parent_id");
    }
}
