document.addEventListener('DOMContentLoaded', function() {
    

    //  La sidebar toogle para telefonitos

    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    // Cerrar sidebar al hacer clic fuera en móvil

    document.addEventListener('click', function(event) {
        if (window.innerWidth < 768 && sidebar && sidebar.classList.contains('active')) {
            if (!sidebar.contains(event.target) && !sidebarToggle?.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    

    //  Por silas :3

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    

    // buscar en vivo en las tablas de chill

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('#clientesTable tbody tr, #ordenesTable tbody tr');
            
            tableRows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    }
    

    // Confirmacion de eliminar :v

    const deleteButtons = document.querySelectorAll('.btn-delete, .delete-confirm');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
    

    //  Autocerrado alerta por si las mosquis ;v

    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            }
        }, 5000);
    });
    
    //  formato de moneda input pa q no se me olvide

    const montoInputs = document.querySelectorAll('.format-monto');
    montoInputs.forEach(input => {
        input.addEventListener('blur', function() {
            let value = this.value.replace(/[^0-9.,]/g, '');
            if (value) {
                let number = parseFloat(value.replace(',', '.'));
                if (!isNaN(number)) {
                    this.value = number.toFixed(2);
                }
            }
        });
    });
    

    //  detectar enlaces activos bien chidori

    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '#' && currentPath.includes(href)) {
            link.classList.add('active');
        }
    });
    
});