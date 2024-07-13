<div>
    <style>
        nav svg {
            height: 20px;
        }

        .badge-success {
            color: #0d6832 !important;
        }

        .badge-warning {
            color: #73510d !important;
        }

        .badge-danger {
            color: #af233a !important;
        }

        .border-danger {
            border-color: #af233a !important;
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

        nav .hidden {
            display: block;
        }
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Tất cả đơn hàng
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="form-select border border-danger" id="inputGroupSelect01"
                                        wire:model="selectedStatus">
                                        <option value="" selected>Trạng thái đơn hàng </option>
                                        <option value="ordered">Đã đặt</option>
                                        <option value="accepted">Đã xác nhận</option>
                                        <option value="delivering">Đang giao</option>
                                        <option value="delivered">Đã giao</option>
                                        <option value="canceled">Đã hủy</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select border border-danger" wire:model="selectedFilter">

                                        <option value="newest" selected>Đơn hàng mới nhất</option>
                                        <option value="oldest">Đơn hàng trễ nhất</option>
                                        <option value="lowest_price">Tổng tiền từ thấp tới cao</option>
                                        <option value="highest_price">Tổng tiền từ cao tới thấp</option>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <input type="text" class="form-control border border-danger"
                                        placeholder="Nhập mã đơn hàng" wire:model="searchTerm" />
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel"
                            aria-hidden="true" wire:ignore.self>
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title" id="cancelModalLabel">Lý do hủy đơn hàng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    @if (Session::has('required'))
                                        <div class="alert alert-danger" role="alert" id="successMessage">
                                            {{ Session::get('required') }}</div>
                                    @endif
                                    <div class="modal-body">
                                        <textarea class="form-control" wire:model.defer="cancelReason" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary"
                                            wire:click.prevent="submitCancelReason">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert" id="successMessage">
                                    {{ Session::get('message') }}</div>
                            @endif
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Tình trạng đơn hàng</th>
                                        <th>Tình trạng giao hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Hành động</th>
                                        <th>Cập nhật trạng thái giao hàng</th>
                                        <th> Lý do hủy đơn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = ($orders->currentPage() - 1) * $orders->perPage();
                                    @endphp
                                    @if ($orders->isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center">Không tìm thấy đơn hàng </td>
                                        </tr>
                                    @endif
                                    @foreach ($orders as $item)
                                        <tr>
                                            <td>{{ ++$i }}.</td>
                                            <td>{{ $item->ma_don_hang }}</td>
                                            <td>
                                                @if ($item->trang_thai == 1)
                                                    <span class="badge badge-success">Đã thanh toán</span>
                                                @else
                                                    <span class="badge badge-warning">Chưa thanh toán</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->tinh_trang_giao_hang == 'ordered')
                                                    <span
                                                        class="badge badge-pill badge-secondary">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                                                @elseif ($item->tinh_trang_giao_hang == 'accepted')
                                                    <span
                                                        class="badge badge-pill badge-info">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                                                @elseif ($item->tinh_trang_giao_hang == 'delivering')
                                                    <span
                                                        class="badge badge-pill badge-dark">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                                                @elseif ($item->tinh_trang_giao_hang == 'canceled')
                                                    <span
                                                        class="badge badge-pill badge-danger">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-pill badge-success">{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ format_number($item->tong_tien) }} đ</td>
                                            <td><a
                                                    href="{{ route('admin.orderdetails', ['order_id' => $item->id]) }}">Details</a>
                                            </td>
                                            <td>
                                                @if ($item->tinh_trang_giao_hang !== 'canceled' && $item->tinh_trang_giao_hang !== 'delivered')
                                                    <div class="dropdown">
                                                        <button class="btn btn-success dropdown-toggle" type="button"
                                                            id="dropdownMenuButton{{ $item->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Giao hàng
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                            @if ($item->tinh_trang_giao_hang == 'ordered')
                                                                <li><a class="dropdown-item" href="#"
                                                                        wire:click.prevent="updateStatusDelivery({{ $item->id }}, 'accepted')">Đã
                                                                        xác nhận</a></li>
                                                            @endif
                                                            @if ($item->tinh_trang_giao_hang == 'accepted')
                                                                <li><a class="dropdown-item" href="#"
                                                                        wire:click.prevent="updateStatusDelivery({{ $item->id }}, 'delivering')">Đang
                                                                        giao</a></li>
                                                            @endif
                                                            @if ($item->tinh_trang_giao_hang == 'delivering')
                                                                <li><a class="dropdown-item" href="#"
                                                                        wire:click.prevent="updateStatusDelivery({{ $item->id }}, 'delivered')">Đã
                                                                        giao</a></li>
                                                            @endif
                                                            <li><a class="dropdown-item" href="#"
                                                                    wire:click.prevent="$set('selectedOrderId', {{ $item->id }})"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#cancelModal">Đã hủy</a></li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->tinh_trang_giao_hang == 'canceled')
                                                    {{ $item->li_do_huy_don }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Modal -->


@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeCancelModal', () => {
                $('.modal').modal('hide'); // Close all modals
            });
        });


        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close'); // Đóng alert
            }, 3000);
        });
    </script>
@endpush
