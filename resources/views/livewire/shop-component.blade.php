<div>
    <style>
        nav svg {
            height: 20px;
        }

        nav .hidden {
            display: block;
        }

        .wishlisted {
            background-color: #F15412 !important;
            border: 1px solid transparent !important;
        }

        .wishlisted i {
            color: #fff !important;
        }
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">{{ __('Trang chủ') }}</a>
                    <span></span>{{ __('Cửa hàng') }}
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        {{-- {{dd($products->category);}} --}}
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p> {{ __('Chúng tôi có ') }}<strong
                                        class="text-brand">{{ $products->count() }}</strong>
                                    {{ __('sản phẩm cho bạn') }}</p>
                            </div>
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Show:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span> {{ $pageSize }} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ $pageSize == 10 ? 'active' : '' }}" href="#"
                                                    wire:click.prevent="changePageSize(10)">10</a></li>
                                            <li><a class="{{ $pageSize == 15 ? 'active' : '' }}"
                                                    href="#"wire:click.prevent="changePageSize(15)">15</a></li>
                                            <li><a class="{{ $pageSize == 20 ? 'active' : '' }}"
                                                    href="#"wire:click.prevent="changePageSize(20)">20</a></li>
                                            <li><a class="{{ $pageSize == 25 ? 'active' : '' }}"
                                                    href="#"wire:click.prevent="changePageSize(25)">25</a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span>{{ $orderBy }} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ $orderBy == 'Default Sorting' ? 'active' : ' ' }}"href="#"
                                                    wire:click.prevent="changeOrderBy('Default Sorting')">Default
                                                    Sorting</a></li>
                                            <li><a class="{{ $orderBy == 'Price:Low to High' ? 'active' : ' ' }}"href="#"
                                                    wire:click.prevent="changeOrderBy('Price:Low to High')">Price: Low
                                                    to High</a></li>
                                            <li><a class="{{ $orderBy == 'Price:High to Low' ? 'active' : ' ' }}"href="#"
                                                    wire:click.prevent="changeOrderBy('Price:High to Low')">Price: High
                                                    to Low</a></li>
                                            <li><a class="{{ $orderBy == 'Sort by Newness' ? 'active' : ' ' }}"href="#"
                                                    wire:click.prevent="changeOrderBy('Sort by Newness')">Sort by
                                                    Newness</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row product-grid-3">
                            @php
                                $witems = Cart::instance('wishlist')->content()->pluck('id');
                            @endphp
                            @foreach ($products as $item)
                                <div class="col-lg-4 col-md-4 col-6 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom"
                                                style="width: 300px; height: 400px;">
                                                <a href="{{ route('product.details', ['slug' => $item->slug]) }}">
                                                    <img class="default-img"
                                                        src="{{ asset('assets/imgs/products') }}/{{ $item->image }}"
                                                        alt="{{ $item->ten }}">

                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                {{-- <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                                <i class="fi-rs-search"></i></a> --}}
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    wire:click.prevent="addToWishlist({{ $item->id }},'{{ $item->ten }}','{{ $item->gia }}')"
                                                    href="#"><i class="fi-rs-heart"></i></a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                {{-- <span class="hot">Hot</span> --}}
                                            </div>
                                        </div>

                                        <div class="product-content-wrap mt-3">
                                            <div class="product-category">
                                                <a href="shop.html">{{ $item->category->ten }}</a>
                                            </div>
                                            <h2><a href="product-details.html">{{ $item->ten }}</a></h2>
                                            <div class="rating-result" title="100%">

                                                <span>
                                                    <span>90%</span>
                                                </span>
                                            </div>
                                            <div class="product-price">
                                                <span>đ{{ $item->gia }} </span>

                                            </div>
                                            <div class="product-action-1 show">
                                                @if ($witems->contains($item->id))
                                                    <a aria-label="Remove To Wishlist"
                                                        class="action-btn hover-up wishlisted" href="#"
                                                        wire:click.prevent="removeFromWishlist({{ $item->id }})"><i
                                                            class="fi-rs-heart"></i></a>
                                                @else
                                                    <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                        href="#"
                                                        wire:click.prevent="addToWishlist({{ $item->id }},'{{ $item->ten }}','{{ $item->gia }}')"><i
                                                            class="fi-rs-heart"></i></a>
                                                @endif
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                    href="{{ route('product.details', ['slug' => $item->slug]) }}">
                                                    {{-- " wire:click.prevent="store({{$item->id}},'{{$item->name}}','{{$item->regular_price}}')" --}}
                                                    <i class="fi-rs-shopping-bag-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!--pagination-->
                            {{ $products->links() }}
                            <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar abc">
                        <div class="row">
                            <div class="col-lg-12 col-mg-6"></div>
                            <div class="col-lg-12 col-mg-6"></div>
                        </div>
                        <div class="widget-category mb-30">
                            <h5 class="section-title style-1 mb-30 wow fadeIn animated">{{ __('Danh mục') }}</h5>
                            <ul class="categories">

                                @foreach ($categories as $category)
                                    @if (count($category->subCategories) > 0)
                                        <li class="has-children">
                                            <a href="{{ route('product.category', ['slug' => $category->slug]) }}"><i
                                                    class="surfsidemedia-font-dress"></i>{{ $category->ten }}</a>
                                            <div class="dropdown-menu">
                                                <ul class="mega-menu d-lg-flex">
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul class="d-lg-flex">
                                                            <li class="mega-menu-col col-lg-6">
                                                                <ul>
                                                                    @foreach ($category->subCategories as $scategory)
                                                                        <li><a class="dropdown-item nav-link nav_item"
                                                                                href="{{ route('product.category', ['slug' => $category->slug, 'scategory_slug' => $scategory->slug]) }}">{{ $scategory->ten }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>

                                                        </ul>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>
                                    @else
                                        <li><a href="{{ route('product.category', ['slug' => $category->slug]) }}"><i
                                                    class="surfsidemedia-font-desktop"></i>{{ $category->ten }}</a>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                        <!-- Fillter By Price -->
                        <div class="sidebar-widget price_range range mb-30">
                            <div class="widget-header position-relative mb-20 pb-10">
                                <h5 class="widget-title mb-10">{{ __('Lọc theo giá ') }}</h5>
                                <div class="bt-1 border-color-1"></div>
                            </div>
                            <div class="price-filter">
                                <div class="price-filter-inner">
                                    <div id="slider-range" wire:ignore></div>
                                    <div class="price_slider_amount">
                                        <div class="label-input">
                                            <span>Range:</span><span
                                                class="text-info">đ{{ $min_value }}</span>-<span
                                                class="text-info">{{ $max_value }}đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div>
                            <div class="list-group-item mb-10 mt-10">
                                <div class="widget-header position-relative">
                                    <h5 class="widget-title mb-10">{{ __('Lọc nâng cao') }}</h5>
                                    <div class="bt-1 border-color-1"></div>
                                </div>
                        
                                <!-- Screen Type Filter -->
                                <label class="fw-900">Loại màn hình</label>
                                <select wire:model="selectedScreenType" class="form-select">
                                    <option value="">{{ __('Chọn loại màn hình') }}</option>
                                    @foreach ($screenTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                        
                                <!-- Phone Size Filter -->
                                <label class="fw-900 mt-15">Kích thước điện thoại</label>
                                <select wire:model="selectedPhoneSize" class="form-select">
                                    <option value="">{{ __('Chọn kích thước') }}</option>
                                    @foreach ($phoneSizes as $size)
                                        <option value="{{ $size }}">{{ $size }}</option>
                                    @endforeach
                                </select>
                        
                                <!-- Battery Capacity Filter -->
                                <label class="fw-900 mt-15">Dung lượng pin</label>
                                <select wire:model="selectedBatteryCapacity" class="form-select">
                                    <option value="">{{ __('Chọn dung lượng pin') }}</option>
                                    @foreach ($batteryCapacities as $capacity)
                                        <option value="{{ $capacity }}">{{ $capacity }}</option>
                                    @endforeach
                                </select>
                        
                                <!-- Charging Power Filter -->
                                <label class="fw-900 mt-15">Công suất sạc</label>
                                <select wire:model="selectedChargingPower" class="form-select">
                                    <option value="">{{ __('Chọn công suất sạc') }}</option>
                                    @foreach ($chargingPowers as $power)
                                        <option value="{{ $power }}">{{ $power }}</option>
                                    @endforeach
                                </select>
                        
                                <!-- Charging Port Filter -->
                                <label class="fw-900 mt-15">Cổng sạc</label>
                                <select wire:model="selectedChargingPort" class="form-select">
                                    <option value="">{{ __('Chọn cổng sạc') }}</option>
                                    @foreach ($chargingPorts as $port)
                                        <option value="{{ $port }}">{{ $port }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Display Filtered Products -->
                            <div class="products mt-15">
                                @foreach ($products as $product)
                                    <div class="product-item">
                                        <h3>{{ $product->name }}</h3>
                                        <p>{{ $product->description }}</p>
                                        <!-- Add other product details here -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="sidebar-widget product-sidebar  mb-30 p-30 bg-grey border-radius-10">
                            <div class="widget-header position-relative mb-20 pb-10">
                                <h5 class="widget-title mb-10">Sản phẩm mới ra mắt</h5>
                                <div class="bt-1 border-color-1"></div>
                            </div>
                            @foreach ($newProds as $newProd)
                                <div class="single-post clearfix">
                                    <div class="image">
                                        <img class="default-img"
                                            src="{{ asset('assets/imgs/products') }}/{{ $newProd->image }}"
                                            alt="{{ $newProd->ten }}">
                                    </div>
                                    <div class="content pt-10">
                                        <h5><a href="product-details.html">{{ $newProd->ten }}</a></h5>
                                        <p class="price mb-0 mt-5">{{ $newProd->gia }}đ</p>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@push('scripts')
    <script>
        var sliderrange = $('#slider-range');
        var amountprice = $('#amount');
        $(function() {
            sliderrange.slider({
                range: true,
                min: 0,
                max: 1000000,
                values: [0, 1000000],
                slide: function(event, ui) {
                    // amountprice.val("$" + ui.values[0] + " - $" + ui.values[1]);
                    @this.set('min_value', ui.values[0]);
                    @this.set('max_value', ui.values[1]);
                }
            });

        });
    </script>
@endpush
