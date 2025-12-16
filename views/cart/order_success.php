<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container my-5">
<div class="text-center mb-5">
    <div class="mb-4">
        <div class="d-inline-block p-4 rounded-circle bg-success bg-opacity-10">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 80px;"></i>
        </div>
    </div>
    <h2 class="mt-3 fw-bold text-success">Đặt Hàng Thành Công!</h2>
    <p class="lead text-muted">Cảm ơn bạn đã mua sắm tại <strong><?= SITE_NAME ?></strong></p>
    <p class="text-muted">Mã đơn hàng của bạn: <strong class="text-primary">#<?= $order['order_id'] ?></strong></p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>Thông Tin Đơn Hàng</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Mã Đơn Hàng:</strong> #<?= $order['order_id'] ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Ngày Đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Khách Hàng:</strong> <?= htmlspecialchars($order['customer_name']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Điện Thoại:</strong> <?= htmlspecialchars($order['phone_number']) ?>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Địa Chỉ:</strong> <?= htmlspecialchars($order['address']) ?>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Trạng Thái:</strong> 
                        <span class="badge bg-info"><?= htmlspecialchars($order['status_name']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Phương Thức Thanh Toán:</strong> <?= htmlspecialchars($order['payment_method']) ?>
                    </div>
                </div>
                
                <hr>
                
                <h5>Chi Tiết Đơn Hàng</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Giá</th>
                            <th>Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $detail): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($detail['product_name']) ?><br>
                                <small class="text-muted"><?= htmlspecialchars($detail['variant_name']) ?></small>
                            </td>
                            <td><?= $detail['quantity'] ?></td>
                            <td><?= number_format($detail['unit_price'], 0, ',', '.') ?> đ</td>
                            <td><?= number_format($detail['subtotal'], 0, ',', '.') ?> đ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <?php 
                            $subtotal = 0;
                            foreach ($orderDetails as $detail) {
                                $subtotal += $detail['subtotal'];
                            }
                            $discountAmount = isset($order['discount_amount']) ? $order['discount_amount'] : 0;
                        ?>
                        <tr>
                            <td colspan="3" class="text-end">Tạm tính:</td>
                            <td><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
                        </tr>
                        <?php if ($discountAmount > 0): ?>
                        <tr class="text-success">
                            <td colspan="3" class="text-end">Giảm giá:</td>
                            <td>-<?= number_format($discountAmount, 0, ',', '.') ?> đ</td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tổng Tiền:</strong></td>
                            <td class="fw-bold text-primary"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="<?= BASE_URL ?>product/index" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i> Tiếp Tục Mua Sắm
                    </a>
                    <?php if (isset($_SESSION['customer_id'])): ?>
                    <a href="<?= BASE_URL ?>customer/orders" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-bag me-2"></i> Xem Đơn Hàng Của Tôi
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
