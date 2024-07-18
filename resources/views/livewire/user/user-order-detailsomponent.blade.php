<div>
    <style>
        .hidden {
            display: none;
        }

        .gradient-custom {
            /* fallback for old browsers */
            background: #a8729a;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to top left, rgb(252, 252, 252), rgba(246, 243, 255, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to top left, rgb(241, 84, 18, 1), rgb(255, 255, 255));
        }

        .main {
            padding: 20px;
        }

        .btn-danger {
            margin-top: 20px;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header,
        .card-footer {
            background-color: #a8729a;
            color: white;
        }

        .card-header h5,
        .card-footer h5 {
            margin: 0;
        }

        .text-center h1 {
            margin-bottom: 30px;
        }

        .alert {
            margin-top: 20px;
        }

        .progress {
            height: 6px;
            border-radius: 16px;
        }

        .progress-bar {
            background-color: #a8729a;
        }

        .text-muted {
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .button-contactForm {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color .3s;
        }

        .button-contactForm:hover {
            background-color: #218838;
        }

        .text-danger {
            color: #dc3545;
        }

        .card-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .btn-danger {
            margin: 10px 0;
        }
    </style>
    <main class="main">
        <div class="row">
            <div class="col-12">
                <div class="col col-lg-2" style="padding-top: 100px">
                    <a href="{{route('user.order')}}" class="btn btn-danger">Tất cả đơn hàng của bạn</a>
                </div>
                <div class="col-md-auto">
                    <div class="text-center">
                        <h1>Chi tiết đơn hàng</h1>
                    </div>
                    <div class="col col-lg-2"></div>
                    <div class="row">
                        <h2></h2>
                        <div class="col-sm"></div>
                        <div class="col-sm">
                            <div id="formContainer" @if($showForm) class="" @else class="hidden" @endif>
                                <textarea name="reason_cancel" placeholder="Write your reason here..." cols="30" rows="10" wire:model='reason_cancel'></textarea>
                                <div class="text-center"><a href="#" type="button" class="btn btn-danger" id="cancelButton" wire:click.prevent="cancelOrder">Xác nhận Hủy</a> </div>
                            </div>
                        </div>
                        <div class="col-sm"></div>
                    </div>

                    @if(Session::has('cancel_message'))
                    <div class="alert alert-success">
                        <strong>{{Session::get('cancel_message')}}</strong>
                    </div>
                    @endif
                    @if(Session::has('review_message'))
                    <div class="alert alert-success">
                        <strong>{{Session::get('review_message')}}</strong>
                    </div>
                    @endif

                    <section class="h-100 gradient-custom">
                        <div class="container py-5 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-lg-10 col-xl-8">
                                    <div class="card" style="border-radius: 10px;">
                                        <div class="card-header px-4 py-5">
                                            <h5 class="text-muted mb-0">Thanks for your Order, <span style="color: #f15412;">{{Auth::user()->name}}</span>!</h5>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <p class="lead fw-normal mb-0" style="color: #a8729a;">Hóa đơn</p>
                                                @if($order->tinh_trang_giao_hang !== 'canceled' && $order->tinh_trang_giao_hang !=='delivered'&& $order->tinh_trang_giao_hang !=='accepted')
                                                <a href="#" id="showFormButton" class="btn btn-danger" wire:click.prevent="showForm">Hủy đơn hàng này</a>
                                                @endif
                                            </div>
                                            @foreach($order->orderDetails as $item)
                                            <div class="card shadow-0 border mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <img src="{{asset('assets/imgs/products')}}/{{$item->product->image}}" alt="#">
                                                        </div>
                                                        <div class="col-md-3 text-center d-flex justify-content-center align-items-center">
                                                            <p class="text-muted mb-0">{{$item->product->ten}}</p>
                                                        </div>
                                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                                            {{-- @php $options=json_decode($item->options); @endphp --}}
                                                            {{-- <p class="text-muted mb-0 small"> @foreach($options->color as $key => $value) {{$value}} @endforeach </p> --}}
                                                            <p class="text-muted mb-0 small">
                                                                {{-- @if(isset($options->color) && is_array($options->color) && count($options->color) > 0) @foreach($options->color as $key => $value) {{$value}} @endforeach @endif --}}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                                            {{-- <p class="text-muted mb-0 small">@foreach($options->size as $key => $va) {{$va}} @endforeach</p> --}}
                                                        </div>
                                                        <div class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                                            <p class="text-muted mb-0 small">Qyt:{{$item->so_luong}}</p>
                                                        </div>
                                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                            <p class="text-muted mb-0 small">${{$item->product->gia}}</p>
                                                        </div>
                                                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                            @if($order->tinh_trang_giao_hang=='delivered'&& $item->trang_thai_danh_gia== false)
                                                            <p class="text-muted mb-0 small"><a href="{{route('user.review',['order_details_id'=>$item->id])}}"> Viết đánh giá</a></p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-md-2">
                                                            <p class="text-muted mb-0 small">Track Order</p>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="progress" style="height: 6px; border-radius: 16px;">
                                                                <div class="progress-bar" role="progressbar" style="width:
                                                                    @if($order->tinh_trang_giao_hang === 'ordered')
                                                                    0%;
                                                                    @elseif($order->tinh_trang_giao_hang === 'accepted')
                                                                    40%;
                                                                    @elseif($order->tinh_trang_giao_hang === 'delivering')
                                                                    60%;
                                                                    @else
                                                                    100%;
                                                                    @endif">
                                                                </div>
                                                                <div class="border-radius: 16px; background-color: #a8729a;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <div class="d-flex justify-content-around mb-1">
                                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Đã đặt</p>
                                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Đã xác nhận</p>
                                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Đang giao</p>
                                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Đã giao</p>
                                                            </div>
                                                        </div>
                                                        @if($order->status_delivery=='canceled')
                                                        <p class="text-muted mt-1 mb-0 small ms-xl-5">Canceled</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="d-flex justify-content-between pt-2">
                                                <p class="fw-bold mb-0 px-3">Chi tiết hóa đơn</p>
                                                <p class="text-muted mb-0 mx-2"><span class="fw-bold me-4">Tạm tính</span>{{$order->tam_tinh}} </p>
                                            </div>
                                            {{-- {{$order->tam_tinh - round($order->tam_tinh * (0.1/1.1),1)}} --}}
                                            <div class="d-flex justify-content-between pt-2">
                                                <p class="text-muted mb-0 px-3">Mã đơn hàng: {{$order->ma_don_hang}}</p>
                                                <p class="text-muted mb-0 mx-2"><span class="fw-bold me-4">Giảm giá</span> {{$order->giam_gia}}</p>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <p class="text-muted mb-0 px-3">Ngày Đặt: {{$order->created_at->format('d.m.Y')}}</p>
                                                <p class="text-muted mb-0 mx-2"><span class="fw-bold me-4">Phí giao hàng</span> {{config('cart.tax')}}</p>
                                            </div>

                                            <div class="d-flex justify-content-between mb-5">
                                                {{-- <p class="text-muted mb-0">Recepits Voucher : None</p> --}}
                                                {{-- <p class="text-muted mb-0"><span class="fw-bold me-4">Delivery Charges</span> Free</p> --}}
                                            </div>
                                        </div>

                                        <div class="card-footer border-0 px-4 py-4" style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Tổng hóa đơn: <span class="h2 mb-0 ms-2">{{$order->tong_tien}}</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
    // Add any custom JavaScript here
</script>
@endpush
