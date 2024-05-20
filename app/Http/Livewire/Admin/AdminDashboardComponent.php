<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboardComponent extends Component
{
    public function render()
    {   
       
        $orders=Order::orderBy('created_at','DESC')->get()->take(10);
        $totalSale= Order::where('trang_thai','delivered')->count();
        $totalCancel=Order::where('trang_thai','cancel')->count();
        $totalAcept=Order::where('trang_thai','accept order')->count();
        $totalRevenue=Order::where('trang_thai','delivered')->sum('tong_tien');
        $dailyRevenue=Order::where('trang_thai','delivered')->whereDate('created_at',Carbon::now())->sum('tong_tien');
        $monthlyRevenue=Order::where('trang_thai','delivered')->whereMonth('created_at',Carbon::now()->month)->sum('tong_tien');


        return view('livewire.admin.admin-dashboard-component',['orders'=>$orders,'totalSale'=>$totalSale,'totalCancel'=>$totalCancel,'totalRevenue'=>$totalRevenue,'dailyRevenue'=>$dailyRevenue,'monthlyRevenue'=>$monthlyRevenue,'totalAcept'=>$totalAcept]);
    }
}
