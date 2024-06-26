<div class="header-action-icon-2">
    <a class="mini-cart-icon" href="{{route('shop.cart')}}">
        <img alt="Surfside Media" src="{{asset('assets/imgs/theme/icons/icon-cart.svg')}}">
        @if(Cart::instance('cart')->count()>0)
        <span class="pro-count blue">{{Cart::count()}}</span>
        @endif
    </a>
    <div class="cart-dropdown-wrap cart-dropdown-hm2">
        <ul>
            @foreach (Cart::instance('cart')->content() as $item)
            <li>
                <div class="shopping-cart-img">
                    <a href="{{route('product.details', ['slug' => $item->model->slug])}}">
                        <img alt="{{$item->model->ten}}" src="{{asset('assets/imgs/products')}}/{{$item->model->image}}">
                    </a>
                </div>
                <div class="shopping-cart-title">
                    <h4 title="{{$item->model->ten}}">
                        <a href="{{route('product.details', ['slug' => $item->model->slug])}}" class="product-name">{{$item->model->ten}}</a>
                    </h4>
                    <h4><span>{{$item->qty}} × </span>${{$item->model->gia}}</h4>
                </div>
            </li>
            @endforeach
            
        </ul>
        <div class="shopping-cart-footer">
            <div class="shopping-cart-total">
                <h4>Total <span>đ{{Cart::instance('cart')->total()}}</span></h4>
            </div>
            <div class="shopping-cart-button">
                <a href="{{route('shop.cart')}}" class="outline">{{__('Xem giỏ hàng')}}</a>
                <a href="{{route('shop.checkout')}}">Thanh toán</a>
            </div>
        </div>
    </div>
</div>
<style>
    .product-name {
        display: inline-block;
        max-width: 150px; /* Điều chỉnh kích thước theo nhu cầu */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    </style>
