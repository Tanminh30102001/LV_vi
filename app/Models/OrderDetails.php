<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table="don_hang_chi_tiet";
    public function order(){
        return $this->belongsTo(Order::class,'don_hang_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'san_pham_id');
    }
    public function review(){
        return $this->hasOne(Review::class,'don_hang_detail_id');
    }
}
