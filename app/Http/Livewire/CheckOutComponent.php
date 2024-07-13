<?php

namespace App\Http\Livewire;

use App\Mail\confirmOrderMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CheckOutComponent extends Component
{

    public $user_name;
    public $user_phone;
    public $user_address;
    public $notes;
    public $status = false;
    public $process = false;
    public $couponcode;
    public $discount;
    public $subtotalAfterDiscount;
    public $totalAfterDiscount;

    public function updated($field)
    {
        $this->validateOnly($field, [

            'user_name' => 'required',
            'user_phone' => "required|numeric",
            "user_address" => "required",
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
    }
    public function applyCoupon()
    {  

        $coupon = Coupon::where('ma_phieu', $this->couponcode)
        ->where('expiry_date', '>=', Carbon::today())
        ->first();
       
        if (!$coupon) {
            session()->flash('cp_mess', 'Code coupon invalid');
            return;
        }
        if ($coupon->gia_tri_gio_hang > Cart::instance('cart')->subtotal()){
            session()->flash('cp_mess', 'Code coupon invalid');
        }
        session()->put('coupon', [
            'code' => $coupon->ma_phieu,
            'type' => $coupon->loai,
            'value' => $coupon->gia_tri,
            'cart_value' => $coupon->gia_tri_gio_hang
        ]);
        // dd(session()->get('coupon'));
        session()->flash('cp_applied', 'Coupon applied');
        return redirect(route('shop.checkout'));
    }
    public function calculateDiscount()
    {
        if (session()->has('coupon')) {
            if (session()->get('coupon')['type'] == 'fixed') {
                $this->discount = floatval(session()->get('coupon')['value']);
                // dd($this->discount);
                session()->put('checkout', [
                    'discount' =>  $this->discount,
                ]);
            } else {
                $this->discount=intval(str_replace(',', '', Cart::instance('cart')->subtotal())) * intval(session()->get('coupon')['value'])/100;
                // dd($this->discount);
                session()->put('checkout', [
                    'discount' =>  $this->discount,
                ]);
            }
            $this->subtotalAfterDiscount = intval(str_replace(',', '', Cart::instance('cart')->subtotal())) - intval( $this->discount);
            // dd(intval(str_replace(',', '', Cart::instance('cart')->subtotal())));
            $this->totalAfterDiscount = $this->subtotalAfterDiscount + config('cart.tax');
            session()->put('checkout', [
                'discount' =>  $this->discount,
                'subtotal'=>Cart::instance('cart')->subtotal(),
                'total' =>  $this->totalAfterDiscount,
            ]);
        }
    }
    public function placeOrder()
{
    $this->validate([
        'user_phone' => "required|numeric",
        "user_address" => "required",
    ]);

    // Tạo đơn hàng mới
    $order = new Order();
    $order->user_id = Auth::user()->id;
    $order->ma_don_hang = rand(1000, 999999999);

    // Tính toán tổng tiền, giảm giá, và tạm tính
    if (session()->has('coupon')) {
        $order->tong_tien = str_replace(',', '', session()->get('checkout')['total']);
        $order->giam_gia = session()->get('checkout')['discount'];
        $order->tam_tinh = session()->get('checkout')['subtotal'];
    } else {
        $order->tong_tien = str_replace(',', '', Cart::instance('cart')->total());
        $order->giam_gia = session()->get('checkout')['discount'] ?? 0;
        $order->tam_tinh = Cart::instance('cart')->subtotal();
    }

    // Thông tin người dùng và ghi chú
    $order->email = Auth::user()->email;
    $order->user_ten = Auth::user()->ten;
    $order->user_sdt = $this->user_phone;
    $order->user_diachi = $this->user_address;
    $order->ghi_chu = $this->notes;
    $order->trang_thai = false; 

    $order->save();


    foreach (Cart::instance('cart')->content() as $item) {
        $product = Product::find($item->id);
        if ($item->qty > $product->so_luong) {
            $order->delete();
            Cart::instance('cart')->remove($item->rowId);
           return session()->flash('error', 'Sản phẩm ' . $product->ten . ' vừa mới hết hàng. Vui lòng mua sản phẩm khác.');

        }
        $orderDetails = new OrderDetails();
        $orderDetails->san_pham_id = $item->id;
        $orderDetails->don_hang_id = $order->id;
        $orderDetails->gia_tien = $item->price;
        $orderDetails->so_luong = $item->qty;
        $product->so_luong -= $item->qty;
        $product->save();
        $orderDetails->save();
    }

    Mail::to($order->email)->send(new confirmOrderMail($order));
    Cart::instance('cart')->destroy();
    session()->forget('coupon');
    session()->flash('message', 'Đặt hàng thành công.');
    return redirect(route('thankyou'));
}


    public function render()
    {
        if (session()->has('coupon')) {
            if (Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value']) {
                session()->forget('coupon');
            } else {
                $this->calculateDiscount();
            }
        }

        return view('livewire.check-out-component');
    }
}
