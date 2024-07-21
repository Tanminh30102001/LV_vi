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
    // public $sku;
    public $stock_status = "instock";
    public $featured = 0;
    public $quanity;
    public $image;
    public $category_id;
    public $images;
    public $subcategory_id;
    /////////////////////////
    public $attr;
    public $inputs = [];
    public $attr_array = [];
    public $attr_values;
    public $keyword;
    public $man_hinh;
    public $kich_thuoc;
    public $dung_luong_pin;
    public $cong_suat_sac;
    public $thoi_luong_tai_nghe;
    public $cong_sac;


    public function addAttr()
    {
        if (!in_array($this->attr, $this->attr_array)) {
            array_push($this->inputs, $this->attr);
            array_push($this->attr_array, $this->attr);
        }
    }
    public function remove($attr)
    {
        unset($this->inputs[$attr]);
    }
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }   
    public function addProduct()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            'short_desc' => "required| ",
            'desc' => "required",
            'regular_price' => 'required | numeric ',
            'sale_price' => 'numeric',
            'stock_status' => 'required',
            'featured' => 'required',
            'quanity' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'category_id' => 'required',
            'keyword' => 'nullable|string',
            'man_hinh' => 'nullable|string',
            'kich_thuoc' => 'nullable|string',
            'dung_luong_pin' => 'nullable|string',
            'cong_suat_sac' => 'nullable|string',
            'thoi_luong_tai_nghe' => 'nullable|string',
            'cong_sac' => 'nullable|string'

        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'slug.required' => 'Vui lòng nhập slug.',
            'short_desc.required' => 'Vui lòng nhập mô tả ngắn.',
            'desc.required' => 'Vui lòng nhập mô tả.',
            'regular_price.required' => 'Vui lòng nhập giá gốc.',
            'regular_price.numeric' => 'Giá gốc phải là số.',
            'sale_price.numeric' => 'Giá bán phải là số.',
            'stock_status.required' => 'Vui lòng nhập tình trạng kho.',
            'featured.required' => 'Vui lòng chọn tính năng nổi bật.',
            'quanity.required' => 'Vui lòng nhập số lượng.',
            'image.required' => 'Vui lòng tải lên hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg, png.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'keyword.string' => 'Từ khóa phải là chuỗi ký tự.',
            'man_hinh.string' => 'Thông số màn hình phải là chuỗi ký tự.',
            'kich_thuoc.string' => 'Kích thước phải là chuỗi ký tự.',
            'dung_luong_pin.string' => 'Dung lượng pin phải là chuỗi ký tự.',
            'cong_suat_sac.string' => 'Công suất sạc phải là chuỗi ký tự.',
            'thoi_luong_tai_nghe.string' => 'Thời lượng tai nghe phải là chuỗi ký tự.',
            'cong_sac.string' => 'Cổng sạc phải là chuỗi ký tự.'
        ]);
        $product = new Product();
        $product->ten = $this->name;
        $product->slug = $this->slug;
        $product->mieu_ta_ngan = $this->short_desc;
        $product->mieu_ta = $this->desc;
        $product->gia_sale = $this->regular_price; // giá gốc (giá  bị gạch)
        $product->gia = $this->sale_price; // giá bán chính thức 
        // $product->so_hieu=$this->sku;
        $product->trang_thai_ton_kho = $this->stock_status;
        $product->featured = $this->featured;
        $product->so_luong = $this->quanity;
        $keywordsArray = array_map('trim', explode(',', $this->keyword));
        $product->keyword = json_encode($keywordsArray);
        $product->man_hinh = $this->man_hinh;
        $product->kich_thuoc = $this->kich_thuoc;
        $product->dung_luong_pin = $this->dung_luong_pin;
        $product->cong_suat_sac = $this->cong_suat_sac;
        $product->thoi_luong_tai_nghe = $this->thoi_luong_tai_nghe;
        $product->cong_sac = $this->cong_sac;
        $imageName = Carbon::now()->timestamp . '.' . $this->image->extension();
        $this->image->storeAs('products', $imageName);
        $product->image = $imageName;
        if ($this->images) {
            $imagesname = [];
            foreach ($this->images as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();
                $image->storeAs('products', $imgName);
                $imagesname[] = $imgName ;
            }
            $product->images = implode('-', $imagesname);
        }
        if ($this->subcategory_id) {
            $product->subdanh_muc_id = $this->subcategory_id;
        }


        $product->danh_muc_id = $this->category_id;
        $category = Category::find($this->category_id);
        if ($category) {
            $category_slug = $category->slug;
            $slug_parts = explode('-', $category_slug);
            $suffix = end($slug_parts);
            $random_number = mt_rand(100000, 999999);
            $product->ma_sp = $suffix . $random_number;
        }
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
        session()->flash('message', 'Thêm sản phẩm thành công');

    }
    public function changeSubcategory()
    {
        $this->subcategory_id = 0;
    }

    public function render()
    {
        $categories = Category::orderBy('ten', 'ASC')->get();
        $subcategories = Subcategory::where('category_id', $this->category_id)->get();
        // $pattributes=ProductAttribute::all();
        return view('livewire.admin.admin-add-product-component', ['categories' => $categories, 'subcategories' => $subcategories]);
    }
}
