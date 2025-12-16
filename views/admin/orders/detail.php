<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<h2 class="mb-4">Chi Tiết Đơn Hàng #<?= $order['order_id'] ?></h2>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
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
                        <strong>Phương Thức Thanh Toán:</strong> <?= htmlspecialchars($order['payment_method']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Tổng Tiền:</strong> 
                        <span class="text-primary fw-bold"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</span>
                    </div>
                </div>
                <?php if ($order['note']): ?>
                <div class="mb-3">
                    <strong>Ghi Chú:</strong> <?= htmlspecialchars($order['note']) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Chi Tiết Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
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
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tổng Tiền:</strong></td>
                            <td class="fw-bold text-primary"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Cập Nhật Trạng Thái</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>admin/orderDetail/<?= $order['order_id'] ?>">
                    <div class="mb-3">
                        <label for="status_id" class="form-label">Trạng Thái</label>
                        <select class="form-select" id="status_id" name="status_id" required>
                            <?php foreach ($statuses as $status): ?>
                            <option value="<?= $status['order_status_id'] ?>" 
                                    <?= $status['order_status_id'] == $order['order_status_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($status['status_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cập Nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= BASE_URL ?>admin/orders" class="btn btn-secondary">Quay Lại</a>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

