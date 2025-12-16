<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.auth-card {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}
.auth-card-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    padding: 30px;
    text-align: center;
}
.auth-card-body {
    padding: 40px;
}
.form-control:focus,
.form-select:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
}
.input-group-text {
    background: #f8f9fa;
    border-right: none;
}
.input-group .form-control {
    border-left: none;
}
.input-group:focus-within .input-group-text {
    border-color: #dc3545;
    background: #fff5f5;
}
.btn-login {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-login:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(220, 53, 69, 0.3);
}
.social-login {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}
.social-btn {
    flex: 1;
    padding: 12px;
    border: 2px solid #dee2e6;
    border-radius: 10px;
    background: white;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 500;
}
.social-btn:hover {
    border-color: #dc3545;
    background: #fff5f5;
    color: #dc3545;
    transform: translateY(-2px);
}
.social-btn.google {
    border-color: #4285f4;
    color: #4285f4;
}
.social-btn.google:hover {
    background: #4285f4;
    color: white;
}
.social-btn.zalo {
    border-color: #0068ff;
    color: #0068ff;
}
.social-btn.zalo:hover {
    background: #0068ff;
    color: white;
}
.divider {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 25px 0;
}
.divider::before,
.divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #dee2e6;
}
.divider span {
    padding: 0 15px;
    color: #6c757d;
    font-size: 0.9rem;
}
.benefits-list {
    list-style: none;
    padding: 0;
}
.benefits-list li {
    padding: 10px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.benefits-list li i {
    color: #28a745;
    font-size: 1.2rem;
}
</style>

<div class="container mb-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <!-- Login Form -->
                <div class="col-lg-6 mb-4">
                    <div class="auth-card card">
                        <div class="auth-card-header">
                            <h3 class="mb-2 fw-bold">Đăng Nhập Tài Khoản</h3>
                            <p class="mb-0 opacity-90">Nhập thông tin để tiếp tục</p>
                        </div>
                        <div class="auth-card-body">
                            <form method="POST" action="<?= BASE_URL ?>auth/login" id="loginForm">
                                <div class="mb-4">
                                    <label for="username" class="form-label fw-bold">
                                        <i class="bi bi-person me-1"></i> Tên đăng nhập / Email <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-lg" id="username" name="username" 
                                               placeholder="admin hoặc email@example.com" required autofocus>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i> Admin dùng username, Khách hàng dùng email
                                    </small>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">
                                        <i class="bi bi-lock me-1"></i> Mật Khẩu <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                               placeholder="Nhập mật khẩu" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                                    <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                                </div>
                                
                                <button type="submit" class="btn btn-login btn-lg w-100 text-white mb-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Đăng Nhập
                                </button>
                                
                                <div class="divider">
                                    <span>Hoặc đăng nhập bằng</span>
                                </div>
                                
                                <div class="social-login">
                                    <a href="#" class="social-btn google">
                                        <i class="bi bi-google"></i>
                                        <span>Google</span>
                                    </a>
                                    <a href="#" class="social-btn zalo">
                                        <i class="bi bi-chat-dots"></i>
                                        <span>Zalo</span>
                                    </a>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <p class="mb-2">
                                        Chưa có tài khoản? 
                                        <a href="<?= BASE_URL ?>auth/register" class="text-danger fw-bold text-decoration-none">
                                            Đăng ký ngay
                                        </a>
                                    </p>
                                    <a href="<?= BASE_URL ?>home/index" class="text-muted small text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i> Về Trang Chủ
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Benefits Section -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-5 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-4 text-danger">
                                <i class="bi bi-star-fill me-2"></i> Lợi Ích Khi Đăng Nhập
                            </h3>
                            <ul class="benefits-list">
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Mua sắm nhanh chóng</strong>
                                        <p class="text-muted small mb-0">Lưu thông tin và đặt hàng dễ dàng hơn</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Theo dõi đơn hàng</strong>
                                        <p class="text-muted small mb-0">Xem trạng thái đơn hàng mọi lúc, mọi nơi</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Ưu đãi đặc biệt</strong>
                                        <p class="text-muted small mb-0">Nhận các chương trình khuyến mãi độc quyền</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Lịch sử mua hàng</strong>
                                        <p class="text-muted small mb-0">Xem lại các sản phẩm đã mua trước đó</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Hỗ trợ 24/7</strong>
                                        <p class="text-muted small mb-0">Được tư vấn và hỗ trợ tốt nhất</p>
                                    </div>
                                </li>
                            </ul>
                            
                            <div class="mt-4 p-4 bg-light rounded">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-shield-check text-success me-2"></i> Bảo Mật
                                </h6>
                                <p class="small mb-0 text-muted">
                                    Thông tin của bạn được bảo mật tuyệt đối. Chúng tôi cam kết không chia sẻ dữ liệu cá nhân với bên thứ ba.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').on('click', function() {
        var passwordInput = $('#password');
        var icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
    
    $('#loginForm').on('submit', function(e) {
        var btn = $(this).find('button[type="submit"]');
        var originalText = btn.html();
        
        var username = $('#username').val().trim();
        var password = $('#password').val();
        
        if (!username) {
            e.preventDefault();
            showAlert('Vui lòng nhập tên đăng nhập hoặc email', 'warning');
            $('#username').focus();
            return false;
        }
        
        if (!password) {
            e.preventDefault();
            showAlert('Vui lòng nhập mật khẩu', 'warning');
            $('#password').focus();
            return false;
        }
        
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang đăng nhập...');
        
        setTimeout(function() {
            btn.prop('disabled', false).html(originalText);
        }, 10000);
    });
    
    function showAlert(message, type) {
        type = type || 'info';
        var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; min-width: 300px;" role="alert">' +
            '<i class="bi bi-exclamation-triangle me-2"></i>' + message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>';
        $('body').append(alertHtml);
        setTimeout(function() {
            $('.alert').fadeOut(function() {
                $(this).remove();
            });
        }, 4000);
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
