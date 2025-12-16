<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-plus-circle me-2"></i>Thêm Bài Viết
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

    <form method="POST" action="<?= BASE_URL ?>admin/postCreate" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg" 
                                   placeholder="Nhập tiêu đề bài viết" required id="title">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control" 
                                   placeholder="tu-dong-tao-tu-tieu-de" id="slug">
                            <small class="text-muted">Để trống để tự động tạo từ tiêu đề</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="excerpt" class="form-control" rows="3" 
                                      placeholder="Mô tả ngắn gọn về bài viết..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nội dung</label>
                            <textarea name="content" class="form-control" rows="15" id="content"
                                      placeholder="Nội dung bài viết..."></textarea>
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
                                <option value="draft">Nháp</option>
                                <option value="published">Xuất bản ngay</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
                                <label class="form-check-label" for="is_featured">
                                    <i class="bi bi-star text-warning me-1"></i> Bài viết nổi bật
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-check-lg me-1"></i> Lưu Bài Viết
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
                                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Ảnh đại diện</h6>
                    </div>
                    <div class="card-body">
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" id="thumbnailInput">
                        <div id="thumbnailPreview" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Auto generate slug from title
document.getElementById('title').addEventListener('input', function() {
    var slug = this.value
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/[\s-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

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
            img.style.maxHeight = '200px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
