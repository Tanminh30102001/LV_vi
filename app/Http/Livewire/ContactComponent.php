<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactComponent extends Component
{
    public $name;
    public $phone;
    public $email;
    public $subject;
    public $content;
    public function updated($fields){
        $this->validateOnly($fields,[
            'name'=>'required',
            'phone'=>['required','regex:/^\+?[\d]{10,25}$/'],
            'email'=>'required|email',
            'subject'=>'required',
            'content'=>'required'
        ] ,[
            'name.required' => 'Vui lòng nhập tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại phải là số',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'subject.required' => 'Vui lòng nhập chủ đề.',
            'content.required' => 'Vui lòng nhập nội dung.'
        ]);
    }
    public function sendMessage(){
        $this->validate([
            'name'=>'required',
            'phone'=>['required','regex:/^\+?[\d]{10,25}$/'],
            'email'=>'required|email',
            'subject'=>'required',
             'content'=>'required | max:255'
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại phải là số.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'subject.required' => 'Vui lòng nhập chủ đề.',
            'content.required' => 'Vui lòng nhập nội dung.',
            'content.max' => 'Nội dung không được vượt quá 255 ký tự.'
        ]);
        $contact= new Contact();
        $contact->ten=$this->name;
        $contact->email=$this->email;
        $contact->sdt=$this->phone;
        $contact->chu_de=$this->subject;
        $contact->noi_dung=$this->content;
        $contact->save();
        session()->flash('contact-message','Thank you for your Feedback');

    }
    public function render()
    {
        return view('livewire.contact-component');
    }
}
