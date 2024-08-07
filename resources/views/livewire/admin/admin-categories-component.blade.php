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
                    <span></span> Quản lý Danh mục
                  
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
           
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert"> {{ Session::get('error') }}</div>
                    @endif
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">Tất cả danh mục</div>
                                <div class="col-md-4"><input type="text"  class="form-control" placeholder="Input name,price,quanity to search..."wire:model="searchTerm"/></div>
                                
                                <div class="col-md-4">
                                    <a href="{{route('admin.add.categories')}}" class="btn btn-succsess float-end">Thêm mới danh mục  </a>
                                </div>
                            </div>
                        </div>
                            <div class="card-body">
                                @if(Session::has('message') )
                                <div id="danger-alert" class="alert alert-danger " role="alert"> {{Session::get('message')}}</div>

                                @endif
                                <table class="table table-striped">
                                    <thead> 
                                        <tr>
                                            <th> #</th>
                                            <th>Image</th>
                                            <th> Tên</th>
                                            <th> Slug</th>
                                            <th>Danh mục con</th>
                                            <th>Trending</th>
                                            <th> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=($categories->currentPage()-1)*$categories->perPage();   
                                        @endphp
                                        @foreach ($categories as $item)
                                            <tr>
                                                {{-- <td> {{$item->id}}</td> --}}
                                                <td>{{++$i}}.</td>
                                                <td><img src="{{asset('assets/imgs/category')}}/{{$item->image}}" width='80px' height='70px'/></td>
                                                <td> {{$item->ten}}</td>
                                                <td> {{$item->slug}}</td>
                                                <td>
                                                    <ul>
                                                        @foreach($item->subCategories as $scategory)
                                                        <li> {{$scategory->ten}} <a href="{{route('admin.edit.category',['category_id'=>$item->id,'scategory_id'=>$scategory->id])}}">sửa</a>
                                                            <a href="#" onclick="deleteSubCate({{$scategory->id}})"  class="text-danger  ">xóa </a></li>
                                                        @endforeach
                                                        
                                                    </ul>
                                                </td>
                                                <td>{{$item->is_popular == 1 ?'CÓ':'KHÔNG'}}</td>
                                                <td><a href="{{route('admin.edit.category',['category_id'=>$item->id])}}" class="text-success ">sửa </a>
                                                    <a href="#" onclick="deleteConfirmation({{$item->id}})"  class="text-danger  ">xóa </a>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$categories->links()}}
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
                    <div class="col-md-12 text-center" >
                        <h4 class="pb-3">Do you want Delete</h4>
                        <button type="button" class="btn btn-secondary" data-bs-modal="modal" data-bs-modal="#deleteConfirmation">Cancel</button>
                        <button type="button" class="btn btn-danger"onclick="deleteCategory()" >delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="deleteSubCate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pb-30 pt-30">
                <div class="row">
                    <div class="col-md-12 text-center" >
                        <h4 class="pb-3">Do you want Delete this subcategory</h4>
                        <button type="button" class="btn btn-secondary" data-bs-modal="modal" data-bs-modal="#deleteConfirmation">Cancel</button>
                        <button type="button" class="btn btn-danger"onclick="deleteSubCategory()" >delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    
    function deleteConfirmation(id){
        @this.set('category_id',id);
        $('#deleteConfirmation').modal('show');

    }
    function deleteCategory(){
        @this.call('deleteCategory');
        $('#deleteConfirmation').modal('hide');
    }
    function deleteSubCate(id){
        @this.set('subcategory_id',id);
        $('#deleteSubCate').modal('show');
    }
    function deleteSubCategory(){
        @this.call('deleteSubCategory');
        $('#deleteConfirmation').modal('hide');
    }
</script>


@endpush