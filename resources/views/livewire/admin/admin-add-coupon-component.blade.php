<div>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span>Thêm mới phiếu giảm giá 
                  
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">Thêm mới phiếu giảm giá </div>
                                <div class="col-md-6">
                                    <a href="{{route('admin.coupons')}}" class="btn btn-succsess float-end"> Quản lý Phiếu giảm giá  </a>
                                </div>
                            </div>
                        </div>
                            <div class="card-body">
                                @if(Session::has('message'))
                                <div class="alert alert-success" role="alert"> {{Session::get('message')}}</div>
                                @endif
                                <form wire:submit.prevent="storeCoupon()"> 
                                    <div class="mb-3 mt-3">
                                        <label for="code" class="form-label">Mã phiếu</label>
                                        <input type="text" name="code" class="form-control" placeholder="Nhập mã phiếu" wire:model="code" /> 
                                        @error('code')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="type" class="form-label"> Loại phiếu</label>
                                        <select class="form-control"name="type"wire:model="type">Chọn loại
                                            <option >Chọn loại phiếu </option>
                                            <option value="fixed">Cố định</option> 
                                            <option value="percent">Phàn trăm</option>    
                                        </select> 
                                        @error('type')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="value" class="form-label">Giá trị phiéu</label>
                                        <input type="text" name="value" class="form-control" placeholder=" Nhập Giá trị phiếu" wire:model="value"  >
                                        @error('value')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="cart_value" class="form-label">Giá trị tối thiểu của giỏ hàng </label>
                                        <input type="text" name="cart_value" class="form-control" placeholder="Nhập giá trị giỏ hàng" wire:model="cart_value" /> 
                                        @error('cart_value')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="expiry_date" class="form-label" wire:ignore> Ngày hết hạn</label>
                                        <input type="date" name="expiry_date" id="expiry_date" class="form-control"wire:model="expiry_date" /> 
                                        @error('expiry_date')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="desc" class="form-label">Mô tả</label>
                                        <textarea name="desc"  placeholder="Nhập mô tả" class="form-control" wire:model="desc" ></textarea>
                                        @error('desc')
                                        <p class="text-danger">{{$message}} </p>
                                        @enderror
                                    </div>
                                 
                                    <button type="submit" class="btn btn-primary float-end"> submit</button>
                                </form>
                                 
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

@push('scripts')
<script>

    $(function(){
        $('#expiry_date').datetimepicker({
            format:'Y-MM-DD'
        }).on('dp.change',function(ev){
            var data=$('#expiry_date').val();
            @this.set('expiry_date',data);
        })
    })
</script>

@endpush