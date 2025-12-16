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
.btn-register {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-register:hover {
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
.password-strength {
    height: 4px;
    border-radius: 2px;
    margin-top: 5px;
    transition: all 0.3s;
}
.password-strength.weak {
    background: #dc3545;
    width: 33%;
}
.password-strength.medium {
    background: #ffc107;
    width: 66%;
}
.password-strength.strong {
    background: #28a745;
    width: 100%;
}
</style>

<div class="container mb-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <!-- Register Form -->
                <div class="col-lg-7 mb-4">
                    <div class="auth-card card">
                        <div class="auth-card-header">
                            <h3 class="mb-2 fw-bold">Thông Tin Đăng Ký</h3>
                            <p class="mb-0 opacity-90">Điền thông tin để tạo tài khoản mới</p>
                        </div>
                        <div class="auth-card-body">
                            <form method="POST" action="<?= BASE_URL ?>auth/register" id="registerForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="full_name" class="form-label fw-bold">
                                            <i class="bi bi-person me-1"></i> Họ và Tên <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                                   placeholder="Nguyễn Văn A" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone_number" class="form-label fw-bold">
                                            <i class="bi bi-phone me-1"></i> Số Điện Thoại <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-phone"></i>
                                            </span>
                                            <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                                   placeholder="0901234567" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="bi bi-envelope me-1"></i> Email <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="your@email.com" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label fw-bold">
                                            <i class="bi bi-lock me-1"></i> Mật Khẩu <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Nhập mật khẩu" required minlength="6">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength" id="passwordStrength"></div>
                                        <small class="text-muted">Tối thiểu 6 ký tự</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="confirm_password" class="form-label fw-bold">
                                            <i class="bi bi-lock-fill me-1"></i> Xác Nhận Mật Khẩu <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock-fill"></i>
                                            </span>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   placeholder="Nhập lại mật khẩu" required>
                                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label fw-bold">
                                            <i class="bi bi-gender-ambiguous me-1"></i> Giới Tính
                                        </label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="">Chọn giới tính</option>
                                            <option value="Nam">Nam</option>
                                            <option value="Nữ">Nữ</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="date_of_birth" class="form-label fw-bold">
                                            <i class="bi bi-calendar me-1"></i> Ngày Sinh
                                        </label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="address" class="form-label fw-bold">
                                        <i class="bi bi-geo-alt me-1"></i> Địa Chỉ <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" id="address" name="address" rows="3" 
                                              placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố" required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-register btn-lg w-100 text-white mb-3">
                                    <i class="bi bi-check-circle me-2"></i> Đăng Ký
                                </button>
                                
                                <div class="divider">
                                    <span>Hoặc đăng ký bằng</span>
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
                                        Đã có tài khoản? 
                                        <a href="<?= BASE_URL ?>auth/login" class="text-danger fw-bold text-decoration-none">
                                            Đăng nhập ngay
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
                <div class="col-lg-5 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-5 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-4 text-danger">
                                <i class="bi bi-gift-fill me-2"></i> Tại Sao Nên Đăng Ký?
                            </h3>
                            <ul class="benefits-list">
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Mua sắm nhanh chóng</strong>
                                        <p class="text-muted small mb-0">Lưu thông tin và đặt hàng chỉ với vài cú click</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Ưu đãi độc quyền</strong>
                                        <p class="text-muted small mb-0">Nhận các chương trình khuyến mãi đặc biệt</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Theo dõi đơn hàng</strong>
                                        <p class="text-muted small mb-0">Xem trạng thái đơn hàng real-time</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Lịch sử mua hàng</strong>
                                        <p class="text-muted small mb-0">Xem lại và mua lại sản phẩm yêu thích</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>
                                        <strong>Điểm tích lũy</strong>
                                        <p class="text-muted small mb-0">Tích điểm và đổi quà hấp dẫn</p>
                                    </div>
                                </li>
                            </ul>
                            
                            <div class="mt-4 p-4 bg-light rounded">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-shield-check text-success me-2"></i> Bảo Mật Thông Tin
                                </h6>
                                <p class="small mb-0 text-muted">
                                    Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn. Dữ liệu được mã hóa và không chia sẻ với bên thứ ba.
                                </p>
                            </div>
                            
                            <div class="mt-3 p-4 bg-danger bg-opacity-10 rounded">
                                <h6 class="fw-bold mb-2 text-danger">
                                    <i class="bi bi-star-fill me-2"></i> Thành Viên Smember
                                </h6>
                                <p class="small mb-0 text-muted">
                                    Đăng ký ngay để trở thành thành viên Smember và nhận ưu đãi giảm giá lên đến 10% cho mọi đơn hàng!
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
    
    $('#toggleConfirmPassword').on('click', function() {
        var confirmInput = $('#confirm_password');
        var icon = $(this).find('i');
        if (confirmInput.attr('type') === 'password') {
            confirmInput.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            confirmInput.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
    
    // Password strength indicator
    $('#password').on('input', function() {
        var password = $(this).val();
        var strength = $('#passwordStrength');
        strength.removeClass('weak medium strong');
        
        if (password.length === 0) {
            strength.css('width', '0');
            return;
        }
        
        var score = 0;
        if (password.length >= 6) score++;
        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        if (score <= 2) {
            strength.addClass('weak');
        } else if (score <= 3) {
            strength.addClass('medium');
        } else {
            strength.addClass('strong');
        }
    });
    
    $('#registerForm').on('submit', function(e) {
        var btn = $(this).find('button[type="submit"]');
        var originalText = btn.html();
        
        // Validate
        var fullName = $('#full_name').val().trim();
        var phone = $('#phone_number').val().trim();
        var email = $('#email').val().trim();
        var address = $('#address').val().trim();
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();
        
        if (!fullName || !phone || !email || !address || !password) {
            e.preventDefault();
            showAlert('Vui lòng điền đầy đủ thông tin bắt buộc', 'warning');
            return false;
        }
        
        // Password validation
        if (password.length < 6) {
            e.preventDefault();
            showAlert('Mật khẩu phải có ít nhất 6 ký tự', 'warning');
            $('#password').focus();
            return false;
        }
        
        if (password !== confirmPassword) {
            e.preventDefault();
            showAlert('Mật khẩu xác nhận không khớp', 'warning');
            $('#confirm_password').focus();
            return false;
        }
        
        // Phone validation
        var phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
            e.preventDefault();
            showAlert('Số điện thoại không hợp lệ. Vui lòng nhập 10-11 chữ số', 'warning');
            $('#phone_number').focus();
            return false;
        }
        
        // Email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            showAlert('Email không hợp lệ. Vui lòng nhập đúng định dạng email', 'warning');
            $('#email').focus();
            return false;
        }
        
        // Address validation
        if (address.length < 10) {
            e.preventDefault();
            showAlert('Vui lòng nhập địa chỉ chi tiết hơn', 'warning');
            $('#address').focus();
            return false;
        }
        
        // Date of birth validation
        var dob = $('#date_of_birth').val();
        if (dob) {
            var birthDate = new Date(dob);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (age < 13) {
                e.preventDefault();
                showAlert('Bạn phải từ 13 tuổi trở lên để đăng ký', 'warning');
                return false;
            }
        }
        
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Đang đăng ký...');
        
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
