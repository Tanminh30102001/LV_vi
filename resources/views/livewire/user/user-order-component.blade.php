<div>
<style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block;
        }
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;900&display=swap');

</style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow">Home</a>
                    <span></span> Đơn hàng của tôi
                  
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">Tất cả đơn hàng </div>
                               
                            </div>
                        </div>
                            <div class="row">
                                @if(Session::has('message') )
                                <div class="alert alert-success" role="alert"> {{Session::get('message')}}</div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Ngày đặt</th>
                                                <th>Trạng thái đơn hàng</th>
                                                <th>Tình trạng giao hàng </th>
                                                <th>Tổng tiền </th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $item)
                                            <tr>
                                                <td>{{$item->ma_don_hang}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>@if($item->trang_thai == 0)
                                                    Chưa thanh toán
                                                @elseif($item->trang_thai == 1)
                                                    Đã thanh toán
                                                @endif</td>
                                                <td>{{$item->translateTinhTrangGiaoHang($item->tinh_trang_giao_hang)}}</td>
                                                <td>{{$item->tong_tien}}  đ</td>
                                                <td><a href="{{route('user.orderdetails',['order_id'=>$item->id])}}">View</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{$orders->links()}}
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
</div>



