    </div>

    <footer class="footer-custom mt-5">
        <div class="footer-top">
            <div class="container py-5">
                <div class="row g-4">
                    <!-- About Section -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="footer-widget">
                            <h5 class="footer-title mb-4">
                                <span class="text-danger">MIVON</span><span class="text-white">STORE</span>
                            </h5>
                            <p class="footer-text mb-4">
                                Chuyên bán điện thoại và phụ kiện điện tử chính hãng, uy tín hàng đầu Việt Nam. 
                                Cam kết chất lượng, giá tốt nhất thị trường.
                            </p>
                            <div class="social-links">
                                <h6 class="text-white mb-3">Kết nối với chúng tôi</h6>
                                <div class="d-flex gap-3">
                                    <a href="#" class="social-link facebook" title="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="#" class="social-link instagram" title="Instagram">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    <a href="#" class="social-link youtube" title="YouTube">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                    <a href="#" class="social-link zalo" title="Zalo">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>
                                    <a href="#" class="social-link tiktok" title="TikTok">
                                        <i class="bi bi-tiktok"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-widget">
                            <h6 class="footer-heading mb-4">Liên Kết Nhanh</h6>
                            <ul class="footer-links">
                                <li><a href="<?= BASE_URL ?>home/index"><i class="bi bi-house me-2"></i>Trang Chủ</a></li>
                                <li><a href="<?= BASE_URL ?>product/index"><i class="bi bi-shop me-2"></i>Sản Phẩm</a></li>
                                <li><a href="<?= BASE_URL ?>page/about"><i class="bi bi-info-circle me-2"></i>Giới Thiệu</a></li>
                                <li><a href="<?= BASE_URL ?>page/contact"><i class="bi bi-envelope me-2"></i>Liên Hệ</a></li>
                                <?php if (isset($_SESSION['customer_id'])): ?>
                                <li><a href="<?= BASE_URL ?>customer/profile"><i class="bi bi-person me-2"></i>Tài Khoản</a></li>
                                <li><a href="<?= BASE_URL ?>customer/orders"><i class="bi bi-bag me-2"></i>Đơn Hàng</a></li>
                                <?php else: ?>
                                <li><a href="<?= BASE_URL ?>auth/login"><i class="bi bi-box-arrow-in-right me-2"></i>Đăng Nhập</a></li>
                                <li><a href="<?= BASE_URL ?>auth/register"><i class="bi bi-person-plus me-2"></i>Đăng Ký</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-widget">
                            <h6 class="footer-heading mb-4">Sản Phẩm</h6>
                            <ul class="footer-links">
                                <li><a href="<?= BASE_URL ?>product/index?brand=Apple"><i class="bi bi-phone me-2"></i>iPhone</a></li>
                                <li><a href="<?= BASE_URL ?>product/index?brand=Samsung"><i class="bi bi-phone me-2"></i>Samsung</a></li>
                                <li><a href="<?= BASE_URL ?>product/index?brand=Xiaomi"><i class="bi bi-phone me-2"></i>Xiaomi</a></li>
                                <li><a href="<?= BASE_URL ?>product/index?brand=OPPO"><i class="bi bi-phone me-2"></i>OPPO</a></li>
                                <li><a href="<?= BASE_URL ?>product/index?brand=Vivo"><i class="bi bi-phone me-2"></i>Vivo</a></li>
                                <li><a href="<?= BASE_URL ?>product/index"><i class="bi bi-grid me-2"></i>Tất Cả Sản Phẩm</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-widget">
                            <h6 class="footer-heading mb-4">Hỗ Trợ</h6>
                            <ul class="footer-links">
                                <li><a href="#"><i class="bi bi-shield-check me-2"></i>Chính Sách Bảo Hành</a></li>
                                <li><a href="#"><i class="bi bi-cart-check me-2"></i>Hướng Dẫn Mua Hàng</a></li>
                                <li><a href="#"><i class="bi bi-arrow-repeat me-2"></i>Chính Sách Đổi Trả</a></li>
                                <li><a href="#"><i class="bi bi-truck me-2"></i>Vận Chuyển</a></li>
                                <li><a href="#"><i class="bi bi-question-circle me-2"></i>FAQ</a></li>
                                <li><a href="<?= BASE_URL ?>page/contact"><i class="bi bi-headset me-2"></i>Hỗ Trợ 24/7</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="footer-widget">
                            <h6 class="footer-heading mb-4">Thông Tin Liên Hệ</h6>
                            <ul class="footer-contact">
                                <li class="mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="contact-icon me-3">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                        <div>
                                            <strong>Địa Chỉ</strong>
                                            <p class="mb-0 small">Beta, Tổ hợp GD FPT<br>Võ Nguyên Giáp, TP. Thanh Hóa</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="contact-icon me-3">
                                            <i class="bi bi-telephone-fill"></i>
                                        </div>
                                        <div>
                                            <strong>Hotline</strong>
                                            <p class="mb-0">
                                                <a href="tel:1900000000" class="text-white text-decoration-none">1900-000-000</a><br>
                                                <small class="text-muted">Hỗ trợ 24/7</small>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="contact-icon me-3">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <div>
                                            <strong>Email</strong>
                                            <p class="mb-0">
                                                <a href="mailto:info@mivonstore.vn" class="text-white text-decoration-none">info@mivonstore.vn</a><br>
                                                <a href="mailto:support@mivonstore.vn" class="text-white text-decoration-none">support@mivonstore.vn</a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-start">
                                        <div class="contact-icon me-3">
                                            <i class="bi bi-clock-fill"></i>
                                        </div>
                                        <div>
                                            <strong>Giờ Làm Việc</strong>
                                            <p class="mb-0 small">Thứ 2 - Thứ 6: 8:00 - 20:00<br>Thứ 7 - Chủ nhật: 9:00 - 18:00</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container py-3">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="mb-0 small">
                            &copy; <?= date('Y') ?> <strong>MivonStore</strong>. Tất cả quyền được bảo lưu.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="payment-methods">
                            <span class="small me-2">Chấp nhận thanh toán:</span>
                            <i class="bi bi-credit-card me-2" title="Thẻ tín dụng"></i>
                            <i class="bi bi-wallet2 me-2" title="Ví điện tử"></i>
                            <i class="bi bi-cash-coin" title="Tiền mặt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <style>
    .footer-custom {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #e0e0e0;
    }
    .footer-top {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .footer-widget {
        height: 100%;
    }
    .footer-title {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 1rem;
        letter-spacing: -1px;
    }
    .footer-text {
        color: #b0b0b0;
        line-height: 1.6;
        font-size: 0.9rem;
    }
    .footer-heading {
        color: #fff;
        font-weight: 600;
        font-size: 1.1rem;
        position: relative;
        padding-bottom: 10px;
    }
    .footer-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, #dc3545, #ffc107);
        border-radius: 2px;
    }
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-links li {
        margin-bottom: 10px;
    }
    .footer-links a {
        color: #b0b0b0;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .footer-links a:hover {
        color: #dc3545;
        transform: translateX(5px);
        text-decoration: none;
    }
    .footer-links a i {
        width: 20px;
    }
    .social-links {
        margin-top: 20px;
    }
    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }
    .social-link:hover {
        transform: translateY(-5px);
        color: #fff;
        text-decoration: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .social-link.facebook:hover {
        background: #1877f2;
    }
    .social-link.instagram:hover {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    }
    .social-link.youtube:hover {
        background: #ff0000;
    }
    .social-link.zalo:hover {
        background: #0068ff;
    }
    .social-link.tiktok:hover {
        background: #000000;
    }
    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-contact li {
        margin-bottom: 15px;
    }
    .contact-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(220, 53, 69, 0.15);
        border-radius: 50%;
        color: #dc3545;
        flex-shrink: 0;
        font-size: 1.1rem;
    }
    .footer-contact strong {
        color: #fff;
        display: block;
        margin-bottom: 5px;
        font-size: 0.95rem;
    }
    .footer-contact a {
        color: #b0b0b0;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .footer-contact a:hover {
        color: #dc3545;
    }
    .footer-bottom {
        background: rgba(0, 0, 0, 0.3);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    .footer-bottom .small {
        color: #b0b0b0;
    }
    .payment-methods i {
        font-size: 1.5rem;
        color: #b0b0b0;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .payment-methods i:hover {
        color: #dc3545;
        transform: scale(1.2);
    }
    @media (max-width: 768px) {
        .footer-widget {
            margin-bottom: 30px;
        }
        .footer-title {
            font-size: 1.5rem;
        }
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>public/js/cart-storage.js"></script>
    <script src="<?= BASE_URL ?>public/js/main.js"></script>
</body>
</html>
