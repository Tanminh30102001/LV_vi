<style>
    .badge-success {
        color: #0d6832 !important;
    }

    .badge-warning {
        color: #73510d !important;
    }

    .badge-danger {
        color: #af233a !important;
    }

    .badge-primary {
        color: #2c58a0 !important;
    }

    .badge-info {
        color: #1c657d !important;
    }

    .badge-secondary {
        color: #40464f !important;
    }

</style>
<div>

    <div class="container">
        <div class="col">
            <h1 class="text-center">Thống kê cửa hàng </h1>
        </div>
        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Tổng Doang thu </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">đ {{ format_number($totalRevenue)}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Doanh thu(Từng ngày ) </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">đ{{format_number($dailyRevenue)}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Doanh thu (Tháng này) </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">đ{{format_number($monthlyRevenue)}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->

        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Đơn hàng đang đợi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalAcept}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Đơn hàng đã giao </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalSale}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Đơn hàng bị hủy </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalCancel}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mt-3">
                <div class="card">
                    <canvas id="topProduct"></canvas>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="card">
                    <canvas id="statusOrerChart"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1> Những đơn hàng mới nhất</h1>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>

                        <th> Mã đơn hàng</th>
                        <th> Trạng thái đơn hàng</th>
                        <th>Trạng thái giao hàng</th>
                        <th>tổng tiền</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                    <tr>
                        {{-- <td> {{$item->id}}</td> --}}

                        <td>{{$item->ma_don_hang}}</td>
                        <td>
                            @if ($item->trang_thai == 1)
                            <span class="badge badge-success">Đã thanh toán</span>
                            @else
                            <span class="badge badge-warning">Chưa thanh toán</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->tinh_trang_giao_hang == 'ordered')
                            <span class="badge badge-pill badge-secondary">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                            @elseif ($item->tinh_trang_giao_hang == 'accepted')
                            <span class="badge badge-pill badge-info">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                            @elseif ($item->tinh_trang_giao_hang == 'delivering')
                            <span class="badge badge-pill badge-dark">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                            @elseif ($item->tinh_trang_giao_hang == 'canceled')
                            <span class="badge badge-pill badge-danger">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                            @else
                            <span class="badge badge-pill badge-success">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                            @endif
                        </td>
                        <td> {{format_number($item->tong_tien)}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar', // Hoặc 'line', 'pie', etc.
                data: @json($chartData)
                , options: {
                    responsive: true
                    , scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            Livewire.on('updateChart', data => {
                salesChart.data = data;
                salesChart.update();
            });
        });
        document.addEventListener('livewire:load', function() {
            var ctx = document.getElementById('monthlyChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar', // Hoặc 'line', 'pie', etc.
                data: @json($monthlySalesData)
                , options: {
                    responsive: true
                    , scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            Livewire.on('updateChart', data => {
                salesChart.data = data;
                salesChart.update();
            });
        });
        document.addEventListener('livewire:load', function() {
            var ctx = document.getElementById('topProduct').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar', // Hoặc 'line', 'pie', etc.
                data: @json($topProductSale),
                 options: {
                    responsive: true,
                    indexAxis: 'y', // Chuyển biểu đồ thành thanh nằm ngang
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            Livewire.on('updateChart', data => {
                salesChart.data = data;
                salesChart.update();
            });
        });
        document.addEventListener('livewire:load', function () {
            var ctx = document.getElementById('statusOrerChart').getContext('2d');
            var orderStatusChart = new Chart(ctx, {
                type: 'pie', // Biểu đồ tròn
                data: @json($countStatusOrder),
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });

            Livewire.on('updateChart', data => {
                orderStatusChart.data = data;
                orderStatusChart.update();
            });
        });
    </script>
</div>
