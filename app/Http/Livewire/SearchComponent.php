<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class SearchComponent extends Component
{
    use WithPagination;
    public $pageSize = 10;
    public $orderBy = "Default Sorting";
    public $q;
    public $search_term;
    public $min_value=0;
    public $max_value=1000000;
    
    public $screenTypes = [];
    public $phoneSizes = [];
    public $batteryCapacities = [];
    public $chargingPowers = [];
    public $chargingPorts = [];

    public $selectedScreenType;
    public $selectedPhoneSize;
    public $selectedBatteryCapacity;
    public $selectedChargingPower;
    public $selectedChargingPort;
    public function mount()
    {
        $this->fill(request()->only('q'));
        $this->search_term = '%' . $this->q . '%';
        $this->screenTypes = Product::whereNotNull('man_hinh')
        ->select('man_hinh')
        ->distinct()
        ->pluck('man_hinh')
        ->toArray();

$this->phoneSizes = Product::whereNotNull('kich_thuoc')
      ->select('kich_thuoc')
      ->distinct()
      ->pluck('kich_thuoc')
      ->toArray();

$this->batteryCapacities = Product::whereNotNull('dung_luong_pin')
             ->select('dung_luong_pin')
             ->distinct()
             ->pluck('dung_luong_pin')
             ->toArray();
//SELECT DISTINCT dung_luong_pin FROM products WHERE dung_luong_pin IS NOT NULL;
$this->chargingPowers = Product::whereNotNull('cong_suat_sac')
          ->select('cong_suat_sac')
          ->distinct()
          ->pluck('cong_suat_sac')
          ->toArray();

$this->chargingPorts = Product::whereNotNull('cong_sac')
         ->select('cong_sac')
         ->distinct()
         ->pluck('cong_sac')
         ->toArray();
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::instance('cart')->add($product_id, $product_name, 1, $product_price)->associate('\App\Models\Product');
        session()->flash('susscess_message', 'Item added in Cart');
        return redirect()->route('shop.cart');
    }

    public function changePageSize($size)
    {
        $this->pageSize = $size;
    }
    public function changeOrderBy($order)
    {
        $this->orderBy = $order;
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
    public function render()
    {
        // $products = Product::paginate($this->pageSize);
        // $query = Product::query();
        $query = Product::
        whereBetween('gia', [$this->min_value, $this->max_value])
        ->when($this->selectedScreenType, function($query) {
            $query->where('ten', 'like', $this->search_term)->where('man_hinh', $this->selectedScreenType);
        })
        ->when($this->selectedPhoneSize, function($query) {
            $query->where('ten', 'like', $this->search_term)->where('kich_thuoc', $this->selectedPhoneSize);
        })
        ->when($this->selectedBatteryCapacity, function($query) {
            $query->where('ten', 'like', $this->search_term)->where('dung_luong_pin', $this->selectedBatteryCapacity);
        })
        ->when($this->selectedChargingPower, function($query) {
            $query->where('ten', 'like', $this->search_term)->where('cong_suat_sac', $this->selectedChargingPower);
        })
        ->when($this->selectedChargingPort, function($query) {
            $query->where('ten', 'like', $this->search_term)->where('cong_sac', $this->selectedChargingPort);
        });
        // Nếu giá trị lọc giá không phải mặc định, áp dụng điều kiện lọc
        if ($this->min_value > 0 || $this->max_value < 1000000) {
            $query = $query->whereBetween('gia', [$this->min_value, $this->max_value]);
        }

        // Áp dụng điều kiện sắp xếp
        if ($this->orderBy == 'Price:Low to High') {
            $products = $query->where('ten', 'like', $this->search_term)->orderBy('gia', 'ASC')->paginate($this->pageSize);
        } elseif ($this->orderBy == 'Price:High to Low') {
            $products = $query->where('ten', 'like', $this->search_term)->orderBy('gia', 'DESC')->paginate($this->pageSize);
        } elseif ($this->orderBy == 'Sort by Newness') {
            $products = $query->where('ten', 'like', $this->search_term)->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        } else {
            $products = $query->where('ten', 'like', $this->search_term)->paginate($this->pageSize);
        }
        // $query = Product::whereBetween('gia', [$this->min_value, $this->max_value]);

        // if ($this->orderBy == 'Price:Low to High') {
        //     $sortedProducts = $query->orderBy('gia', 'ASC')->paginate($this->pageSize);
        // } elseif ($this->orderBy == 'Price:High to Low') {
        //     $sortedProducts = $query->orderBy('gia', 'DESC')->paginate($this->pageSize);
        // } elseif ($this->orderBy == 'Sort by Newness') {
        //     $sortedProducts = $query->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        // } else {
        //     $sortedProducts = $query->paginate($this->pageSize);
        // }
        if(Auth::check()){
            Cart::instance('cart')->store(Auth::user()->email);
            Cart::instance('wishlist')->store(Auth::user()->email);
        }
        $categories = Category::orderBy('ten', 'ASC')->get();
        $newProd = Product::orderBy('created_at', 'DESC')->limit(5)->get();
        return view('livewire.search-component', ['products' => $products, 'categories' => $categories, 'newProducts' => $newProd]);
    }
}
