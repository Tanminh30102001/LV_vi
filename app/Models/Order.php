<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table ="don_hang";
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderDetails(){
        return $this->hasMany(OrderDetails::class,'don_hang_id')->withTrashed();
    }
    public function translateTinhTrangGiaoHang($value){
        switch ($value) {
            case 'ordered':
                return 'Đang chờ xác nhận';
            case 'accepted':
                return 'Đã xác nhận';
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
