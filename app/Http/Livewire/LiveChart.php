<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class LiveChart extends Component
{
    public $chartData = [];

    public function mount()
    {
        // Giả sử bạn có logic để lấy dữ liệu doanh số hàng tháng
        $this->chartData = $this->getMonthlySalesData();
    }

    public function getMonthlySalesData()
    {
        // Đây là ví dụ dữ liệu giả, thay thế bằng dữ liệu thực từ cơ sở dữ liệu của bạn
        return [
            'labels' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            'datasets' => [
                [
                    'label' => 'Doanh số',
                    'backgroundColor' => '#f87979',
                    'data' => [40, 20, 12, 39, 10, 40]
                ]
            ]
        ];
    }
    public function render()
    {
        $columnChartModel = 
    (new ColumnChartModel())
        ->setTitle('Expenses by Type')
        ->addColumn('Food', 100, '#f6ad55')
        ->addColumn('Shopping', 200, '#fc8181')
        ->addColumn('Travel', 300, '#90cdf4')
    ;
        return view('livewire.live-chart',['columnChartModel'=>$columnChartModel]);
    }
}
