<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $table='san_pham_attributes';
    public function attributeValues(){
        return $this->hasMany(AttributeValue::class);
    }
}
