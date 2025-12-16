<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<h2 class="mb-4">Sửa Danh Mục</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>admin/categoryEdit/<?= $category['category_id'] ?>">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category_name" name="category_name" 
                               value="<?= htmlspecialchars($category['category_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="<?= BASE_URL ?>admin/categories" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Ảnh Danh Mục</h5>
            </div>
            <div class="card-body">
                <?php 
                    $categoryImageName = str_replace(' ', '_', strtolower($category['category_name']));
                    $imgPath = __DIR__ . '/../../../public/images/categories/' . $categoryImageName . '.jpg';
                    $imgUrl = BASE_URL . "public/images/categories/" . $categoryImageName . ".jpg";
                    $imgExists = file_exists($imgPath);
                ?>
                <div class="text-center mb-3">
                    <?php if ($imgExists): ?>
                        <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($category['category_name']) ?>" 
                             class="img-fluid border rounded shadow-sm" style="max-height: 300px; max-width: 300px; object-fit: cover;">
                        <p class="text-muted small mt-2">Ảnh hiện tại</p>
                    <?php else: ?>
                        <div class="border rounded p-5 bg-light d-inline-block">
                            <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
                            <p class="text-muted mt-2 mb-0">Chưa có ảnh danh mục</p>
                        </div>
                    <?php endif; ?>
                </div>
                <form method="POST" action="<?= BASE_URL ?>admin/categoryUploadImage/<?= $category['category_id'] ?>" 
                      enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="category_image" class="form-label">Upload Ảnh Mới</label>
                        <input type="file" class="form-control" id="category_image" name="category_image" 
                               accept="image/jpeg,image/jpg,image/png" required>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle me-1"></i>
                            Tên file sẽ tự động là: <code><?= htmlspecialchars($categoryImageName) ?>.jpg</code><br>
                            <i class="bi bi-info-circle me-1"></i>
                            Kích thước đề xuất: 300x300px (tỷ lệ 1:1)
                        </small>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i> Upload Ảnh
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

