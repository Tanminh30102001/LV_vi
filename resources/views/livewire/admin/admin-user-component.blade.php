<div>
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
                <span></span> All User
              
            </div>
        </div>
    </div>
    <div class="container">
        
        <div class=" mt-3">
            <table class="table table-striped">
                <thead> 
                    <tr>
                        {{-- <th> </th> --}}
                        <th> user ID</th>
                        <th> Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Total Renuve</th>
                        <th>quantity  orderd</th>
                        <th>quantity canceled </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i=($users->currentPage()-1)*$users->perPage();   
                    @endphp
                    @foreach ($users as $item)
                        <tr>
                            {{-- <td> {{$item->id}}</td> --}}
                            {{-- <td>{{++$i}}.</td> --}}
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td> {{$item->address}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{App\Models\Order::where('user_id',$item->id)->sum('tong_tien')}}</td>
                            <td>{{App\Models\Order::where('user_id',$item->id)->where('tinh_trang_giao_hang','delivered')->count()}}</td>
                            <td>{{App\Models\Order::where('user_id',$item->id)->where('tinh_trang_giao_hang','canceled')->count()}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
    
</div>
