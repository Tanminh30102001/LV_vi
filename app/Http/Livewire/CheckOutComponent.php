<?php

namespace App\Http\Livewire;

use App\Mail\confirmOrderMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Carbon\Carbon;
use Cart;
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
            // dd(gettype(Cart::instance('cart')->subtotal()),Cart::instance('cart')->subtotal());
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
        $order = new Order();
        $order->user_id = Auth::user()->id;
        // $order->total=str_replace(',','',Cart::instance('cart')->total()) ;
        // $order->total=session()->get('checkout')['total'];
        $order->tong_tien = str_replace(',', '', session()->get('checkout')['total']);
        $order->ma_don_hang = rand(1000, 999999999);
        $order->giam_gia = session()->get('checkout')['discount'];
        $order->tam_tinh = session()->get('checkout')['subtotal'];
        $order->email = Auth::user()->email;
        $order->user_ten = Auth::user()->ten;
        $order->user_sdt = $this->user_phone;
        $order->user_diachi = $this->user_address;
        $order->ghi_chu = $this->notes;
        $order->trang_thai = false;
        $this->process = true;
        $order->save();
        foreach (Cart::instance('cart')->content() as $item) {
            $orderDetails = new OrderDetails();
            $orderDetails->san_pham_id = $item->id;
            $orderDetails->don_hang_id = $order->id;
            $orderDetails->gia_tien = $item->price;
            $orderDetails->so_luong = $item->qty;
            $product = Product::find($orderDetails->san_pham_id);
            $product->so_luong = $product->so_luong - $orderDetails->so_luong;
            // $option = [
            //     'color' => $item->options->color,
            //     'size' => $item->options->size
            // ];

            // $orderDetails->options = json_encode($option);;

            $product->save();
            $orderDetails->save();
        }
        // $order_id=$order->id;
        // $orderD =OrderDetails::where('order_id',$order_id)->get();
        // Mail::to($order->email)->send(new confirmOrderMail($order));
        Cart::instance('cart')->destroy();
        session()->forget('coupon');
        session()->flash('message', 'Orderd successfully');
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
