<?php

namespace App\Http\Livewire\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
class UserEditProfileComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $phone;
    public $address;
    public $newimage;
    public $image;
    public $user_id;
    public $password;
    public $nPassword;
    public function mount($user_id){
        // $this->user_id=Auth::user()->id;
        $user =User::find($user_id);
        $this->name =$user->ten;
        $this->phone =$user->sdt;
        $this->address=$user->dia_chi;
        $this->image=$user->image;   
    }
    public function updateUser(){
        $this->validate([
            'name' => 'required|string',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:11',
            'address' => 'required|string',
            'password' => 'min:8|nullable',
            'nPassword' => 'same:password|nullable'
        ],
            [
                'name.required' => 'Vui lòng nhập tên.',
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.regex' => 'Vui lòng nhập số điện thoại hợp lệ.',
                'phone.max' => 'Vui lòng nhập số điện thoại có 10 số.',
                'address.required' => 'Vui lòng nhập địa chỉ.',
                'password.min'=>'Vui lòng nhập ít nhất 8 kí tự',
                'nPassword.same'=>'Mật khẩu mới không trùng khớp '
            ]
    );
     
       $user = User::find($this->user_id);
        $user->ten=$this->name;
        $user->sdt =$this->phone;
        $user->dia_chi=$this->address;
        $user->mat_khau= Hash::make($this->nPassword);
        if($this->newimage){
            // unlink('assets/imgs/products/'.$user->image);
            $imageName = Carbon::now()->timestamp.'.'.$this->newimage->extension();
            $this->newimage->storeAs('user',$imageName);
            $user->image=$imageName;
        }
        $user->save();
      session()->flash("message"," Updated Successfully");
    }
    public function render()
{
        return view('livewire.user.user-edit-profile-component');
    }
}
