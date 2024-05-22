<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Coupon;
class AdminEditCouponComponent extends Component
{
    public $coupon_id;
    public $ma_phieu;
    public $loai;
    public $gia_tri;
    public $gia_tri_gio_hang;
    public $expiry_date;
    public $desc;
    public function mount($coupon_id){
        $coupon= Coupon::find($coupon_id);
        $this->ma_phieu=$coupon->ma_phieu;
        $this->loai=$coupon->loai;
        $this->gia_tri=$coupon->gia_tri;
        $this->gia_tri_gio_hang=$coupon->gia_tri_gio_hang;
        $this->desc=$coupon->desc;
        $this->coupon_id=$coupon->id;
        $this->expiry_date=$coupon->expiry_date;
    }
    public function updated($fields){
        $this->validateOnly($fields,[
            'ma_phieu'=>'required|unique:phieu_giam_gia',
            'loai'=>'required',
            'gia_tri'=>'required|numeric',
            'gia_tri_gio_hang'=>'required|numeric',
            'expiry_date'=>'required',
        ]);
    }
    public function EditCoupon(){
        $this->validate([
            'ma_phieu'=>'required|unique:phieu_giam_gia',
            'loai'=>'required',
            'gia_tri'=>'required|numeric',
            'gia_tri_gio_hang'=>'required|numeric',
            'expiry_date'=>'required',
        ]);
        $coupon = Coupon::find($this->coupon_id);
        $coupon->ma_phieu=$this->ma_phieu;
        $coupon->loai=$this->loai;
        $coupon->gia_tri=$this->gia_tri;
        $coupon->gia_tri_gio_hang=$this->gia_tri_gio_hang;
        $coupon->expiry_date= $this->expiry_date;
        $coupon->mo_ta=$this->desc;
        $coupon->save();
        session()->flash('message','Coupon Updated Successfully');
    }
    public function render()
    {
        return view('livewire.admin.admin-edit-coupon-component');
    }
}
