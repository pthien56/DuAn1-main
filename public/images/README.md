# Hướng Dẫn Thêm Ảnh Cho Website

## Thư Mục Ảnh

### 1. Banner (public/images/)
Thêm các file banner cho carousel trang chủ:
- `banner1.jpg` - Banner chính (khuyến mãi)
- `banner2.jpg` - Banner phụ
- `banner3.jpg` - Banner phụ

**Kích thước đề xuất:** 1200x400px hoặc tỷ lệ 3:1

### 2. Ảnh Sản Phẩm (public/data/)
Ảnh sản phẩm sẽ được tự động lưu tại đây khi admin upload.

**Quy tắc đặt tên:** `[Tên Sản Phẩm].jpg`
- Ví dụ: `iPhone 15 Pro Max.jpg`
- Tên file phải khớp chính xác với tên sản phẩm trong database

**Kích thước đề xuất:** 500x500px hoặc tỷ lệ 1:1

## Cách Thêm Ảnh

### Cách 1: Upload qua Admin Panel (Khuyến nghị)
1. Đăng nhập vào Admin Panel
2. Vào "Quản Lý Sản Phẩm" > Chọn sản phẩm cần thêm ảnh
3. Click "Sửa" sản phẩm
4. Scroll xuống phần "Ảnh Sản Phẩm"
5. Chọn file ảnh và click "Upload Ảnh"

### Cách 2: Upload thủ công
1. Đặt ảnh vào thư mục `public/data/`
2. Đặt tên file đúng với tên sản phẩm (ví dụ: `iPhone 15 Pro Max.jpg`)
3. Đảm bảo file có định dạng JPG, JPEG hoặc PNG

## Lưu Ý

- Ảnh sẽ tự động được resize nếu cần
- Hệ thống hỗ trợ JPG, JPEG, PNG
- Nếu không có ảnh, hệ thống sẽ hiển thị placeholder
- Tên file không phân biệt hoa thường nhưng nên giữ đúng định dạng

## Tạo Ảnh Placeholder

Nếu bạn muốn tạo ảnh placeholder nhanh, có thể sử dụng:
- https://placehold.co/500x500?text=Product+Name
- https://via.placeholder.com/500x500

Hoặc sử dụng các công cụ chỉnh sửa ảnh như Photoshop, GIMP, Canva...

