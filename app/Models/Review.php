<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table="danh_gia";
    public function orderDetails(){
        return $this->belongsTo(OrderDetails::class);
    }
}
