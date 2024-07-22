<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="/" rel="nofollow">Home</a>
                <span></span> Chi tiết đơn hàng
              
            </div>
        </div>
    </div>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="col-lg-12 ">
                <div class="row">
                    <br>
                    <br>
                    <div>
                        <h1>Thông tin chủ đơn hàng:</h1>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
            
                                <th>Email</th>
                                <th> Tên người đặt</th>
                                <th> Địa chỉ </th>
                                <th> Số điện thoại</th>
                                <th>Tên người nhận</th>
                                <th> Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> {{ $order->email }}</td>
                                <td> {{ $order->user_ten }}</td>
                                <td> {{ $order->user_diachi }}</td>
                                <td>{{ $order->user_sdt }}</td>
                                <td> {{ $order->user->ten }}</td>
                                <td> {{ $order->ghi_chu }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                    <div class="text-center">
                        <h1>Thông tin chi tiết đơn hàng:{{ $order->ma_don_hang }} </h1>
                    </div>
                    <div class="table-responsive">
                        <table class="table shopping-summery text-center clean">
                            <thead>
                                <tr class="main-heading">
                                    <th scope="col">Image</th>
                                    <th> Mã sản phẩm</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lương</th>
                                    <th scope="col">Tổng tiền</th>
            
                                </tr>
                            </thead>
                            <tbody>
                                @if (Session::has('success_message'))
                                    <div class="alert alert-success">
                                        <strong> Success |{{ Session::get('success_message') }}</strong>
                                    </div>
                                @endif
            
                                @foreach ($order->orderDetails as $item)
                                    <tr>
                                        <td class="image product-thumbnail"><img
                                                src="{{ asset('assets/imgs/products') }}/{{ $item->product->image }}"
                                                alt="#"></td>
                                                <td> {{ $item->product->ma_sp }}</td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name"><a
                                                    href="{{ route('product.details', ['slug' => $item->product->slug]) }}">{{ $item->product->ten }}</a>
                                            </h5>
                                            {{-- <p class="font-xs">Maboriosam in a tonto nesciung eget<br> distingy magndapibus.
                                                        </p> --}}
                                        </td>
                                        <td class="price" data-title="Price"><span>{{ $item->product->gia }} </span></td>
                                        <td class="text-center" data-title="Stock">
                                            <div class="detail-qty border radius  m-auto">
                                                <span class="qty-val">{{ $item->so_luong }}</span>
                                            </div>
                                        </td>
            
                                        <td class="text-right" data-title="Cart">
                                            <span>{{ $item->so_luong * $item->product->gia }} đ</span>
                                        </td>
                                    </tr>
                                @endforeach
            
                            </tbody>
            
                        </table>
                        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                        <div class="table-responsive">
                            <table class="table shopping-summery text-center clean">
                                <tbody>
                                    {{-- @foreach ($order->orderDetails as $item) --}}
                                    @php $shipFee=config('cart.tax'); @endphp
                                    <tr>
                                        <td class="cart_total_label">Tạm tính</td>
                                        <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">
                                                {{ $order->tong_tien - $shipFee }}</span></td>
                                    </tr>
                                    {{-- ${{$order->total - round($order->total * (0.1/1.1),1)}} --}}
                                    {{-- <tr>
                                                            <td class="cart_total_label">Tax</td>
                                                            <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">${{round($order->total * (0.1/1.1),1)}}</span></td>
                                                        </tr> --}}
            
                                    <tr>
                                        <td class="cart_total_label">Phí ship</td>
                                        <td class="cart_total_amount"> <i class="ti-gift mr-5"></i> {{ $shipFee }}</td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">Tổng tiền </td>
                                        <td class="cart_total_amount"><strong><span
                                                    class="font-xl fw-900 text-brand">{{ $order->tong_tien }}</span></strong></td>
                                    </tr>
                                </tbody>
                            </table>
            
            
                        </div>
            
            
                    </div>
                </div>
            
            </div>
        </div>
    </section>

