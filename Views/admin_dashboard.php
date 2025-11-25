<?php 
$title = 'Dashboard - Quản trị';
$admin = true;
require_once __DIR__ . '/header.php'; 
?>

<main>
    <div class="container">
        <h1>Dashboard - Quản trị hệ thống</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Tổng sản phẩm</h3>
                <p class="stat-number"><?php echo $stats['total_products']; ?></p>
            </div>
            <div class="stat-card">
                <h3>Tổng đơn hàng</h3>
                <p class="stat-number"><?php echo $stats['total_orders']; ?></p>
            </div>
            <div class="stat-card">
                <h3>Doanh thu</h3>
                <p class="stat-number"><?php echo formatCurrency($stats['total_revenue']); ?></p>
            </div>
            <div class="stat-card">
                <h3>Tổng khách hàng</h3>
                <p class="stat-number"><?php echo $stats['total_customers']; ?></p>
            </div>
        </div>
        
        <div class="dashboard-sections">
            <div class="dashboard-section">
                <h2>Đơn hàng gần đây</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['order_id']; ?></td>
                                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                <td><?php echo formatDateTime($order['order_date']); ?></td>
                                <td><?php echo formatCurrency($order['total_amount']); ?></td>
                                <td><?php echo htmlspecialchars($order['status_name']); ?></td>
                                <td>
                                    <a href="<?php echo baseUrl('admin/order-detail.php?id=' . $order['order_id']); ?>" class="btn btn-primary btn-small">Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="dashboard-section">
                <h2>Sản phẩm sắp hết hàng</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Phiên bản</th>
                            <th>Tồn kho</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lowStock as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['variant_name']); ?></td>
                                <td class="<?php echo $product['stock_quantity'] < 5 ? 'text-danger' : ''; ?>">
                                    <?php echo $product['stock_quantity']; ?>
                                </td>
                                <td>
                                    <a href="<?php echo baseUrl('admin/products.php?edit=' . $product['variant_id']); ?>" class="btn btn-primary btn-small">Sửa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="admin-menu">
            <h2>Quản lý</h2>
            <div class="admin-menu-grid">
                <a href="<?php echo baseUrl('admin/products.php'); ?>" class="admin-menu-item">
                    <h3>Quản lý sản phẩm</h3>
                    <p>Thêm, sửa, xóa sản phẩm</p>
                </a>
                <a href="<?php echo baseUrl('admin/orders.php'); ?>" class="admin-menu-item">
                    <h3>Quản lý đơn hàng</h3>
                    <p>Xem và cập nhật đơn hàng</p>
                </a>
                <a href="<?php echo baseUrl('admin/customers.php'); ?>" class="admin-menu-item">
                    <h3>Quản lý khách hàng</h3>
                    <p>Xem thông tin khách hàng</p>
                </a>
                <a href="<?php echo baseUrl('admin/inventory.php'); ?>" class="admin-menu-item">
                    <h3>Quản lý kho</h3>
                    <p>Nhập kho, xuất kho</p>
                </a>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

