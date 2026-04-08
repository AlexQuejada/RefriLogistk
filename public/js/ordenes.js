document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.actualizar-estado').forEach(btn => {
        btn.addEventListener('click', async function() {
            const ordenId = this.dataset.id;
            const row = this.closest('tr');
            const select = row.querySelector('.estado-selector');
            const nuevoEstado = select.value;
            
            const estadoTexto = select.options[select.selectedIndex].text;
            
            if (!confirm(`¿Cambiar estado a "${estadoTexto.trim()}"?`)) {
                return;
            }
            
            const originalHtml = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
            
            try {
                const response = await fetch('/RefriLogistk/public/ordenes/cambiar-estado', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${ordenId}&estado=${nuevoEstado}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast(' Estado actualizado', 'success');
                    
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(' Error: ' + (data.error || 'No se pudo actualizar'), 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast(' Error al conectar con el servidor', 'danger');
            } finally {
                this.innerHTML = originalHtml;
                this.disabled = false;
            }
        });
    });
});


function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.style.minWidth = '250px';
    toast.innerHTML = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

$(document).ready(function() {
    $('#cliente_id').select2({
        theme: 'bootstrap-5',
        language: 'es',
        placeholder: 'Buscar cliente por nombre...',
        allowClear: true,
        ajax: {
            url: '/RefriLogistk/public/clientes/buscar',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.items,
                    pagination: {
                        more: data.more
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        templateResult: formatCliente,
        templateSelection: formatClienteSelection
    });
});

function formatCliente(cliente) {
    if (cliente.loading) return cliente.text;
    return cliente.nombre;  // Solo el nombre
}

function formatClienteSelection(cliente) {
    return cliente.nombre || cliente.text;  // Solo el nombre seleccionado
}

function calcularPrecioFinal() {
    const precioNormal = parseFloat($('#precio_normal').val()) || 0;
    const descuento = parseFloat($('#descuento').val()) || 0;
    const precioFinal = precioNormal - descuento;
    
    if (precioFinal >= 0) {
        $('#precio_final').val(precioFinal.toFixed(2));
    } else {
        $('#precio_final').val(0);
        alert('El descuento no puede ser mayor al precio normal');
    }
}

$(document).ready(function() {
    $('#precio_normal, #descuento').on('input', calcularPrecioFinal);
});