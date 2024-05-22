<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Livewire\Component;

class AdminAddCouponComponent extends Component
{
    public $ma_phieu;
    public $loai;
    public $gia_tri;
    public $gia_tri_gio_hang;
    public $expiry_date;
    public $desc;
    public function updated($fields){
        $this->validateOnly($fields,[
            'ma_phieu'=>'required|unique:phieu_giam_gia',
            'loai'=>'required',
            'gia_tri'=>'required|numeric',
            'gia_tri_gio_hang'=>'required|numeric',
            'expiry_date'=>'required',
        ]);
    }
    public function storeCoupon(){
        $this->validate([
            'ma_phieu'=>'required|unique:phieu_giam_gia',
            'loai'=>'required',
            'gia_tri'=>'required|numeric',
            'gia_tri_gio_hang'=>'required|numeric',
            'expiry_date'=>'required',
        ]);
        $coupon = new Coupon();
        $coupon->ma_phieu=$this->ma_phieu;
        $coupon->loai=$this->loai;
        $coupon->gia_tri=$this->gia_tri;
        $coupon->gia_tri_gio_hang=$this->gia_tri_gio_hang;
        $coupon->expiry_date= $this->expiry_date;
        $coupon->mo_ta=$this->desc;
        $coupon->save();
        session()->flash('message','Coupon Added Successfully');
    }
    public function render()
    {
        return view('livewire.admin.admin-add-coupon-component');
    }
}
