<div>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Quản lý thư của người dùng
                  
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">Tất cả thư của người dùng gửi </div>
                                <div class="col-md-6">
                                    {{-- <a href="{{route('admin.add.categories')}}" class="btn btn-succsess float-end">Add new categories </a> --}}
                                </div>
                            </div>
                        </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead> 
                                        <tr>
                                            <th> #</th>
                                            <th> Tên</th>
                                            <th> email</th>
                                            <th>Sđt</th>
                                            <th>Chủ đề </th>
                                            <th>Nội dung</th>
                                            <th> Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=($contacts->currentPage()-1)*$contacts->perPage();   
                                        @endphp
                                        @foreach ($contacts as $item)
                                            <tr>
                                                {{-- <td> {{$item->id}}</td> --}}
                                                <td>{{++$i}}.</td>
                                                <td>{{$item->ten}}</td>
                                                <td> {{$item->email}}</td>
                                                <td> {{$item->sdt}}</td>
                                                <td>{{$item->chu_de}}</td>
                                                <td>{{$item->noi_dung}}</td>
                                                <td>{{$item->created_at}}</td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$contacts->links()}}
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</div>
