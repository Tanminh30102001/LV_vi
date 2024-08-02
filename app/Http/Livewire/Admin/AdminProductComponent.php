<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductComponent extends Component
{
    use WithPagination;
    public $selectedCategory;
    public $searchTerm = '';
    public $selectedFilter;
    public $product_id;
    public function deleteProduct(){
        // Product::find($this->product_id)->delete();

        $product=Product::find($this->product_id);
        // unlink('assets/imgs/products/'.$product->image);
        if ($product->orderDetails()->exists()) {
            session()->flash('error', 'Sản phẩm này không thể bị xóa do có chứa ở trong đơn hàng.');
            return;
        }
        $product->delete();
        session()->flash('message','Product Deleted Successfully');
    }
    public function render()
    {
       
        $categories = Category::all();
        $productsQuery = Product::query();
        if ($this->selectedCategory) {
            $productsQuery->where('danh_muc_id', $this->selectedCategory);
        }
        switch ($this->selectedFilter) {
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            case 'lowest_price':
                $productsQuery->orderBy('gia', 'asc');
                break;
            case 'highest_price':
                $productsQuery->orderBy('gia', 'desc');
                break;
            default:
                // No filter selected
                break;
        }
        if ($this->searchTerm) {
            $productsQuery->where(function ($query) {
                $query->where('ten', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('gia', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('ma_sp', 'like', '%' . $this->searchTerm . '%');
            });
        }
        $products = $productsQuery->orderBy('id','DESC')->paginate(10);
        // $products=Product::where('ten','LIKE',$search)->
        // orWhere('gia','like' ,$search)->
        // orWhere('ma_sp','like' ,$search)->
        // orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.admin-product-component',['products'=>$products,'categories'=>$categories]);
    }
}
