<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table="danh_muc";
    protected $fillable=[
        'ten'
    ];
    public function products()
    {
        return $this->hasMany(Product::class,'danh_muc_id');
    }
    public function subCategories(){
        return $this->hasMany(Subcategory::class,'category_id');
    }
}
