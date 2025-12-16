<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.about-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    border-radius: 15px;
    overflow: hidden;
}
.about-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
}
.stat-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s;
    border: 2px solid transparent;
}
.stat-card:hover {
    border-color: #dc3545;
    transform: scale(1.05);
}
.stat-number {
    font-size: 4rem;
    font-weight: 800;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 10px;
}
.feature-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 20px;
    transition: all 0.3s;
}
.feature-icon:hover {
    transform: scale(1.1) rotate(5deg);
}
.contact-info-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s;
}
.contact-info-card:hover {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    transform: translateY(-5px);
}
.contact-info-card:hover .contact-icon,
.contact-info-card:hover h5,
.contact-info-card:hover p {
    color: white !important;
}
.contact-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    color: #dc3545;
}
</style>

<div class="container mb-5 mt-4">
    <!-- Introduction Section -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 border-0 about-card">
                <div class="card-body p-5">
                    <h2 class="text-danger mb-4 fw-bold">
                        <i class="bi bi-info-circle me-2"></i> Giới Thiệu
                    </h2>
                    <p class="lead mb-4">MIVONSTORE là cửa hàng chuyên bán điện thoại và phụ kiện điện tử chính hãng, uy tín hàng đầu tại Việt Nam.</p>
                    <p class="mb-4">Với hơn 10 năm kinh nghiệm trong ngành, chúng tôi tự hào mang đến cho khách hàng những sản phẩm chất lượng cao với giá cả hợp lý nhất. Chúng tôi cam kết mang đến trải nghiệm mua sắm tuyệt vời nhất cho mọi khách hàng.</p>
                    <h5 class="fw-bold mb-3 text-danger">Cam Kết Của Chúng Tôi:</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <div>
                                    <strong>Sản phẩm chính hãng 100%</strong>
                                    <p class="text-muted small mb-0">Tất cả sản phẩm đều được nhập khẩu chính hãng, có đầy đủ giấy tờ chứng minh nguồn gốc</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <div>
                                    <strong>Bảo hành chính hãng</strong>
                                    <p class="text-muted small mb-0">Bảo hành theo tiêu chuẩn của nhà sản xuất, hỗ trợ tại các trung tâm bảo hành chính hãng</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <div>
                                    <strong>Giá cả cạnh tranh</strong>
                                    <p class="text-muted small mb-0">Giá tốt nhất thị trường, nhiều chương trình khuyến mãi hấp dẫn</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                                <div>
                                    <strong>Dịch vụ chăm sóc khách hàng tận tâm</strong>
                                    <p class="text-muted small mb-0">Đội ngũ tư vấn chuyên nghiệp, hỗ trợ 24/7</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 border-0 about-card">
                <div class="card-body p-5">
                    <h2 class="text-danger mb-4 fw-bold">
                        <i class="bi bi-star-fill me-2"></i> Tại Sao Chọn Chúng Tôi?
                    </h2>
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-4">
                            <div class="flex-shrink-0">
                                <div class="feature-icon bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-2">Uy Tín</h5>
                                <p class="text-muted mb-0">Hơn 10 năm kinh nghiệm, được hàng nghìn khách hàng tin tưởng và đánh giá cao. Chúng tôi cam kết minh bạch trong mọi giao dịch.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-4">
                            <div class="flex-shrink-0">
                                <div class="feature-icon bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-truck"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-2">Giao Hàng Nhanh</h5>
                                <p class="text-muted mb-0">Giao hàng toàn quốc, nhận hàng trong 24-48 giờ. Miễn phí vận chuyển cho đơn hàng trên 5 triệu đồng.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-4">
                            <div class="flex-shrink-0">
                                <div class="feature-icon bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-headset"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-2">Hỗ Trợ 24/7</h5>
                                <p class="text-muted mb-0">Đội ngũ tư vấn chuyên nghiệp, sẵn sàng hỗ trợ mọi lúc, mọi nơi. Hotline: 1900-000-000</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="feature-icon bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-2">Đổi Trả Dễ Dàng</h5>
                                <p class="text-muted mb-0">Chính sách đổi trả linh hoạt trong 7 ngày, hoàn tiền 100% nếu không hài lòng với sản phẩm.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-danger mb-3">
                    <i class="bi bi-trophy me-2"></i> Thành Tựu Của Chúng Tôi
                </h2>
                <p class="lead text-muted">Những con số biết nói về sự tin tưởng của khách hàng</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">10+</div>
                        <h5 class="fw-bold mb-2">Năm Kinh Nghiệm</h5>
                        <p class="text-muted small mb-0">Phục vụ khách hàng từ 2014</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">50K+</div>
                        <h5 class="fw-bold mb-2">Khách Hàng</h5>
                        <p class="text-muted small mb-0">Tin tưởng và ủng hộ</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">1000+</div>
                        <h5 class="fw-bold mb-2">Sản Phẩm</h5>
                        <p class="text-muted small mb-0">Đa dạng mẫu mã</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">99%</div>
                        <h5 class="fw-bold mb-2">Hài Lòng</h5>
                        <p class="text-muted small mb-0">Tỷ lệ khách hàng hài lòng</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contact Info Section -->
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-4">
                <h2 class="display-5 fw-bold text-danger mb-3">
                    <i class="bi bi-geo-alt me-2"></i> Thông Tin Liên Hệ
                </h2>
                <p class="lead text-muted">Liên hệ với chúng tôi để được tư vấn tốt nhất</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Địa Chỉ</h5>
                        <p class="mb-0">Beta, Tổ hợp GD FPT<br>Võ Nguyên Giáp, TP. Thanh Hóa</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Hotline</h5>
                        <p class="mb-0">
                            <a href="tel:1900000000" class="text-decoration-none text-dark">1900-000-000</a><br>
                            Hỗ trợ 24/7
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Email</h5>
                        <p class="mb-0">
                            <a href="mailto:info@mivonstore.vn" class="text-decoration-none text-dark">info@mivonstore.vn</a><br>
                            <a href="mailto:support@mivonstore.vn" class="text-decoration-none text-dark">support@mivonstore.vn</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
