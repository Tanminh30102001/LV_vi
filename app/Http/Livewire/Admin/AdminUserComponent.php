<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class AdminUserComponent extends Component
{      public $searchName;
public $selectedFilter;
    public function render()
    {
        $usersQuery = User::query();

    if ($this->searchName) {
        $usersQuery->where(function ($query) {
            $query->where('ten', 'like', '%' . $this->searchName . '%')
                  ->orWhere('email', 'like', '%' . $this->searchName . '%');
        });
    }

    switch ($this->selectedFilter) {
        case 'newest_registration':
            $usersQuery->orderBy('created_at', 'desc');
            break;
        case 'oldest_registration':
            $usersQuery->orderBy('created_at', 'asc');
            break;
        case 'lowest_total_ordered':
            $usersQuery->withSum('orders', 'tong_tien')->orderBy('orders_sum_tong_tien', 'asc');
            break;
        case 'highest_total_ordered':
            $usersQuery->withSum('orders', 'tong_tien')->orderBy('orders_sum_tong_tien', 'desc');
            break;
        case 'lowest_orders_count':
            $usersQuery->withCount(['orders' => function ($query) {
                $query->where('tinh_trang_giao_hang', 'ordered');
            }])->orderBy('orders_count', 'asc');
            break;
        case 'highest_orders_count':
            $usersQuery->withCount(['orders' => function ($query) {
                $query->where('tinh_trang_giao_hang', 'ordered');
            }])->orderBy('orders_count', 'desc');
            break;
        case 'lowest_cancelled_orders_count':
            $usersQuery->withCount(['orders' => function ($query) {
                $query->where('tinh_trang_giao_hang', 'canceled');
            }])->orderBy('orders_count', 'asc');
            break;
        case 'highest_cancelled_orders_count':
            $usersQuery->withCount(['orders' => function ($query) {
                $query->where('tinh_trang_giao_hang', 'canceled');
            }])->orderBy('orders_count', 'desc');
            break;
    }

    $users = $usersQuery->paginate(10);
    return view('livewire.admin.admin-user-component', ['users' => $users]);

    }
}
