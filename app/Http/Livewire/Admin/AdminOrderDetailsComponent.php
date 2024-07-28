<?php

namespace App\Http\Livewire\Admin;
use Cart;
use App\Models\Order;
use Livewire\Component;

class AdminOrderDetailsComponent extends Component
{
    public $order_id;
    public function mount($order_id){
        $this->order_id=$order_id;
    }
    public function render()
    {
        $order = Order::with(['orderDetails' => function ($query) {
            $query->withTrashed()->with(['product' => function ($q) {
                $q->withTrashed();
            }]);
        }])->find($this->order_id);
        return view('livewire.admin.admin-order-details-component',['order'=>$order]);
    }
}
