<?php
require_once dirname(dirname(__DIR__)) . "/admin/layouts/header.php";
?>

<h2 class="mb-4">Thêm Danh Mục Mới</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?= BASE_URL ?>admin/categoryCreate">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo Danh Mục</button>
                    <a href="<?= BASE_URL ?>admin/categories" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(dirname(__DIR__)) . "/admin/layouts/footer.php"; ?>

