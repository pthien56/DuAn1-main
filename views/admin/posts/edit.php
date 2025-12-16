<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-pencil me-2"></i>Sửa Bài Viết
        </h4>
        <a href="<?= BASE_URL ?>admin/posts" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>admin/postEdit/<?= $post['post_id'] ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg" 
                                   value="<?= htmlspecialchars($post['title']) ?>" required id="title">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control" 
                                   value="<?= htmlspecialchars($post['slug']) ?>" id="slug">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="excerpt" class="form-control" rows="3"><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nội dung</label>
                            <textarea name="content" class="form-control" rows="15" id="content"><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Xuất bản</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="draft" <?= $post['status'] === 'draft' ? 'selected' : '' ?>>Nháp</option>
                                <option value="published" <?= $post['status'] === 'published' ? 'selected' : '' ?>>Xuất bản</option>
                                <option value="archived" <?= $post['status'] === 'archived' ? 'selected' : '' ?>>Lưu trữ</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                                       <?= $post['is_featured'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_featured">
                                    <i class="bi bi-star text-warning me-1"></i> Bài viết nổi bật
                                </label>
                            </div>
                        </div>
                        
                        <?php if ($post['published_at']): ?>
                            <p class="small text-muted mb-3">
                                <i class="bi bi-calendar me-1"></i>
                                Xuất bản: <?= date('d/m/Y H:i', strtotime($post['published_at'])) ?>
                            </p>
                        <?php endif; ?>
                        
                        <p class="small text-muted mb-3">
                            <i class="bi bi-eye me-1"></i>
                            Lượt xem: <?= number_format($post['view_count']) ?>
                        </p>
                        
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-check-lg me-1"></i> Cập Nhật
                        </button>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Danh mục</h6>
                    </div>
                    <div class="card-body">
                        <select name="category_id" class="form-select">
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>" 
                                        <?= $post['category_id'] == $cat['category_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Ảnh đại diện</h6>
                    </div>
                    <div class="card-body">
                        <?php if ($post['thumbnail']): ?>
                            <div class="mb-3">
                                <img src="<?= BASE_URL . $post['thumbnail'] ?>" 
                                     alt="Thumbnail" class="img-fluid rounded" style="max-height: 150px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" id="thumbnailInput">
                        <small class="text-muted">Để trống nếu không muốn thay đổi</small>
                        <div id="thumbnailPreview" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Thumbnail preview
document.getElementById('thumbnailInput').addEventListener('change', function(e) {
    var preview = document.getElementById('thumbnailPreview');
    preview.innerHTML = '';
    
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-fluid rounded';
            img.style.maxHeight = '150px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
