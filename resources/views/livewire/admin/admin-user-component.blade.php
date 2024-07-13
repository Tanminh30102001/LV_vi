<div>
    <style>
        .border-danger {
            border-color: #af233a !important;
        }
    </style>
    <main>
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> All User
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="select">
                        <select class="form-select border border-danger" wire:model="selectedFilter">
                            <option value="">Lọc</option>
                            <option value="newest_registration">Ngày đăng kí mới nhất</option>
                            <option value="oldest_registration">Ngày đăng kí cũ nhất</option>
                            <option value="lowest_total_ordered">Tổng tiền đã đặt ít nhất</option>
                            <option value="highest_total_ordered">Tổng tiền đã đặt nhiều nhất</option>
                            <option value="lowest_orders_count">Số đơn đã đặt ít nhất</option>
                            <option value="highest_orders_count">Số đơn đã đặt nhiều nhất</option>
                            <option value="lowest_cancelled_orders_count">Số đơn đã hủy ít nhất</option>
                            <option value="highest_cancelled_orders_count">Số đơn đã hủy nhiều nhất</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Tìm kiếm theo tên" wire:model="searchName" />
                </div>
            </div>
    
            <div class="mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> user ID</th>
                            <th> Tên</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>SĐT</th>
                            <th>Tổng tiền đã đặt</th>
                            <th>Số đơn hàng đã đặt</th>
                            <th>Số đơn hàng đã hủy</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->ten }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->dia_chi }}</td>
                                <td>{{ $item->sdt }}</td>
                                <td>{{format_number( $item->orders_sum_tong_tien) ??format_number(App\Models\Order::where('user_id', $item->id)->sum('tong_tien'))  }}
                                </td>
                                <td>{{ $item->orders_count ??App\Models\Order::where('user_id', $item->id)->where('tinh_trang_giao_hang', 'ordered')->count() }}
                                </td>
                                <td>{{ $item->cancelled_orders_count ??App\Models\Order::where('user_id', $item->id)->where('tinh_trang_giao_hang', 'canceled')->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Hiển thị liên kết phân trang -->
    
            </div>
            <div class="d-flex justify-content-right">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </main>
</div>

