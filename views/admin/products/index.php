<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-4">Quản Lý Sản Phẩm</h2>
    <span class="badge bg-primary fs-6">
        Tổng: <?= count($products) ?> sản phẩm
    </span>
</div>

<div class="mb-3">
    <a href="<?= BASE_URL ?>admin/productCreate" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Sản Phẩm Mới
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sản Phẩm</th>
                <th>Thương Hiệu</th>
                <th>Danh Mục</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
            <tr>
                <td colspan="5" class="text-center">Chưa có sản phẩm nào</td>
            </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_id'] ?></td>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= htmlspecialchars($product['brand']) ?></td>
                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>admin/productEdit/<?= $product['product_id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Sửa
                        </a>
                        <a href="<?= BASE_URL ?>admin/productDelete/<?= $product['product_id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
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

