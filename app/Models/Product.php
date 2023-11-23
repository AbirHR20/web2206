<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
    function rel_to_cate() {
        return $this->belongsTo(Category::class,'category_id');
    }
    function rel_to_subcate() {
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }
    function rel_to_brand() {
        return $this->belongsTo(Brand::class,'brand_id');
    }
    function rel_to_inventory() {
        return $this->hasMany(Inventory::class,'product_id');
    }
}
