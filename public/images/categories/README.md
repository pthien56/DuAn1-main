# Ảnh Danh Mục Sản Phẩm

## Quy Tắc Đặt Tên

Ảnh danh mục phải được đặt tên theo quy tắc sau:
- Tên file = Tên danh mục (chữ thường, thay khoảng trắng bằng dấu gạch dưới) + `.jpg`
- Ví dụ: 
  - Danh mục "Điện thoại thông minh" → `điện_thoại_thông_minh.jpg`
  - Danh mục "Phụ kiện" → `phụ_kiện.jpg`
  - Danh mục "Tai nghe" → `tai_nghe.jpg`

## Kích Thước Đề Xuất

- **Kích thước:** 300x300px hoặc tỷ lệ 1:1
- **Định dạng:** JPG, JPEG
- **Chất lượng:** Tối ưu cho web (khoảng 80-90%)

## Các Danh Mục Mặc Định

Dựa trên database, các danh mục cần ảnh:

1. `điện_thoại_thông_minh.jpg` - Điện thoại thông minh
2. `phụ_kiện.jpg` - Phụ kiện
3. `đồng_hồ_thông_minh.jpg` - Đồng hồ thông minh
4. `tablet.jpg` - Tablet
5. `laptop.jpg` - Laptop
6. `tai_nghe.jpg` - Tai nghe
7. `sạc_và_cáp.jpg` - Sạc và cáp
8. `pin_dự_phòng.jpg` - Pin dự phòng
9. `ốp_lưng.jpg` - Ốp lưng
10. `camera_và_phụ_kiện.jpg` - Camera và phụ kiện

## Cách Thêm Ảnh

1. Chuẩn bị ảnh với kích thước phù hợp
2. Đặt tên file theo quy tắc trên
3. Copy ảnh vào thư mục `public/images/categories/`
4. Refresh trang web để xem kết quả

## Lưu Ý

- Nếu không có ảnh, hệ thống sẽ hiển thị icon mặc định
- Tên file phải khớp chính xác với tên danh mục (không phân biệt hoa thường)
- Hệ thống tự động fallback về icon nếu ảnh không tồn tại

