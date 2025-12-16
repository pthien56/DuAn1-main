// Admin Panel JavaScript

$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Confirm delete actions
    $('.btn-danger').on('click', function(e) {
        if (!confirm('Bạn có chắc chắn muốn thực hiện hành động này?')) {
            e.preventDefault();
        }
    });
});

