<div>
     <div class="container">
        <div class="row">
            
            @if(Session::has('message'))
           
             @endif
             <div class="col-3"></div>
            <div class="col-lg-6 mt-2 mb-2 text-center">
                <h5>Cập nhập tài khoản</h5>
                <form  wire:submit.prevent="updateUser">
                    <div class="row">
                        <div class=" form-group col-md-12 text-center">
                            <!-- Profile picture image-->
                            @if($newimage)
                            <img class="img-account-profile rounded-circle mb-2 center" src="{{$newimage->temporaryUrl()}}" alt="" height="100" width="100">
                            @else
                            <img class="img-account-profile rounded-circle mb-2 center" src="{{asset('assets/imgs/user')}}/{{$image}}" alt=""height="100" width="100">
                            @endif
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <!-- Profile picture upload button-->
                            <input type="file" name="image" class="form-control" wire:model="newimage"/>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Họ và tên <span class="required">*</span></label>
                            <input  class="form-control square" name="name"  wire:model="name" />
                            @error('name') <p class="text-danger">{{$message}} </p> @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="phone" class="form-label">Số điện thoại <span class="required">*</span></label>
                            <input   class="form-control square" name="phone" wire:model="phone" />
                            @error('phone')  <p class="text-danger">{{$message}} </p> @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address" class="form-label">Địa chỉ <span class="required">*</span></label>
                            <input class="form-control square" name="address" wire:model="address" />
                            @error('address')  <p class="text-danger">{{$message}} </p> @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Mật khẩu mới</label>
                            <input  class="form-control square" name="password"  wire:model="password" type="password" />
                            @error('name') <p class="text-danger">{{$message}} </p> @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Nhập lại mật khẩu</label>
                            <input  class="form-control square" name="nPassword"  wire:model="nPassword" type="password" />
                            @error('name') <p class="text-danger">{{$message}} </p> @enderror
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-fill-out submit"             
                            
                            onclick="showCustomToast()"
                           >Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>  
    </div> 
  
</div>
@push('scripts')
 <script>
        function showCustomToast() {
            Toastify({
                text: 'Update thành công',
                duration: 3000, // Thời gian hiển thị thông báo (4 giây)
                close: true, // Cho phép người dùng đóng thông báo
                gravity: "top", // Vị trí hiển thị (bottom, top, left, right)
                position: "right", // Vị trí cụ thể (left, center, right)
                className: "custom-toast",
                theme: "colored",
            }).showToast();
        }
</script>
@endpush



