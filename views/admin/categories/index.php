<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-4">Quản Lý Danh Mục</h2>
    <span class="badge bg-primary fs-6">
        Tổng: <?= count($categories) ?> danh mục
    </span>
</div>
<div class="mb-3">
    <a href="<?= BASE_URL ?>admin/categoryCreate" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Thêm Danh Mục Mới
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Danh Mục</th>
                <th>Mô Tả</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
            <tr>
                <td colspan="4" class="text-center">Chưa có danh mục nào</td>
            </tr>
            <?php else: ?>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['category_id'] ?></td>
                    <td><strong><?= htmlspecialchars($category['category_name']) ?></strong></td>
                    <td><?= htmlspecialchars($category['description'] ?? '') ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>admin/categoryEdit/<?= $category['category_id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <a href="<?= BASE_URL ?>admin/categoryDelete/<?= $category['category_id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn có chắc muốn xóa danh mục này? Lưu ý: Không thể xóa nếu đang có sản phẩm sử dụng.')">
                            <i class="bi bi-trash"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

