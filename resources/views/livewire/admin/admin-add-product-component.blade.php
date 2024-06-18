<div>
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block;
        }
        </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span>Thêm mới product
                  
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">Thêm mới Sản Phẩm</div>
                                <div class="col-md-6">
                                    <a href="{{route('admin.product')}}" class="btn btn-succsess float-end">All Sản Phẩm </a>
                                </div>
                            </div>
                        </div>
                            <div class="card-body">
                                @if(Session::has('message'))
                                <div class="alert alert-success" role="alert"> {{Session::get('message')}}</div>
                                @endif
                                <form wire:submit.prevent="addProduct()"> 
                                    <div class="mb-3 mt-3">
                                        <label for="name" class="form-label"> Tên</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" wire:model="name" wire:keyup="generateSlug"/> 
                                        @error('name')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label"> Slug</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Nhập slug sản phẩn"wire:model="slug"/> 
                                        @error('slug')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="short_desc" class="form-label">Mô tả ngắn</label>
                                        <textarea name="short_desc" placeholder="Nhập mô tả ngắn" class="form-control"wire:model="short_desc"></textarea>
                                        @error('short_desc')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="desc" class="form-label">  Miêu tả cụ thể</label>
                                        <textarea name="desc" placeholder="Nhập miêu tả " class="form-control" wire:model="desc"></textarea>
                                        @error('desc')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="regular_price" class="form-label"> Giá gốc</label>
                                        <input type="text" name="regular_price" class="form-control" placeholder="Nhập giá "wire:model="regular_price"/> 
                                        @error('regular_price')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="sale_price" class="form-label"> Giá sale</label>
                                        <input type="text" name="sale_price" class="form-control" placeholder="Nhập giá sale"wire:model="sale_price"/> 
                                        @error('sale_price')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    {{-- <div class="mb-3 mt-3">
                                        <label for="sku" class="form-label"> số hiệu</label>
                                        <input type="text" name="sku" class="form-control" placeholder="Nhạp số hiệu" wire:model="sku"/> 
                                        @error('sku')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div> --}}
                                    <div class="mb-3 mt-3">
                                        <label for="stock_stauts" class="form-label" > Tình trạng trong kho</label>
                                        <select class="form-control" name="stock_status"wire:model="stock_status" >
                                            <option value="instock">InStock</option>  
                                            <option value="outofstock">Out of Stock</option>  
                                        </select>
                                        @error('stock_status')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="featured" class="form-label" > Hổ trợ</label>
                                        <select class="form-control" name="featured" wire:model="featured">
                                            <option value="0">No</option>  
                                            <option value="1">Yes</option>  
                                        </select>
                                        @error('featured')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="quanity" class="form-label"> Số lượng</label>
                                        <input type="text" name="quanity" class="form-control" placeholder="Nhập số lượng"wire:model="quanity"/> 
                                        @error('quanity')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="image" class="form-label"> Image</label>
                                        <input type="file" name="image" class="form-control" wire:model="image"/>
                                        @if ($image)
                                        <img src="{{$image->temporaryUrl()}}" width="120"/>
                                        @endif
                                        @error('image')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="image" class="form-label"> Gallery</label>
                                        <input type="file" name="image" class="form-control" wire:model="images" multiple/>
                                        @if ($images)
                                        @foreach($images as $image)
                                        <img src="{{$image->temporaryUrl()}}" width="120"/> 
                                        @endforeach
                                        @endif
                                        @error('images')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="category_id" class="form-label" > Danh mục </label>
                                        <select class="form-control" name="category_id" wire:model="category_id" wire:change="changeSubcategory">
                                            <option value="">Select Category</option>  
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->ten}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="subcategory_id" class="form-label" >Danh mục con</label>
                                        <select class="form-control" name="subcategory_id" wire:model="subcategory_id">
                                            <option value="">None</option>  
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{$subcategory->id}}">{{$subcategory->ten}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                            {{-- <div class="mb-2 mt-2">
                                                <label for="subcategory_id" class="form-label" >Product Attributes</label>
                                                <div class="row"> 
                                                    <div class="col-lg-11">
                                                        <select class="form-control" name="subcategory_id" wire:model="attr">
                                                            <option value="">None</option>  
                                                            @foreach ($pattributes as $pattribute)
                                                                <option value="{{$pattribute->id}}">{{$pattribute->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1"> <button class="btn btn-danger float-end" wire:click.prevent="addAttr"> Add</button></div>
                                                </div>
                                            </div> --}}
                                            @foreach($inputs as $key=>$value)
                                            <div class="mb-3 mt-3">
                                                <label class="form-label"> {{$pattributes->where('id',$attr_array[$key])->first()->name}}</label>
                                                <div class="row"> 
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" placeholder="{{$pattributes->where('id',$attr_array[$key])->first()->name}}"wire:model="attr_values.{{$value}}"/> 
                                                    </div>
                                                    <div class="col-lg-2"><button class="btn btn-danger float-end" wire:click.prevent="remove({{$key}})"> Remove</button></div>
                                                </div>
                                            </div>
                                            @endforeach
                                    <button type="submit" class="btn btn-primary "> Thêm mới</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

