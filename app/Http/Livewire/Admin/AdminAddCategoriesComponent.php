<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminAddCategoriesComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $image;
    public $is_popular=0;
    public $category_id;
    public function generateSlug() {
        $this->slug=Str::slug($this->name);
    }
    public function updated($fileds){
        $this->validateOnly($fileds,[
            'name'=>'required',
            'slug'=>'required',
             'image'=>'required',

        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'slug.required' => 'Vui lòng nhập slug.',
            'image.required' => 'Vui lòng tải lên hình ảnh.'
        ]);
    }
    public function storeCategory(){
        $this->validate( [
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'slug.required' => 'Vui lòng nhập slug.',
            'image.required' => 'Vui lòng tải lên hình ảnh.'
        ]);
        if($this->category_id){
            $scategory=new Subcategory();
            $scategory->ten=$this->name;
            $scategory->slug=$this->slug;
            $scategory->category_id=$this->category_id;
            $scategory->save();
        }
        else{
            $category =new Category();
            $category->ten=$this->name;
            $category->slug=$this->slug;
            $imageName=Carbon::now()->timestamp.'.'.$this->image->extension();
            $this->image->storeAs('category',$imageName);
            $category->image=$imageName;
            $category->pho_bien=$this->is_popular;
            $category->save();
        }
       
        session()->flash('message','Category has been added');
    }
    public function render()
    {
        $categories=Category::all();
        return view('livewire.admin.admin-add-categories-component',['categories'=>$categories]);
    }
}
