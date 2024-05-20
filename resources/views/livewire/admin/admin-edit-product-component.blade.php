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
                    <span></span>Cập nhập sản phẩm
                  
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">Thêm mới sản phâm</div>
                                <div class="col-md-6">
                                    <a href="{{route('admin.product')}}" class="btn btn-succsess float-end">Tất cả sản phẩm </a>
                                </div>
                            </div>
                        </div>
                            <div class="card-body">
                                @if(Session::has('message'))
                                <div class="alert alert-success" role="alert"> {{Session::get('message')}}</div>
                                @endif
                                <form wire:submit.prevent="updateProduct()"> 
                                    <div class="mb-3 mt-3">
                                        <label for="name" class="form-label"> Tên sản phẩm</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" wire:model="name" wire:keyup="generateSlug"/> 
                                        @error('name')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label"> Slug</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Nhập slug sản phẩm"wire:model="slug"/> 
                                        @error('slug')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="short_desc" class="form-label"> Miêu tả ngắn</label>
                                        <textarea name="short_desc" placeholder="miêu tả ngắn" class="form-control"wire:model="short_desc"></textarea>
                                        @error('short_desc')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="desc" class="form-label"> Miêu tả cụ thể</label>
                                        <textarea name="desc" placeholder="Nhập miêu tả" class="form-control" wire:model="desc"></textarea>
                                        @error('desc')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="regular_price" class="form-label">Giá gốc</label>
                                        <input type="text" name="regular_price" class="form-control" placeholder="Nhập giá gốc"wire:model="regular_price"/> 
                                        @error('regular_price')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="sale_price" class="form-label">Giá sale</label>
                                        <input type="text" name="sale_price" class="form-control" placeholder="Nhập giá sale"wire:model="sale_price"/> 
                                        @error('sale_price')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="sku" class="form-label"> Số hiệu</label>
                                        <input type="text" name="sku" class="form-control" placeholder="Nhập số hiệu" wire:model="sku"/> 
                                        @error('sku')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="stock_stauts" class="form-label" > Tình trạng tồn kho</label>
                                        <select class="form-control" name="stock_status"wire:model="stock_status" >
                                            <option value="instock">Còn hàng </option>  
                                            <option value="outofstock">Hết hàng </option>  
                                        </select>
                                        @error('stock_status')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="featured" class="form-label" > Tính năng</label>
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
                                        <label for="newImage" class="form-label"> Image</label>
                                        <input type="file" name="image" class="form-control" wire:model="newImage"/>
                                        @if ($newImage)
                                        <img src="{{$newImage->temporaryUrl()}}" width="120"/>
                                        @else
                                        <img src="{{asset('assets/imgs/products')}}/{{$image}}" width="120"/>
                                        @endif
                                        @error('newImage')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="newimages" class="form-label"> Gallery</label>
                                        <input type="file" name="images" class="form-control" wire:model="newimages" multiple/>
                                        @if ($newimages)
                                        @foreach($newimages as $newimage)
                                        <img src="{{$newimage->temporaryUrl()}}" width="120"/> 
                                        @endforeach
                                        @else
                                        @foreach($images as $image)
                                            @if($image)
                                            <img src="{{asset('assets/imgs/products')}}/{{$image}}" width="120"/>
                                            @endif
                                        @endforeach
                                        @endif
                                        
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="category_id" class="form-label" > Danh mục </label>
                                        <select class="form-control" name="category_id" wire:model="category_id">
                                            <option value="">Select Category</option>  
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    {{-- asd --}}
                                    <div class="mb-3 mt-3">
                                        <label for="subcategory_id" class="form-label" >Danh mục con </label>
                                        <select class="form-control" name="subcategory_id" wire:model="scategory_id">
                                            <option value="">None</option>  
                                            @foreach ($scategories as $subcategory)
                                                <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                           
                                    {{-- <div class="mb-2 mt-2">
                                        <label for="subcategory_id" class="form-label" >Product Attributes</label>
                                        <div class="row"> 
                                            <div class="col-lg-11">
                                                <select class="form-control" name="subcategory_id" wire:model="attr">
                                                    <option value="">None</option>  
                                                    @foreach ($pattrs as $pattribute)
                                                        <option value="{{$pattribute->id}}">{{$pattribute->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-1"> <button class="btn btn-danger float-end" wire:click.prevent="addAttr"> Add</button></div>
                                        </div>
                                    </div> --}}
                                    {{-- @foreach($inputs as $key=>$value)
                                    <div class="mb-3 mt-3">
                                        <label class="form-label"> {{$pattrs->where('id',$attr_array[$key])->first()->name}}</label>
                                        <div class="row"> 
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" placeholder="{{$pattrs->where('id',$attr_array[$key])->first()->name}}"wire:model="attr_values.{{$value}}"/> 
                                            </div>
                                            <div class="col-lg-2"><button class="btn btn-danger float-end" wire:click.prevent="remove({{$key}})"> Remove</button></div>
                                        </div>
                                    </div>
                                    @endforeach --}}
                                    <button type="submit" class="btn btn-primary float-end"> submit</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>