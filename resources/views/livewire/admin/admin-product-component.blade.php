<div>
    <style>
        nav svg {
            height: 20px;
        }

        nav .hidden {
            display: block;
        }
        .border-danger{
            border-color: #af233a !important;
        }
        select {
  
            appearance: none;
            outline: 10px red;
            border: 0;
            box-shadow: none;

            flex: 1;
            padding: 0 1em;
            color: #111010;
            background-color: var(--darkgray);
            background-image: none;
            cursor: pointer;
        }

        select::-ms-expand {
            display: none;
        }
        .select {
            position: relative;
            display: flex;
            width: 20em;
            height: 2em;
            border-radius: .25em;
            overflow: hidden;
            background-color: #bbd6f2;
        }
        .select::after {
            content: '\25BC';
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.5em;
            background-color: #34495e;
            transition: .25s all ease;
            pointer-events: none;
        }

        /* Transition */
        .select:hover::after {
            color: #f39c12;
        }
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> All Product

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
                                    <select class="form-select border border-danger" wire:model="selectedCategory">
                                        <option value="">Tìm theo danh mục</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                        <select class="form-select border border-danger" wire:model="selectedFilter">
                                            <option value="">Lọc</option>
                                            <option value="newest">Ngày nhập mới nhất</option>
                                            <option value="oldest">Ngày nhập trễ  nhất</option>
                                            <option value="lowest_price">Giá từ thấp tới cao</option>
                                            <option value="highest_price">Giá từ cao tới thấp</option>
                                        </select>
                                </div>
                               
                                <div class="col-md-6"> <input type="text" class="form-control form-control border border-danger"
                                        placeholder="Nhập tên,mã sản phẩm..."wire:model="searchTerm" />
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('admin.product.add') }}" class="btn btn-succsess float-end">Thêm sản phẩm </a>
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
                                        <th> Ảnh</th>
                                        <th>Mã sản phẩm</th>
                                        <th style="width=30px;"> Tên</th>
                                        <th> Tình trạng ở kho</th>
                                        <th> Giá gốc </th>
                                        <th> Danh mục</th>
                                        <th> Ngày nhập</th>
                                        <th> Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = ($products->currentPage() - 1) * $products->perPage();
                                    @endphp
                                    @if ($products->isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center">Không tìm thấy sản phẩm </td>
                                        </tr>
                                    @endif
                                    @foreach ($products as $item)
                                        <tr>
                                            {{-- <td> {{$item->id}}</td> --}}
                                            <td>{{ ++$i }}.</td>
                                            <td><img src="{{ asset('assets/imgs/products') }}/{{ $item->image }}"
                                                    alt="{{ $item->image }}" width='80px' height='70px' /></td>
                                            <td >{{ $item->ma_sp }}</td>

                                            <td> {{ $item->ten }}</td>
                                            <td> {{ $item->so_luong }} sp</td>
                                            <td> {{ format_number($item->gia) }}</td>
                                            <td> {{ $item->category->ten }}</td>
                                            <td> {{ $item->created_at }}</td>
                                            <td><a href="{{ route('admin.product.edit', ['product_id' => $item->id]) }}"
                                                    class="text-success ">Edit </a>
                                                <a href="#" onclick="deleteConfirmation({{ $item->id }})"
                                                    class="text-danger  ">Delete </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->links() }}
                        </div>
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
