// Validasi form
(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();

// Auto-close alert setelah 3 detik
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 3000);
    });
});

// Smooth scroll saat submit form
document.querySelector('form')?.addEventListener('submit', function(e) {
    if (this.checkValidity()) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
});