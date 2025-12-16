<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<h2 class="mb-4">Sửa Khách Hàng</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>admin/customerEdit/<?= $customer['customer_id'] ?>">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và Tên *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               value="<?= htmlspecialchars($customer['full_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Số Điện Thoại</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                               value="<?= htmlspecialchars($customer['phone_number']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($customer['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa Chỉ</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?= htmlspecialchars($customer['address']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới Tính</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" <?= $customer['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                            <option value="Nữ" <?= $customer['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                            <option value="Khác" <?= $customer['gender'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Ngày Sinh</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                               value="<?= $customer['date_of_birth'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="<?= BASE_URL ?>admin/customers" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

