document.addEventListener('DOMContentLoaded', function() {

    const canvas = document.getElementById('serviciosChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    const meses = JSON.parse(canvas.dataset.meses || '[]');
    const cantidades = JSON.parse(canvas.dataset.cantidades || '[]');
    
    if (meses.length === 0 || cantidades.length === 0) {
        console.log('No hay datos para el gráfico');
        return;
    }
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Cantidad de servicios',
                data: cantidades,
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Servicios: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});

window.addEventListener('resize', function() {
    if (window.chart) {
        window.chart.resize();
    }
});