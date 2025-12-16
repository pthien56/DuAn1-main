<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>Quản Lý Bài Viết
        </h4>
        <div>
            <a href="<?= BASE_URL ?>admin/postCategories" class="btn btn-outline-secondary me-2">
                <i class="bi bi-folder me-1"></i> Danh Mục
            </a>
            <a href="<?= BASE_URL ?>admin/postCreate" class="btn btn-danger">
                <i class="bi bi-plus-lg me-1"></i> Thêm Bài Viết
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <form method="GET" action="<?= BASE_URL ?>admin/posts" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label class="form-label mb-0 me-2">Trạng thái:</label>
                </div>
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Tất cả</option>
                        <option value="draft" <?= $statusFilter === 'draft' ? 'selected' : '' ?>>Nháp</option>
                        <option value="published" <?= $statusFilter === 'published' ? 'selected' : '' ?>>Đã xuất bản</option>
                        <option value="archived" <?= $statusFilter === 'archived' ? 'selected' : '' ?>>Lưu trữ</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Lượt xem</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($posts)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Chưa có bài viết nào
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td>
                                        <?php if ($post['thumbnail']): ?>
                                            <img src="<?= BASE_URL . $post['thumbnail'] ?>" 
                                                 alt="<?= htmlspecialchars($post['title']) ?>"
                                                 class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 40px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($post['title']) ?></strong>
                                        <?php if ($post['is_featured']): ?>
                                            <span class="badge bg-warning ms-1"><i class="bi bi-star-fill"></i></span>
                                        <?php endif; ?>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars($post['slug']) ?></small>
                                    </td>
                                    <td>
                                        <?php if ($post['category_name']): ?>
                                            <span class="badge bg-info"><?= htmlspecialchars($post['category_name']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'draft' => 'secondary',
                                            'published' => 'success',
                                            'archived' => 'dark'
                                        ];
                                        $statusText = [
                                            'draft' => 'Nháp',
                                            'published' => 'Đã xuất bản',
                                            'archived' => 'Lưu trữ'
                                        ];
                                        ?>
                                        <span class="badge bg-<?= $statusClass[$post['status']] ?? 'secondary' ?>">
                                            <?= $statusText[$post['status']] ?? $post['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <i class="bi bi-eye me-1"></i><?= number_format($post['view_count']) ?>
                                    </td>
                                    <td>
                                        <small><?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= BASE_URL ?>admin/postEdit/<?= $post['post_id'] ?>" 
                                               class="btn btn-outline-primary" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/postDelete/<?= $post['post_id'] ?>" 
                                               class="btn btn-outline-danger" title="Xóa"
                                               onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>admin/posts?page=<?= $i ?><?= $statusFilter ? '&status=' . $statusFilter : '' ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
