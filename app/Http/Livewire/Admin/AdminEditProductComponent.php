<?php

namespace App\Http\Livewire\Admin;

use App\Models\AttributeValue;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;

class AdminEditProductComponent extends Component
{
    use WithFileUploads;
    public $product_id;
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
    public $newImage;
    public $images;
    public $newimages;
    public $scategory_id;
    ////////////////////////////
    public $attr;
    public $inputs=[];
    public $attr_array=[];
    public $attr_values;
    public $keyword;
    public $man_hinh;
    public $kich_thuoc;
    public $dung_luong_pin;
    public $cong_suat_sac;
    public $thoi_luong_tai_nghe;
    public $cong_sac;

    function mount($product_id){
        $product =Product::find($product_id);
        $this->product_id=$product->id;
        $this->name =$product->ten ;
        $this->slug  =$product->slug ;
        $this->short_desc=$product->mieu_ta_ngan ;
        $this->desc   =$product->mieu_ta  ;
        $this->regular_price=$product->gia_sale;
        $this->sale_price =$product->gia;
        $this->sku =$product->sku ;
        $this->stock_status=$product->trang_thai_ton_kho;
        $this->featured=$product->featured ;
        $this->quanity =$product->so_luong ;
        $this->image =$product->image;
        $this->images =explode('-',$product->images);
        $this->category_id=$product->danh_muc_id;
        $this->scategory_id=$product->subdanh_muc_id;
        // $this->inputs=$product->attributeValues->where('product_id',$product->id)->unique('product_attribute_id')->pluck('product_attribute_id');
        // $this->attr_array=$product->attributeValues->where('product_id',$product->id)->unique('product_attribute_id')->pluck('product_attribute_id');

        foreach($this->attr_array as $a_arr){
            $allAttributeValue = AttributeValue::where('product_id',$product->id)->where('product_attribute_id',$a_arr)->get()->pluck('value');
            $valueString='';
            foreach($allAttributeValue as $value){
                $valueString= $valueString.$value.',';
            }
            $this->attr_values[$a_arr]=rtrim($valueString,',');

        }
    }
    // public function addAttr(){
    //     if(!$this->attr_array->contains($this->attr)){
    //         $this->inputs->push($this->attr);
    //         $this->attr_array->push($this->attr);
    //     }
    // }
    public function generateSlug() {
        $this->slug=Str::slug($this->name);
    }

    public function updateProduct(){
        $this->validate( [
          
            // 'image'=>'required ',
            'category_id'=>'nullable',
            'keyword' => 'nullable|string',
            'man_hinh' => 'nullable|string',
            'kich_thuoc' => 'nullable|string',
            'dung_luong_pin' => 'nullable|string',
            'cong_suat_sac' => 'nullable|string',
            'thoi_luong_tai_nghe' => 'nullable|string',
            'cong_sac' => 'nullable|string'

        ]);
        $product= Product::find($this->product_id);
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
        $keywordsArray = array_map('trim', explode(',', $this->keyword));
        $product->keyword = json_encode($keywordsArray);
        $product->man_hinh = $this->man_hinh;
        $product->kich_thuoc = $this->kich_thuoc;
        $product->dung_luong_pin = $this->dung_luong_pin;
        $product->cong_suat_sac = $this->cong_suat_sac;
        $product->thoi_luong_tai_nghe = $this->thoi_luong_tai_nghe;
        $product->cong_sac = $this->cong_sac;
        if($this->newImage){
            // unlink('assets/imgs/products/'.$product->image);
            $imageName = Carbon::now()->timestamp.'.'.$this->newImage->extension();
            $this->newImage->storeAs('products',$imageName);
            $product->image=$imageName;
        }
        if($this->newimages){
            $images=explode('-',$product->images);
            foreach($images as $image){
                if($image){
                    unlink('assets/imgs/products/'.$image);
                }
            }
        }
       
      
        if(!empty($this->newimages)){
            $imagesname=[];
            foreach($this->newimages as $key=>$image){
                $imgName = Carbon::now()->timestamp.$key.'.'.$image->extension();
                $image->storeAs('products',$imgName);
                // $imagesname .= $imagesname == '' ? $imgName : '-' . $imgName;
                $imagesname[]=$imgName.'-';
                $product->images=implode('-', $imagesname);
            }
        }
        // $product->images= $imagesname;
        
        if($this->scategory_id){
            $product->subdanh_muc_id=$this->scategory_id;
        }
        $product->danh_muc_id=$this->category_id;
        $product->save();
        // AttributeValue::where('product_id',$product->id)->delete();
        // foreach($this->attr_values as $key=>$attr_value)
        // {
        //     $avalues=explode(",",$attr_value);
        //     foreach($avalues as $avalue){
        //         $attributevalue= new AttributeValue();
        //         $attributevalue->product_attribute_id=$key;
        //         $attributevalue->values=$avalue;
        //         $attributevalue->product_id=$product->id;
        //         $attributevalue->save();
        //     }
        // }
        session()->flash('message','Product has been updated');
        
    }
    public function render()
    {
        $scategories=Subcategory::where('category_id',$this->category_id)->get();
        // $pattrs=ProductAttribute::all();
        $categories=Category::orderBy('ten','ASC')->get();
        return view('livewire.admin.admin-edit-product-component',['categories'=>$categories,'scategories'=>$scategories]);
    }
}
