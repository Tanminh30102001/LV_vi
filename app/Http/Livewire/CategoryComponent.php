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
    public $screenTypes = [];
    public $phoneSizes = [];
    public $batteryCapacities = [];
    public $chargingPowers = [];
    public $chargingPorts = [];
    public $min_value=0;
    public $max_value=1000000;

    public $selectedScreenType;
    public $selectedPhoneSize;
    public $selectedBatteryCapacity;
    public $selectedChargingPower;
    public $selectedChargingPort;
    
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
    public function render()
{
    $category_id = null;
    $category_name = '';
    $filter = '';

    // Kiểm tra xem có slug của subcategory không
    if ($this->scategory_slug) {
        $scategory = Subcategory::where('slug', $this->scategory_slug)->first();
        $category_id = $scategory->id;
        $category_name = $scategory->name;
        $filter = 'sub';
    } else {
        // Nếu không thì kiểm tra slug của category
        $category = Category::where('slug', $this->slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;
    }

    // Tạo query sản phẩm
    $query = Product::whereBetween('gia', [$this->min_value, $this->max_value])
        ->when($this->selectedScreenType, function($query) {
            $query->where('man_hinh', $this->selectedScreenType);
        })
        ->when($this->selectedPhoneSize, function($query) {
            $query->where('kich_thuoc', $this->selectedPhoneSize);
        })
        ->when($this->selectedBatteryCapacity, function($query) {
            $query->where('dung_luong_pin', $this->selectedBatteryCapacity);
        })
        ->when($this->selectedChargingPower, function($query) {
            $query->where('cong_suat_sac', $this->selectedChargingPower);
        })
        ->when($this->selectedChargingPort, function($query) {
            $query->where('cong_sac', $this->selectedChargingPort);
        })
        ->when($category_id, function($query) use ($category_id, $filter) {
            if ($filter == 'sub') {
                return $query->where('subdanh_muc_id', $category_id);
            } else {
                return $query->where('danh_muc_id', $category_id);
            }
        });

    // Áp dụng sắp xếp theo lựa chọn của người dùng
    if ($this->orderBy == 'Price:Low to High') {
        $products = $query->orderBy('gia', 'ASC')->paginate($this->pageSize);
    } else if ($this->orderBy == 'Price:High to Low') {
        $products = $query->orderBy('gia', 'DESC')->paginate($this->pageSize);
    } else if ($this->orderBy == 'Sort by Newness') {
        $products = $query->orderBy('created_at', 'DESC')->paginate($this->pageSize);
    } else {
        $products = $query->paginate($this->pageSize);
    }

    // Lấy danh sách categories và các sản phẩm mới nhất
    $categories = Category::orderBy('ten', 'ASC')->get();
    $newProd = Product::orderBy('created_at', 'DESC')->limit(5)->get();

    // Trả về view với các dữ liệu cần thiết
    return view('livewire.category-component', [
        'products' => $products,
        'categories' => $categories,
        'newProds' => $newProd,
        'category_name' => $category_name,
        'screenTypes' => $this->screenTypes,
        'phoneSizes' => $this->phoneSizes,
        'batteryCapacities' => $this->batteryCapacities,
        'chargingPowers' => $this->chargingPowers,
        'chargingPorts' => $this->chargingPorts,
    ]);
}
}
