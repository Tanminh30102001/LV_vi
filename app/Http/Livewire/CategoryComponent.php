<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\WithPagination;
use Gloudemans\Shoppingcart\Facades\Cart;

class CategoryComponent extends Component
{
    use WithPagination;
    public $pageSize = 10;
    public $orderBy = "Default Sorting";
    public $slug;
    public $scategory_slug;

    public function store($product_id, $product_name, $product_price)
    {
        Cart::instance('cart')->add($product_id, $product_name, 1, $product_price)->associate('\App\Models\Product');
        session()->flash('susscess_message', 'Item added in Cart');
        return redirect()->route('shop.cart');
    }
    public function addToWishlist($product_id, $product_name, $product_price)
    {
        Cart::instance('wishlist')->add($product_id, $product_name, 1, $product_price)->associate('\App\Models\Product');
        $this->emitTo('wishlist-icon-component', 'refreshComponent');
    }
    public function removeFromWishlist($product_id)
    {
        foreach (Cart::instance('wishlist')->content() as $witem) {
            if ($witem->id == $product_id) {
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-icon-component', 'refreshComponent');
                return;
            }
        }
    }

    public function changePageSize($size)
    {
        $this->pageSize = $size;
    }
    public function changeOrderBy($order)
    {

        $this->orderBy = $order;
    }
    public function mount($slug, $scategory_slug = null)
    {
        $this->slug = $slug;
        $this->scategory_slug = $scategory_slug;
    }
    public function render()
    {
        $category_id = null;
        $category_name = '';
        $filter = '';

        if ($this->scategory_slug) {
            $scategory = Subcategory::where('slug', $this->scategory_slug)->first();
            $category_id = $scategory->id;
            $category_name = $scategory->name;
            $filter = 'sub';
        } else {

            $category = Category::where('slug', $this->slug)->first();
            $category_id = $category->id;
            $category_name = $category->name;
        }
        $products = Product::paginate($this->pageSize);
        if ($this->orderBy == 'Price:Low to High') {
            $products = Product::where($filter . 'danh_muc_id', $category_id)->orderBy('gia', 'ASC')->paginate($this->pageSize);
        } else if ($this->orderBy == 'Price:High to Low') {
            $products = Product::where($filter . 'danh_muc_id', $category_id)->orderBy('gia', 'DESC')->paginate($this->pageSize);
        } else if ($this->orderBy == 'Sort by Newness') {
            $products = Product::where($filter . 'danh_muc_id', $category_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        } else {
            $products = Product::where($filter . 'danh_muc_id', $category_id)->paginate($this->pageSize);
        }
        $categories = Category::orderBy('ten', 'ASC')->get();
        $newProd= Product::orderBy('created_at', 'DESC')->limit(5)->get();
        return view('livewire.category-component', ['products' => $products, 'categories' => $categories, 'newProds'=>$newProd,'category_name' => $category_name]);
    }
}
