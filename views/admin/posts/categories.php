<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-folder me-2"></i>Danh Mục Bài Viết
        </h4>
        <a href="<?= BASE_URL ?>admin/posts" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <!-- Form thêm danh mục -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="bi bi-plus-circle me-1"></i> Thêm Danh Mục</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>admin/postCategoryCreate">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="VD: Tin tức">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug</label>
                            <input type="text" name="slug" class="form-control" placeholder="tu-dong-tao">
                            <small class="text-muted">Để trống để tự động tạo</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-plus-lg me-1"></i> Thêm Danh Mục
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Danh sách danh mục -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Danh sách danh mục</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tên</th>
                                    <th>Slug</th>
                                    <th>Số bài viết</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($categories)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Chưa có danh mục nào
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <tr>
                                            <td>
                                                <strong><?= htmlspecialchars($cat['name']) ?></strong>
                                                <?php if ($cat['description']): ?>
                                                    <br><small class="text-muted"><?= htmlspecialchars($cat['description']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                                            <td>
                                                <span class="badge bg-secondary"><?= $cat['post_count'] ?? 0 ?></span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" data-bs-target="#editModal<?= $cat['category_id'] ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <a href="<?= BASE_URL ?>admin/postCategoryDelete/<?= $cat['category_id'] ?>" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Xóa danh mục này?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        
                                        <!-- Modal sửa -->
                                        <div class="modal fade" id="editModal<?= $cat['category_id'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="<?= BASE_URL ?>admin/postCategoryEdit/<?= $cat['category_id'] ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Sửa Danh Mục</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Tên danh mục</label>
                                                                <input type="text" name="name" class="form-control" 
                                                                       value="<?= htmlspecialchars($cat['name']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Slug</label>
                                                                <input type="text" name="slug" class="form-control" 
                                                                       value="<?= htmlspecialchars($cat['slug']) ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Mô tả</label>
                                                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($cat['description'] ?? '') ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-danger">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
