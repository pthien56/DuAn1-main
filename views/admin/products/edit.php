<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<h2 class="mb-4">Sửa Sản Phẩm</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Thông Tin Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>admin/productEdit/<?= $product['product_id'] ?>">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Tên Sản Phẩm *</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" 
                               value="<?= htmlspecialchars($product['product_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Thương Hiệu *</label>
                        <input type="text" class="form-control" id="brand" name="brand" 
                               value="<?= htmlspecialchars($product['brand']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh Mục</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>" 
                                    <?= $category['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['category_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Nhà Cung Cấp</label>
                        <input type="number" class="form-control" id="supplier_id" name="supplier_id" 
                               value="<?= $product['supplier_id'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="<?= BASE_URL ?>admin/products" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Ảnh Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <?php 
                    $imgPath = __DIR__ . '/../../../public/data/' . rawurlencode($product['product_name']) . '.jpg';
                    $imgUrl = BASE_URL . "public/data/" . rawurlencode($product['product_name']) . ".jpg";
                    $imgExists = file_exists($imgPath);
                ?>
                <div class="text-center mb-3">
                    <?php if ($imgExists): ?>
                        <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" 
                             class="img-fluid border rounded" style="max-height: 300px;">
                    <?php else: ?>
                        <div class="border rounded p-5 bg-light">
                            <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Chưa có ảnh sản phẩm</p>
                        </div>
                    <?php endif; ?>
                </div>
                <form method="POST" action="<?= BASE_URL ?>admin/productUploadImage/<?= $product['product_id'] ?>" 
                      enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Upload Ảnh Mới</label>
                        <input type="file" class="form-control" id="product_image" name="product_image" 
                               accept="image/jpeg,image/jpg,image/png" required>
                        <small class="text-muted">
                            Tên file sẽ tự động là: <code><?= htmlspecialchars($product['product_name']) ?>.jpg</code>
                        </small>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i> Upload Ảnh
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Biến Thể Sản Phẩm</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                    <i class="bi bi-plus-circle"></i> Thêm Biến Thể
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên Biến Thể</th>
                            <th>Màu</th>
                            <th>Bộ Nhớ</th>
                            <th>Giá</th>
                            <th>Tồn Kho</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($variants)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Chưa có biến thể nào</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($variants as $variant): ?>
                            <tr>
                                <td><?= htmlspecialchars($variant['variant_name']) ?></td>
                                <td><?= htmlspecialchars($variant['color']) ?></td>
                                <td><?= htmlspecialchars($variant['storage']) ?></td>
                                <td><?= number_format($variant['price'], 0, ',', '.') ?> đ</td>
                                <td><?= $variant['stock_quantity'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="editVariant(<?= htmlspecialchars(json_encode($variant)) ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="<?= BASE_URL ?>admin/variantDelete/<?= $variant['variant_id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn có chắc muốn xóa biến thể này?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add/Edit Variant -->
<div class="modal fade" id="addVariantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="variantModalTitle">Thêm Biến Thể</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="variantForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="variant_id" name="variant_id">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <div class="mb-3">
                        <label for="variant_name" class="form-label">Tên Biến Thể *</label>
                        <input type="text" class="form-control" id="variant_name" name="variant_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Màu</label>
                        <input type="text" class="form-control" id="color" name="color">
                    </div>
                    <div class="mb-3">
                        <label for="storage" class="form-label">Bộ Nhớ</label>
                        <input type="text" class="form-control" id="storage" name="storage">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá *</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock_quantity" class="form-label">Số Lượng Tồn Kho *</label>
                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="warranty_months" class="form-label">Bảo Hành (tháng)</label>
                        <input type="number" class="form-control" id="warranty_months" name="warranty_months" value="12">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editVariant(variant) {
    document.getElementById('variantModalTitle').textContent = 'Sửa Biến Thể';
    document.getElementById('variant_id').value = variant.variant_id;
    document.getElementById('variant_name').value = variant.variant_name;
    document.getElementById('color').value = variant.color;
    document.getElementById('storage').value = variant.storage;
    document.getElementById('price').value = variant.price;
    document.getElementById('stock_quantity').value = variant.stock_quantity;
    document.getElementById('warranty_months').value = variant.warranty_months;
    document.getElementById('variantForm').action = '<?= BASE_URL ?>admin/variantEdit/' + variant.variant_id;
    
    var modal = new bootstrap.Modal(document.getElementById('addVariantModal'));
    modal.show();
}

document.getElementById('addVariantModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('variantModalTitle').textContent = 'Thêm Biến Thể';
    document.getElementById('variantForm').reset();
    document.getElementById('variantForm').action = '<?= BASE_URL ?>admin/variantCreate';
});
</script>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

