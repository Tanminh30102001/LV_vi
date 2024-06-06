<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }
        h1, h2, h3 {
            color: #333;
        }
        p {
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f8f8f8;
        }
        .header, .footer {
            text-align: center;
            margin: 20px 0;
        }
        .contact-info {
            font-weight: bold;
            color: #333;
        }
        .total {
            font-weight: bold;
            color: #333;
        }
        .discount-code {
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px dashed #ccc;
            display: inline-block;
            margin: 10px 0;
            font-weight: bold;
            color: #333;
        }
        .cta {
            background-color: #F15412;;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
        }
        .cta:hover {
            background-color: #f3c6b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Xin chào {{ Auth::user()->name }},</h1>
            <h2>Cảm ơn bạn đã đặt hàng từ chúng tôi!</h2>
        </div>
        <p>Đơn hàng của bạn đã được đặt thành công. Chúng tôi rất vui khi có bạn là khách hàng và hy vọng bạn sẽ hài lòng với sản phẩm đã mua. Dưới đây là chi tiết đơn hàng của bạn:</p>
        
        <h2>Chi tiết đơn hàng</h2>
        <p>Mã đơn hàng: <strong>{{ $order->ma_don_hang }}</strong></p>
        <p>Tổng tiền: <strong>đ{{ number_format($order->tong_tien, 0, ',', '.') }}</strong></p>    

        @if($order->giam_gia > 0)
            <h2>Áp dụng giảm giá!</h2>
            <p>Bạn đã nhận được giảm giá: <strong>đ{{ number_format($order->giam_gia, 0, ',', '.') }}</strong></p>
            <p>Tổng tiền sau khi giảm giá: <strong>đ{{ number_format($order->tong_tien - $order->giam_gia, 0, ',', '.') }}</strong></p>
        @endif

        <h3>Sản phẩm đã đặt</h3>
        <table>
            <thead>
                <tr> 
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Cart::instance('cart')->content() as $item)
                    <tr>
                        <td>{{ $item->model->ten }}</td>
                        <td>đ{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>đ{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($order->giam_gia > 0)
            <h2>Áp dụng giảm giá!</h2>
            <p>Bạn đã nhận được giảm giá: <strong>đ{{ number_format($order->giam_gia, 0, ',', '.') }}</strong></p>
            <p>Tổng tiền sau khi giảm giá: <strong>đ{{ number_format($order->tong_tien - $order->giam_gia, 0, ',', '.') }}</strong></p>
        @endif
        {{-- <h2>Ưu đãi đặc biệt dành cho bạn!</h2>
        <p>Để thể hiện lòng biết ơn, chúng tôi muốn tặng bạn một mã giảm giá đặc biệt cho lần mua hàng tiếp theo. Sử dụng mã dưới đây để được giảm 10%:</p>
        <div class="discount-code">SAVE10</div> --}}
        {{-- <p>Mã này có hiệu lực trong 30 ngày, vì vậy hãy sử dụng sớm!</p> --}}

        <h2>Kết nối với chúng tôi</h2>
        <p>Theo dõi chúng tôi trên mạng xã hội để cập nhật những sản phẩm và ưu đãi mới nhất:</p>
        <p>
            <a href="https://www.facebook.com/profile.php?id=100008312461347" target="_blank">Facebook</a> |
            <a href="https://www.instagram.com/_minh.tnt/" target="_blank">Instagram</a> 
            {{-- <a href="https://www.twitter.com/yourcompany" target="_blank">Twitter</a> --}}
        </p>

        <a href="{{ route('shop') }}" class="cta">Mua thêm</a>

        <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua số <span class="contact-info">0338386701</span> </p>
        <p>Chân thành cảm ơn và chúc bạn một ngày tốt lành!</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Trịnh Ngô Tân Minh - DH51904003. Đã đăng ký bản quyền.</p>
        </div>
    </div>
</body>
</html>
