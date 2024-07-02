<!-- resources/views/emails/verify.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: rgb(179, 180, 182);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
        }
        h2 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #f15a0f;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 16px;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            
        </div>
        <h2>Xác Thực Địa Chỉ Email</h2>
        <p>Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác thực địa chỉ email của bạn bằng cách nhấp vào nút bên dưới:</p>
        <a href="{{ $verificationUrl }}" class="btn">Xác Thực Email</a>
        <p>Nếu bạn không tạo tài khoản, vui lòng bỏ qua email này.</p>
        <footer>
            Cảm ơn,<br>
            {{ config('app.name') }}
        </footer>
    </div>
</body>
</html>
