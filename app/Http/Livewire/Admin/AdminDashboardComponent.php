<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AdminDashboardComponent extends Component
{
    public $chartData = [];
    public $monthlySalesData=[];
    public $topProductSale=[];
    public $countStatusOrder=[];


    public function mount()
    {
        // Giả sử bạn có logic để lấy dữ liệu doanh số hàng tháng
        $this->chartData = $this->getSalesData();
        $this->monthlySalesData = $this->getMonthlySalesData();
        $this->topProductSale=$this->getTopProducts();
        $this->countStatusOrder=$this->getOrderStatusCounts();
    }
//daily
    public function getSalesData()
    {
        $month = 7; // tháng bạn muốn truy vấn
        $year = 2024; // năm bạn muốn truy vấn

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $period = CarbonPeriod::create($startDate, $endDate);

        // Tạo một mảng để giữ các ngày và tổng tiền
        $dates = [];
        foreach ($period as $date) {
            $dates[$date->format('Y-m-d')] = 0;
        }

        // Lấy dữ liệu từ bảng orders
        $results = DB::table('don_hang')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(tong_tien) as total_amount'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get();

        // Kết hợp dữ liệu từ bảng orders với tập hợp ngày đầy đủ
        foreach ($results as $result) {
            $dates[$result->date] = $result->total_amount;
        }
        $formattedLabels = array_map(function($date) {
            return Carbon::parse($date)->format('j/n'); // Định dạng ngày/tháng
        }, array_keys($dates));
        // Chuẩn bị dữ liệu cho chart
        return [
            'labels' =>  $formattedLabels,
            'datasets' => [
                [
                    'label' => 'Doanh thu thèo từng ngày trong tháng',
                    'backgroundColor' => '#f87979',
                    'data' => array_values($dates),
                ]
            ]
        ];
    }
    public function getMonthlySalesData()
    {
        $year = 2024; // năm bạn muốn truy vấn

        // Lấy dữ liệu từ bảng orders
        $results = DB::table('don_hang')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(tong_tien) as total_amount'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Định dạng dữ liệu cho các tháng
        $months = array_fill(1, 12, 0); // Tạo mảng với 12 phần tử, giá trị ban đầu là 0
        foreach ($results as $result) {
            $months[$result->month] = $result->total_amount;
        }

        // Chuẩn bị dữ liệu cho chart
        return [
            'labels' => array_keys($months),
            'datasets' => [
                [
                    'label' => 'Tổng doan thu theo từng tháng',
                    'backgroundColor' => '#42A5F5',
                    'data' => array_values($months),
                ]
            ]
        ];
    }
    public function getTopProducts()
    {
        $results= Product::select('san_phams.ten', 'san_phams.ma_sp', DB::raw('SUM(don_hang_chi_tiet.so_luong) as total_quantity'))
        ->join('don_hang_chi_tiet', 'san_phams.id', '=', 'don_hang_chi_tiet.san_pham_id')
        ->join('don_hang', 'don_hang_chi_tiet.don_hang_id', '=', 'don_hang.id')
        ->groupBy('san_phams.id', 'san_phams.ten', 'san_phams.ma_sp')
        ->orderBy('total_quantity', 'DESC')
        ->limit(10)
        ->get();
        return [
            'labels' => $results->pluck('ma_sp')->toArray(),
            'datasets' => [
                [
                    'label' => 'Sản phẩm bán chạy nhất',
                    'backgroundColor' => '#fc03ca',
                    'data' => $results->pluck('total_quantity')->toArray(),
                ]
            ]
        ];
    }
    public function getOrderStatusCounts()
    {
         $order = new Order();
        $results = Order::select('tinh_trang_giao_hang', DB::raw('count(*) as count'))
            ->groupBy('tinh_trang_giao_hang')
            ->get();
            $translatedLabels = $results->map(function ($item) use ($order) {
                $translated = $order->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang);
                return $translated;
    
            });
        return [
            'labels' => $translatedLabels->toArray(),
            'datasets' => [
                [
                    'label' => 'Số lượng đơn hàng theo trạng thái',
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    'data' => $results->pluck('count')->toArray(),
                ]
            ]
        ];
    }
    public function render()
    {   
       
        $orders=Order::orderBy('created_at','DESC')->get()->take(10);
        $totalSale= Order::where('trang_thai','delivered')->count();
        $totalCancel=Order::where('trang_thai','canceled')->count();
        $totalAcept=Order::where('trang_thai','accepted')->count();
        $totalRevenue=Order::where('trang_thai','delivered')->sum('tong_tien');
        $dailyRevenue=Order::where('trang_thai','delivered')->whereDate('created_at',Carbon::now())->sum('tong_tien');
        $monthlyRevenue=Order::where('trang_thai','delivered')->whereMonth('created_at',Carbon::now()->month)->sum('tong_tien');


        return view('livewire.admin.admin-dashboard-component',['orders'=>$orders,'totalSale'=>$totalSale,'totalCancel'=>$totalCancel,'totalRevenue'=>$totalRevenue,'dailyRevenue'=>$dailyRevenue,'monthlyRevenue'=>$monthlyRevenue,'totalAcept'=>$totalAcept]);
    }
}
