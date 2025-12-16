<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i> Chi Tiết Đơn Hàng #<?= $order['order_id'] ?></h5>
                    <a href="<?= BASE_URL ?>customer/orders" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Quay Lại
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Thông Tin Khách Hàng</h6>
                            <p class="mb-1"><strong>Họ tên:</strong> <?= htmlspecialchars($order['customer_name'] ?? '') ?></p>
                            <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? '') ?></p>
                            <p class="mb-1"><strong>SĐT:</strong> <?= htmlspecialchars($order['phone_number'] ?? '') ?></p>
                            <p class="mb-0"><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address'] ?? '') ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Thông Tin Đơn Hàng</h6>
                            <p class="mb-1"><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
                            <p class="mb-1">
                                <strong>Trạng thái:</strong> 
                                <?php
                                $statusClass = 'secondary';
                                switch($order['status_name']) {
                                    case 'Đã xác nhận': $statusClass = 'success'; break;
                                    case 'Đang xử lý': $statusClass = 'info'; break;
                                    case 'Đang giao hàng': $statusClass = 'primary'; break;
                                    case 'Đã giao': $statusClass = 'success'; break;
                                    case 'Đã hủy': $statusClass = 'danger'; break;
                                }
                                ?>
                                <span class="badge bg-<?= $statusClass ?>"><?= htmlspecialchars($order['status_name'] ?? 'Chờ xử lý') ?></span>
                            </p>
                            <p class="mb-1"><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method'] ?? 'Tiền mặt') ?></p>
                            <?php if ($order['note']): ?>
                                <p class="mb-0"><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-3"><i class="bi bi-box-seam me-2"></i> Sản Phẩm Đã Đặt</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40%;">Sản Phẩm</th>
                                    <th>Biến Thể</th>
                                    <th class="text-center" style="width: 10%;">Số Lượng</th>
                                    <th class="text-end" style="width: 15%;">Đơn Giá</th>
                                    <th class="text-end" style="width: 15%;">Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderDetails as $detail): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php 
                                                    $imgUrl = BASE_URL . "public/data/" . rawurlencode($detail['product_name'] ?? 'default') . ".jpg";
                                                ?>
                                                <img src="<?= $imgUrl ?>" 
                                                     alt="<?= htmlspecialchars($detail['product_name'] ?? '') ?>" 
                                                     class="me-3 rounded" 
                                                     style="width: 60px; height: 60px; object-fit: cover;"
                                                     onerror="this.src='https://placehold.co/60x60?text=<?= urlencode($detail['product_name'] ?? '') ?>'">
                                                <div>
                                                    <strong class="d-block"><?= htmlspecialchars($detail['product_name'] ?? '') ?></strong>
                                                    <?php if ($detail['brand']): ?>
                                                        <small class="text-muted"><?= htmlspecialchars($detail['brand']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($detail['color']): ?>
                                                <span class="badge bg-secondary mb-1 d-block"><?= htmlspecialchars($detail['color']) ?></span>
                                            <?php endif; ?>
                                            <?php if ($detail['storage']): ?>
                                                <span class="badge bg-info"><?= htmlspecialchars($detail['storage']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-primary"><?= $detail['quantity'] ?></span>
                                        </td>
                                        <td class="text-end align-middle"><?= number_format($detail['unit_price'], 0, ',', '.') ?>₫</td>
                                        <td class="text-end align-middle fw-bold text-primary"><?= number_format($detail['subtotal'], 0, ',', '.') ?>₫</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold fs-5">Tổng Cộng:</td>
                                    <td class="text-end fw-bold text-danger fs-4"><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

