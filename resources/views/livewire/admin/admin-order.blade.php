<div>
    <style>
        nav svg {
            height: 20px;
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
                                <div class="col-md-4">Tất cả đơn hàng </div>
                                <div class="col-md-6"> <input type="text" class="form-control"
                                        placeholder="Nhập mã đơn hàng "wire:model="searchTerm" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert"> {{ Session::get('message') }}</div>
                            @endif
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> Mã đơn hàng </th>
                                        <th> Tình trạng đơn hàng</th>
                                        <th>Tình trạng giao hàng</th>
                                        <th>Tổng tiền </th>
                                        <th>Hành động</th>
                                        <th>Cập nhập đơn hàng </th>
                                        <th>Cập nhập trình trạng giao hàng</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = ($orders->currentPage() - 1) * $orders->perPage();
                                    @endphp
                                    @foreach ($orders as $item)
                                        <tr>
                                            {{-- <td> {{$item->id}}</td> --}}
                                            <td>{{ ++$i }}.</td>
                                            <td>{{ $item->ma_don_hang }}</td>
                                            <td>{{ $item->trang_thai == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}</td>
                                            <td>{{ $item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang) }}
                                            </td>
                                            <td> {{ $item->tong_tien }} đ</td>
                                            {{-- <td> {{$item->discount}}</td> --}}
                                            <td><a href="{{ route('admin.orderdetails', ['order_id' => $item->id]) }}">
                                                    details</a></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle" type="button"
                                                        id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Thanh toán
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li><a class="dropdown-item" href="#"
                                                                wire:click.prevent="updateStatus({{ $item->id }},1)">Đã
                                                                thanh toán</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="#"wire:click.prevent="updateStatus({{ $item->id }},0)">Chưa
                                                                thanh toán</a></li>
                                                    </ul>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle" type="button"
                                                        id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Giao hàng
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li><a class="dropdown-item" href="#"
                                                                wire:click.prevent="updateStatusDelivery({{ $item->id }},'accepted')">Đã
                                                                xác nhận</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="#"wire:click.prevent="updateStatusDelivery({{ $item->id }},'delivering')">Đang
                                                                giao</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="#"wire:click.prevent="updateStatusDelivery({{ $item->id }},'delivered')">Đã
                                                                giao</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="#"wire:click.prevent="updateStatusDelivery({{ $item->id }},'canceled')">Đã
                                                                hủy</a></li>
                                                    </ul>
                                                </div>
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

<div class="modal" id="deleteConfirmation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pb-30 pt-30">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="pb-3">Do you want Delete</h4>
                        <button type="button" class="btn btn-secondary" data-bs-modal="modal"
                            data-bs-modal="#deleteConfirmation">Cancel</button>
                        <button type="button" class="btn btn-danger"onclick="deleteProduct()">delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function deleteConfirmation(id) {
            @this.set('product_id', id);
            $('#deleteConfirmation').modal('show');

        }

        function deleteProduct() {
            @this.call('deleteProduct');
            $('#deleteConfirmation').modal('hide');
        }
    </script>
@endpush
