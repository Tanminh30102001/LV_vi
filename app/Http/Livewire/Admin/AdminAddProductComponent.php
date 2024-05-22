<?php

namespace App\Http\Livewire\Admin;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
class AdminAddProductComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $short_desc;
    public $desc;
    public $regular_price;
    public $sale_price;
    public $sku;
    public $stock_status="instock";
    public $featured=0;
    public $quanity;
    public $image;
    public $category_id;
    public $images;
    public $subcategory_id;
    /////////////////////////
    public $attr;
    public $inputs=[];
    public $attr_array=[];
    public $attr_values;

    public function addAttr(){
        if(!in_array($this->attr,$this->attr_array)){
            array_push($this->inputs,$this->attr);
            array_push($this->attr_array,$this->attr);
        }
    }
    public function remove($attr){
        unset($this->inputs[$attr]);
    }
    public function generateSlug() {
        $this->slug=Str::slug($this->name);
    }
    public function addProduct(){
        $this->validate( [
            'name'=>'required',
            'slug'=>'required',
            'short_desc' => "required| ",
            'desc'=>"required",
            'regular_price'=>'required | numeric ',
            'sale_price'=>'numeric',
            'sku'=>'required',
            'stock_status'=>'required',
            'featured'=>'required',
            'quanity'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png',
            'category_id'=>'required'

        ]);
        $product=new Product();
        $product->ten=$this->name;
        $product->slug=$this->slug;
        $product->mieu_ta_ngan=$this->short_desc;
        $product->mieu_ta=$this->desc;
        $product->gia=$this->regular_price;
        $product->gia_sale=$this->sale_price;
        $product->so_hieu=$this->sku;
         $product->trang_thai_ton_kho=$this->stock_status;
         $product->featured=$this->featured;
        $product->so_luong=$this->quanity;
        $imageName = Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('products',$imageName);
        $product->image=$imageName;
        if($this->images){
            $imagesname=[];
            foreach($this->images as $key=>$image){
                $imgName = Carbon::now()->timestamp.$key.'.'.$image->extension();
                $image->storeAs('products',$imgName);
                $imagesname[]='-'.$imgName;
            }
            $product->images=implode('-', $imagesname);
        }
        if($this->subcategory_id){
            $product->subdanh_muc_id=$this->subcategory_id;
        }
        
        $product->category_id=$this->category_id;

        $product->save();
        // foreach($this->attr_values as $key=>$attr_value){
        //     $avalues =explode(",",$attr_value);
        //     foreach($avalues as $avalue){
        //         $attribute_value= new AttributeValue();
        //         $attribute_value->product_attribute_id=$key;
        //         $attribute_value->values=$avalue;
        //         $attribute_value->product_id=$product->id;
        //         $attribute_value->save();
        //     }
        // }
        session()->flash('message','Product has been added');

    }
    public function changeSubcategory(){
        $this->subcategory_id=0;
    }

    public function render()
    {
        $categories=Category::orderBy('ten','ASC')->get();
        $subcategories=Subcategory::where('category_id',$this->category_id)->get();
        $pattributes=ProductAttribute::all();
        return view('livewire.admin.admin-add-product-component',['categories'=>$categories,'subcategories'=>$subcategories,'pattributes'=>$pattributes]);
    }
}
