<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<h2 class="mb-4">Thêm Sản Phẩm Mới</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>admin/productCreate">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Tên Sản Phẩm *</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Thương Hiệu *</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh Mục</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Nhà Cung Cấp</label>
                        <input type="number" class="form-control" id="supplier_id" name="supplier_id">
                    </div>
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Ảnh Sản Phẩm</label>
                        <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                        <small class="text-muted">Tên file ảnh sẽ tự động lấy từ tên sản phẩm (ví dụ: iPhone 15 Pro Max.jpg)</small>
                        <div class="mt-2">
                            <small class="text-info">
                                <i class="bi bi-info-circle"></i> 
                                Sau khi tạo sản phẩm, bạn có thể upload ảnh tại trang chỉnh sửa. 
                                Ảnh sẽ được lưu tại: <code>public/data/[Tên Sản Phẩm].jpg</code>
                            </small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo Sản Phẩm</button>
                    <a href="<?= BASE_URL ?>admin/products" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

