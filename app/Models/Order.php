<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table ="don_hang";
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class,'don_hang_id');
    }
    public function translateTinhTrangGiaoHang($value){
        switch ($value) {
            case 'ordered':
                return 'Đã đặt hàng';
            case 'accepted':
                return 'Đã chấp nhận';
            case 'delivering':
                return 'Đang giao hàng';
            case 'delivered':
                return 'Đã giao hàng';
            case 'canceled':
                return 'Đã hủy';
            default:
                return $value;
        }
    }
}
