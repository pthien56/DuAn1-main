<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.processing-container {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.processing-card {
    max-width: 500px;
    text-align: center;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}
.spinner-custom {
    width: 80px;
    height: 80px;
    border: 6px solid #f3f3f3;
    border-top: 6px solid #dc3545;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 30px;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.vnpay-logo {
    font-size: 3rem;
    color: #dc3545;
    margin-bottom: 20px;
}
</style>

<div class="container">
    <div class="processing-container">
        <div class="processing-card">
            <div class="vnpay-logo">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="spinner-custom"></div>
            <h3 class="fw-bold mb-3">Đang chuyển đến VNPay</h3>
            <p class="text-muted mb-4">
                Vui lòng đợi trong giây lát...<br>
                Bạn sẽ được chuyển đến cổng thanh toán VNPay
            </p>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <small>Không đóng trình duyệt trong quá trình thanh toán</small>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
