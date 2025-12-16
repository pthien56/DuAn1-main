# Hướng Dẫn Tích Hợp VNPay

## Đã Tích Hợp

Hệ thống đã được tích hợp phương thức thanh toán VNPay với các tính năng:

### 1. Các File Đã Cập Nhật

- **vnpay_php/config.php**: Cấu hình VNPay với URL return động
- **controllers/CartController.php**: Thêm các phương thức:
  - `vnpayPayment()`: Tạo URL thanh toán VNPay
  - `vnpayReturn()`: Xử lý callback từ VNPay
- **views/cart/checkout.php**: Thêm tùy chọn thanh toán VNPay

### 2. Luồng Thanh Toán VNPay

1. Khách hàng chọn phương thức thanh toán "VNPay" tại trang checkout
2. Hệ thống tạo đơn hàng với trạng thái "Chờ xác nhận" (order_status_id = 1)
3. Chuyển hướng khách hàng đến cổng thanh toán VNPay
4. Sau khi thanh toán:
   - **Thành công**: Cập nhật trạng thái đơn hàng thành "Đã xác nhận" (order_status_id = 2)
   - **Thất bại**: Giữ nguyên đơn hàng, khách hàng có thể thử lại

### 3. Cấu Hình VNPay

File `vnpay_php/config.php` chứa thông tin:

```php
$vnp_TmnCode = "AEUBZIFC"; // Mã merchant (sandbox)
$vnp_HashSecret = "LVFN1DUEQNOZYGDK2BFVG8TB84FRG00A"; // Secret key (sandbox)
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = BASE_URL . "cart/vnpayReturn"; // URL callback
```

### 4. Test Thanh Toán (Sandbox)

VNPay Sandbox cung cấp thông tin test:

**Thẻ ATM nội địa:**
- Ngân hàng: NCB
- Số thẻ: 9704198526191432198
- Tên chủ thẻ: NGUYEN VAN A
- Ngày phát hành: 07/15
- Mật khẩu OTP: 123456

**Thẻ quốc tế:**
- Số thẻ: 4111111111111111
- Tên chủ thẻ: NGUYEN VAN A
- Ngày hết hạn: 12/25
- CVV: 123

### 5. Chuyển Sang Production

Khi triển khai thực tế, cần:

1. Đăng ký tài khoản VNPay merchant tại: https://vnpay.vn
2. Lấy thông tin:
   - `vnp_TmnCode`: Mã merchant thực
   - `vnp_HashSecret`: Secret key thực
3. Cập nhật trong `vnpay_php/config.php`:
   ```php
   $vnp_TmnCode = "MÃ_MERCHANT_THỰC";
   $vnp_HashSecret = "SECRET_KEY_THỰC";
   $vnp_Url = "https://vnpayment.vn/paymentv2/vpcpay.html"; // URL production
   ```
4. Đảm bảo URL return được cấu hình đúng trong tài khoản VNPay

### 6. Trạng Thái Đơn Hàng

- **1**: Chờ xác nhận (đơn hàng mới tạo)
- **2**: Đã xác nhận (thanh toán VNPay thành công)
- **10**: Chờ thanh toán (nếu cần)

### 7. Bảo Mật

- Secret key được sử dụng để tạo chữ ký HMAC SHA512
- Mọi callback từ VNPay đều được xác thực chữ ký
- Không lưu trữ thông tin thẻ của khách hàng

## Kiểm Tra

1. Truy cập trang checkout: `http://localhost/DuAn1/cart/checkout`
2. Chọn phương thức thanh toán "VNPay"
3. Điền thông tin và nhấn "Xác Nhận Đặt Hàng"
4. Sẽ được chuyển đến trang thanh toán VNPay sandbox
5. Sử dụng thông tin test ở trên để thanh toán
6. Sau khi thanh toán, sẽ được chuyển về trang thành công

## Lưu Ý

- Đảm bảo BASE_URL được cấu hình đúng trong `config/config.php`
- URL return phải accessible từ internet khi deploy production
- Kiểm tra log lỗi nếu có vấn đề với callback
