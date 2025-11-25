<?php 
$title = 'Quản lý sản phẩm - Quản trị';
$admin = true;
require_once __DIR__ . '/header.php'; 
?>

<main>
    <div class="container">
        <div class="admin-header">
            <h1>Quản lý sản phẩm</h1>
            <a href="<?php echo baseUrl('admin/product-add.php'); ?>" class="btn btn-primary">Thêm sản phẩm mới</a>
        </div>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Phiên bản</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['variant_id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($product['product_name']); ?></strong><br>
                            <small><?php echo htmlspecialchars($product['brand']); ?> - <?php echo htmlspecialchars($product['category_name'] ?? ''); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($product['variant_name']); ?></td>
                        <td><?php echo formatCurrency($product['price']); ?></td>
                        <td class="<?php echo $product['stock_quantity'] < 10 ? 'text-danger' : ''; ?>">
                            <?php echo $product['stock_quantity']; ?>
                        </td>
                        <td>
                            <a href="<?php echo baseUrl('admin/product-edit.php?id=' . $product['variant_id']); ?>" class="btn btn-primary btn-small">Sửa</a>
                            <a href="<?php echo baseUrl('admin/products.php?delete=' . $product['variant_id']); ?>" 
                               class="btn btn-danger btn-small" 
                               onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="<?php echo baseUrl('admin/dashboard.php'); ?>" class="btn btn-secondary">Quay lại Dashboard</a>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

