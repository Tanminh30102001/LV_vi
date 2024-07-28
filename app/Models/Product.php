<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="san_phams";
    public function category()
    {
        return $this->belongsTo(Category::class,'danh_muc_id');
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class,'san_pham_id')->withTrashed();
    }
    public function subCategories(){
        return $this->belongsTo(Subcategory::class,'subdanh_muc_id');
    }
    public function attributeValues(){
        return $this->hasMany(AttributeValue::class,'product_id');
    }
}
