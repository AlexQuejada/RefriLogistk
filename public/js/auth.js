document.addEventListener('DOMContentLoaded', function() {
    
    const logoutBtn = document.querySelector('.btn-logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                e.preventDefault();
            }
        });
    }
    
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            if (input) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            }
        });
    });
    
    const passwordForm = document.querySelector('.password-change-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const nueva = document.getElementById('password_nueva');
            const confirmar = document.getElementById('password_confirmar');
            
            if (nueva.value !== confirmar.value) {
                e.preventDefault();
                alert('Las contraseñas nuevas no coinciden');
            }
        });
    }
});