<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderDetails;
use Livewire\Component;

class AdminOrder extends Component
{
    public $selectedOrderId;
    public $cancelReason;
    public $selectedStatus;
    public $selectedFilter;
    public $searchTerm = '';
    public function updateStatus($order_id, $status)
    {
        $order = Order::find($order_id);
        $order->trang_thai = $status;

        $order->save();
        session()->flash('message', 'Update status successfully');
    }
    public function updateStatusDelivery($order_id, $status_delivery)
    {
        $order = Order::find($order_id);
        $order->tinh_trang_giao_hang = $status_delivery;
        if ($status_delivery === 'canceled') {
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
        if ($status_delivery === 'delivering') {
            $order->trang_thai = 1;
        }
        $order->save();
        session()->flash('message', 'Cập nhập trạng thái đơn hàng thành công');
    }
    public function submitCancelReason()
    {
        if( $this->cancelReason == ''){
          return  session()->flash('required', 'Vui lòng nhập lý do');
        }
        $order = Order::find($this->selectedOrderId);
        if ($order) {
            $order->tinh_trang_giao_hang = 'canceled';
            $order->li_do_huy_don = $this->cancelReason;
            $order->save();

            // Reset cancel reason and order ID after submission
            $this->cancelReason = '';
            $this->selectedOrderId = null;

            $this->emit('closeCancelModal');
            session()->flash('message', 'Đã cập nhật lý do hủy đơn hàng thành công.');
        }
    }
    public function render()
    {
        $query = Order::query();

        // Lọc theo trạng thái đơn hàng nếu có lựa chọn
        if ($this->selectedStatus) {
            $query->where('tinh_trang_giao_hang', $this->selectedStatus);
        }
        switch ($this->selectedFilter) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'lowest_price':
                $query->orderBy('tong_tien', 'asc');
                break;
            case 'highest_price':
                $query->orderBy('tong_tien', 'desc');
                break;
            default:
                // No filter selected
                break;
        }
        // Tìm kiếm theo mã đơn hàng nếu có nhập vào ô tìm kiếm
        if ($this->searchTerm) {
            $search = '%' . $this->searchTerm . '%';
            $query->where('ma_don_hang', 'LIKE', $search);
        }

        // Sắp xếp theo ngày tạo giảm dần
        $orders = $query->paginate(10);
            
        return view('livewire.admin.admin-order', ['orders' => $orders]);
    }
}
