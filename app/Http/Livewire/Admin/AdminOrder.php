<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderDetails;
use Livewire\Component;

class AdminOrder extends Component
{
    public function updateStatus($order_id,$status){
        $order=Order::find($order_id);
        $order->trang_thai=$status;
        $order->save();
        session()->flash('message','Update status successfully');
    }
    public function updateStatusDelivery($order_id,$status_delivery){
        $order=Order::find($order_id);
        $order->tinh_trang_giao_hang=$status_delivery;
        if($status_delivery==='canceled'){
            $orderDetails = $order->orderDetails()->with('product')->get();
            foreach ($orderDetails as $orderDetail) {
                $product = $orderDetail->product;
    
                // Đảm bảo sản phẩm tồn tại
                if ($product) {
                    $product->so_luong += $orderDetail->so_luong;
                    $product->save();
                }
            }
        }
        $order->save();
        session()->flash('message','Update status of Delivery successfully');
    }
    public function render()
    {
        $orders=Order::orderBy('created_at','DESC')->paginate(10);
        return view('livewire.admin.admin-order',['orders'=>$orders]);
    }
}
