document.addEventListener('DOMContentLoaded', function() {
    
    const canvas = document.getElementById('serviciosChart');
    if (!canvas) return;
    if (canvas) {
        const meses = JSON.parse(canvas.dataset.meses || '[]');
        const cantidades = JSON.parse(canvas.dataset.cantidades || '[]');
        
        if (meses.length > 0 && cantidades.length > 0) {
            const ctx = canvas.getContext('2d');
            
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
                        legend: { position: 'top' },
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
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
    }
    
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            const url = this.dataset.url;
            if (url) window.location.href = url;
        });
    });
});


window.addEventListener('resize', function() {
    if (window.chart) {
        window.chart.resize();}
    });