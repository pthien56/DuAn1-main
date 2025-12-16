<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.contact-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    border-radius: 15px;
    overflow: hidden;
}
.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
.contact-icon-box {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 20px;
    transition: all 0.3s;
}
.contact-icon-box:hover {
    transform: scale(1.1) rotate(5deg);
}
.form-control:focus,
.form-select:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
}
.btn-primary {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
}
.social-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    text-decoration: none;
}
.social-btn:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.map-container {
    border-radius: 15px;
    overflow: hidden;
    min-height: 400px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
</style>

<div class="container mb-5 mt-4">
    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm contact-card border-0">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-envelope-paper me-2"></i> Gửi Tin Nhắn
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= BASE_URL ?>page/contact" id="contactForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="bi bi-person me-1"></i> Họ và Tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($customer['full_name'] ?? $_SESSION['customer_name'] ?? '') ?>"
                                       placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="bi bi-phone me-1"></i> Số Điện Thoại <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= htmlspecialchars($customer['phone_number'] ?? '') ?>"
                                       placeholder="0901234567" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope me-1"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($customer['email'] ?? $_SESSION['customer_email'] ?? '') ?>"
                                   placeholder="your@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold">
                                <i class="bi bi-tag me-1"></i> Chủ Đề <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Chọn chủ đề</option>
                                <option value="Hỗ trợ sản phẩm">Hỗ trợ sản phẩm</option>
                                <option value="Đặt hàng">Đặt hàng</option>
                                <option value="Bảo hành">Bảo hành</option>
                                <option value="Khiếu nại">Khiếu nại</option>
                                <option value="Góp ý">Góp ý</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">
                                <i class="bi bi-chat-left-text me-1"></i> Nội Dung Tin Nhắn <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="6" 
                                      placeholder="Vui lòng nhập nội dung tin nhắn của bạn..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-send me-2"></i> Gửi Tin Nhắn
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Contact Info Sidebar -->
        <div class="col-lg-4">
            <!-- Contact Information -->
            <div class="card shadow-sm mb-4 contact-card border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle me-2 text-danger"></i> Thông Tin Liên Hệ
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <div class="text-center">
                            <div class="contact-icon-box bg-danger bg-opacity-10 text-danger mx-auto">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Địa Chỉ</h6>
                            <p class="text-muted mb-0 small">
                                Beta, Tổ hợp GD FPT<br>
                                Võ Nguyên Giáp, TP. Thanh Hóa
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-center">
                            <div class="contact-icon-box bg-success bg-opacity-10 text-success mx-auto">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Hotline</h6>
                            <p class="text-muted mb-0 small">
                                <a href="tel:1900000000" class="text-decoration-none text-dark fw-bold">1900-000-000</a><br>
                                Hỗ trợ 24/7
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-center">
                            <div class="contact-icon-box bg-warning bg-opacity-10 text-warning mx-auto">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Email</h6>
                            <p class="text-muted mb-0 small">
                                <a href="mailto:info@mivonstore.vn" class="text-decoration-none text-dark">info@mivonstore.vn</a><br>
                                <a href="mailto:support@mivonstore.vn" class="text-decoration-none text-dark">support@mivonstore.vn</a>
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-center">
                            <div class="contact-icon-box bg-info bg-opacity-10 text-info mx-auto">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Giờ Làm Việc</h6>
                            <p class="text-muted mb-0 small">
                                Thứ 2 - Thứ 6: 8:00 - 20:00<br>
                                Thứ 7 - Chủ nhật: 9:00 - 18:00
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="card shadow-sm contact-card border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-share me-2 text-danger"></i> Mạng Xã Hội
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-4">Theo dõi chúng tôi trên các mạng xã hội</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="#" class="social-btn bg-primary text-white" title="Facebook">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="social-btn bg-danger text-white" title="Instagram">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        <a href="#" class="social-btn text-white" style="background: #0068ff;" title="Zalo">
                            <i class="bi bi-chat-dots fs-5"></i>
                        </a>
                        <a href="#" class="social-btn bg-danger text-white" title="YouTube">
                            <i class="bi bi-youtube fs-5"></i>
                        </a>
                        <a href="#" class="social-btn bg-dark text-white" title="TikTok">
                            <i class="bi bi-tiktok fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm contact-card border-0">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-map me-2"></i> Bản Đồ
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="map-container">
                        <i class="bi bi-geo-alt" style="font-size: 5rem; color: #dee2e6;"></i>
                        <h5 class="mt-3 mb-2 fw-bold">Beta, Tổ hợp GD FPT</h5>
                        <p class="text-muted mb-3">Võ Nguyên Giáp, TP. Thanh Hóa</p>
                        <a href="https://www.google.com/maps/search/Beta,+Tổ+hợp+GD+FPT,+Võ+Nguyên+Giáp,+TP.+Thanh+Hóa" 
                           target="_blank" 
                           class="btn btn-danger">
                            <i class="bi bi-geo-alt-fill me-2"></i> Xem trên Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#contactForm').on('submit', function(e) {
        var btn = $(this).find('button[type="submit"]');
        var originalText = btn.html();
        
        // Validation
        var name = $('#name').val().trim();
        var phone = $('#phone').val().trim();
        var email = $('#email').val().trim();
        var subject = $('#subject').val();
        var message = $('#message').val().trim();
        
        if (!name || !phone || !email || !subject || !message) {
            e.preventDefault();
            alert('Vui lòng điền đầy đủ thông tin');
            return false;
        }
        
        // Phone validation
        var phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
            e.preventDefault();
            alert('Số điện thoại không hợp lệ. Vui lòng nhập 10-11 chữ số');
            $('#phone').focus();
            return false;
        }
        
        // Email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Email không hợp lệ. Vui lòng nhập đúng định dạng email');
            $('#email').focus();
            return false;
        }
        
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang gửi...');
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
