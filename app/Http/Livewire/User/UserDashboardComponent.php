<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboardComponent extends Component
{
    
    public $name;
    public $phone;
    public $address;
    public $order_id;
    // public $user_id;

    public function mount(){

        
        // $this->user_id=Auth::user()->id;
        $user = Auth::user();
        $this->name =$user->name;
        $this->phone =$user->phone;
        $this->address=$user->address;
        
        
    }
    public function updateUser(){
        $this->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric|unique:users,phone|max:10',
            'address' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.'
        ]);
        $user = Auth::user();
        User::where('id', $user->id)->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);
        // $user=User::find(auth()->user()->id);
        // // $user=Auth::user();
        // $user->name=$this->name;
        // $user->phone =$this->phone;
        // $user->address=$this->address;
        
        // $user->save();
      session()->flash("message"," Updated Successfully");

    }

    public function render()
    {
        
        return view('livewire.user.user-dashboard-component');
    }
}
