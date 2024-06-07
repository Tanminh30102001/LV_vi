<div>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span>Thêm mới danh mục 
                  
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">Thêm mới danh mục</div>
                                <div class="col-md-6">
                                    <a href="{{route('admin.categories')}}" class="btn btn-succsess float-end">Tất cả danh mục  </a>
                                </div>
                            </div>
                        </div>
                            <div class="card-body">
                                @if(Session::has('message'))
                                <div class="alert alert-success" role="alert"> {{Session::get('message')}}</div>
                                @endif
                                <form wire:submit.prevent="storeCategory()"> 
                                    <div class="mb-3 mt-3">
                                        <label for="name" class="form-label"> Tên</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên" wire:model="name" wire:keyup="generateSlug"/> 
                                        @error('name')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="slug" class="form-label"> Slug</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Nhập slug"wire:model="slug"/> 
                                        @error('slug')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="image" class="form-label"> Image</label>
                                        <input type="file" name="slug" class="form-control" wire:model="image"/> 
                                        @error('image')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                        @if ($image)
                                        <img src="{{$image->temporaryUrl()}}"width="120"/>
                                        @endif
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="is_popular" class="form-label"> Danh mục trending</label>
                                        <select class="form-control"name="is_popular"wire:model="is_popular" >
                                                <option value="0">no</option>
                                                <option value="1">yes</option>
                                        </select>
                                        @error('is_popular')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="category_id" class="form-label">Danh mục cha</label>
                                        <select class="form-control"name="category_id"wire:model="category_id" >
                                                <option value="">không có</option>
                                                @foreach ($categories as $item)
                                                <option value="{{$item->id}}">{{$item->ten}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end"> Thêm</button>
                                </form>
                                 
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>