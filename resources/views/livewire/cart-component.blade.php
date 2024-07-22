<div>

    <main class="main">

        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('home.index')}}" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Your Cart
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table shopping-summery text-center clean">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        {{-- <th scope="col">Options</th> --}}
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng </th>
                                        <th scope="col">Tạm tính</th>
                                        <th scope="col">Xóa </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(Session::has('error_qty'))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong> {{Session::get('error_qty')}}</strong>
                                    </div>
                                    @endif
                                    @if(Session::has('success_message'))
                                    <div class="alert alert-success">
                                        <strong> {{Session::get('success_message')}}</strong>
                                    </div>
                                    @endif
                                    @if(Cart::instance('cart')->count()>0)
                                    @foreach(Cart::instance('cart')->content() as $item)
                                    <tr>
                                        <td class="image product-thumbnail"><img src="{{asset('assets/imgs/products')}}/{{$item->model->image}}" alt="#"></td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name"><a href="{{route('product.details',['slug'=>$item->model->slug])}}">{{$item->model->ten}}</a></h5>
                                            {{-- <p class="font-xs">Maboriosam in a tonto nesciung eget<br> distingy magndapibus.
                                            </p> --}}
                                        </td>

                                        {{-- @if(!empty($item->options))
                                        <td> 
                                            @foreach($item->options->color as $value)
                                                <p>Color:{{$value}}</p>
                                        @endforeach
                                        @foreach($item->options->size as $s)
                                        <p>Size:{{$s}}</p>
                                        @endforeach
                                        @if(isset($item->options->color) && is_array($item->options->color) && count($item->options->color) > 0)
                                        @foreach($item->options->color as $value)
                                        <p>Color: {{$value}}</p>
                                        @endforeach
                                        @endif
                                        @if(isset($item->options->size) && is_array($item->options->size) && count($item->options->size) > 0)
                                        @foreach($item->options->size as $s)
                                        <p>Size: {{$s}}</p>
                                        @endforeach
                                        @endif
                                        </td>
                                        @endif --}}

                                        <td class="price" data-title="Price"><span>{{$item->model->gia}} </span></td>
                                        <td class="text-center" data-title="Stock">
                                            <div class="detail-qty border radius  m-auto">
                                                <a href="#" class="qty-down" wire:click.prevent="decreaseQuantity('{{$item->rowId}}')"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">{{$item->qty}}</span>
                                                <a href="#" class="qty-up"wire:click.prevent="increaseQuantity('{{$item->rowId}}')"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </td>

                                        <td class="text-right" data-title="Cart">
                                            <span>đ{{$item->subtotal}} </span>
                                        </td>
                                        <td class="action" data-title="Remove"><a href="#" class="text-muted" wire:click.prevent="destroy('{{$item->rowId}}')"><i class="fi-rs-trash"></i></a></td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="6" class="text-end">
                                            <a href="#" class="text-muted" wire:click.prevent="clearAll()"> <i class="fi-rs-cross-small"></i> Xóa giỏ hàng</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @else
                            <p> Không có sản phẩm nào trong giỏ hàng </p>
                            @endif
                        </div>
                        <div class="cart-action text-end">
                            <a class="btn " href="{{route('shop')}}"><i class="fi-rs-shopping-bag mr-10"></i>Tiếp tục mua sắm</a>
                        </div>
                        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                        <div class="row mb-50">
                            <div class="col-lg-6 col-md-12">

                                <div class="mb-30 mt-50">
                                    <div class="heading_s1 mb-3">
                                        <h4>Áp dụng mã giảm giá</h4>
                                    </div>
                                    <div class="total-amount">
                                        <div class="total-amount">
                                            <div class="left">
                                                <div class="coupon">
                                                    @if(Session::has('cp_mess'))
                                                    <div class="alert alert-success"> {{Session::get('cp_mess')}}</div>
                                                    @endif
                                                    @if(Session::has('cp_applied'))
                                                    <div class="alert alert-success"> {{Session::get('cp_applied')}}</div>
                                                    @endif
                                                    <form wire:submit.prevent="applyCoupon">
                                                        <div class="form-row row justify-content-center">
                                                            <div class="form-group col-lg-6">
                                                                <input class="font-medium" name="Coupon" style="width:100%" placeholder="Nhập mã giảm giá của bạn" wire:model="couponcode">
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <button class="btn btn-sm" type="submit"><i class="fi-rs-label mr-10"></i>Sử dụng</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="border p-md-4 p-30 border-radius cart-totals">
                                    <div class="heading_s1 mb-3">
                                        <h4>Cart Totals</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="cart_total_label">Tạm tính đơn hàng</td>
                                                    <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">đ{{Cart::subtotal()}}</span></td>
                                                </tr>
                                                @if(Session::has('coupon'))
                                                <tr>
                                                    <th>Giảm giá({{Session::get('coupon')['code']}}) <a href="" wire:click.prevent="removeCoupon"><i class="fi-rs-cross"></i> </a> </th>
                                                    <td colspan="2"><em>{{Session::get('checkout')['discount']}} </em></td>
                                                </tr>
                                                <tr>
                                                    <th>Tạm tính sau giảm giá</th>
                                                    <td colspan="2"><em>{{$subtotalAfterDiscount}}</em></td>
                                                </tr>
                                                <tr>
                                                    <th>Phí giao hàng</th>
                                                    <td colspan="2"><em>đ{{config('cart.tax')}}</em></td>
                                                </tr>
                                                <tr>
                                                    <th>Tổng đơn</th>
                                                    <td colspan="2"><em>{{$totalAfterDiscount}}</em></td>
                                                </tr>

                                                @else
                                                <tr>
                                                    <td class="cart_total_label">Phí giao hàng</td>
                                                    <td class="cart_total_amount"> <i class="ti-gift mr-5"></i> đ{{config('cart.tax')}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cart_total_label">Tổng tiền</td>
                                                    <td class="cart_total_amount"><strong><span class="font-xl fw-900 text-brand">đ{{Cart::total()}}</span></strong></td>
                                                </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{route('shop.checkout')}}" id="checkoutButton" class="btn "> <i class="fi-rs-box-alt mr-10"></i> Tiến hành thanh toán</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<div class="modal" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pb-30 pt-30">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="pb-3">Bạn chưa đăng nhập vui lòng đăng nhập để tiền hành thanh toán</h4>
                        <a type="button" href="{{route('login')}}" class="btn btn-secondary" data-bs-modal="modal">Đăng nhập</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

@push('scripts')
<script>
    var isAuthenticated = @json(Auth::check());
    console.log(isAuthenticated)
    document.getElementById('checkoutButton').addEventListener('click', function() {
        event.preventDefault();
        if (!isAuthenticated) {
            var modal = document.getElementById('loginModal');
            var instance = M.Modal.init(modal);
            instance.open();
        } else {
            window.location.href = "{{ route('shop.checkout') }}";
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alert = document.querySelector('.alert-dismissible');
                if (alert) {
                    alert.classList.remove('show');
                }
            }, 4000); // 4000 milliseconds = 4 seconds
        });
</script>
@endpush
