@component('mail::message')
# Xác Thực Địa Chỉ Email

Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác thực địa chỉ email của bạn bằng cách nhấp vào nút bên dưới.

@component('mail::button', ['url' => $url])
Xác Thực Email
@endcomponent

Nếu bạn không tạo tài khoản, vui lòng bỏ qua email này.

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent