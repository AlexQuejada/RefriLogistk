document.addEventListener('DOMContentLoaded', function() {
    
    const topClientesCanvas = document.getElementById('topClientesChart');
    
    if (topClientesCanvas && topClientesCanvas.dataset.nombres) {
        const nombres = JSON.parse(topClientesCanvas.dataset.nombres || '[]');
        const ordenes = JSON.parse(topClientesCanvas.dataset.ordenes || '[]');
        const gastos = JSON.parse(topClientesCanvas.dataset.gastos || '[]');
        
        if (nombres.length > 0) {
            const ctx = topClientesCanvas.getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombres,
                    datasets: [
                        {
                            label: 'Cantidad de Órdenes',
                            data: ordenes,
                            backgroundColor: 'rgba(13, 110, 253, 0.7)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 1,
                            yAxisID: 'y',
                            borderRadius: 8
                        },
                        {
                            label: 'Total Gastado ($)',
                            data: gastos,
                            backgroundColor: 'rgba(25, 135, 84, 0.7)',
                            borderColor: 'rgba(25, 135, 84, 1)',
                            borderWidth: 1,
                            yAxisID: 'y1',
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = context.raw;
                                    if (context.dataset.label === 'Total Gastado ($)') {
                                        return `${label}: $${value.toLocaleString()}`;
                                    }
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Cantidad de Órdenes' },
                            ticks: { stepSize: 1 }
                        },
                        y1: {
                            position: 'right',
                            beginAtZero: true,
                            title: { display: true, text: 'Total Gastado ($)' },
                            grid: { drawOnChartArea: false }
                        }
                    }
                }
            });
        }
    }
    
    const ingresosCanvas = document.getElementById('ingresosChart');
    
    if (ingresosCanvas && ingresosCanvas.dataset.meses) {
        const meses = JSON.parse(ingresosCanvas.dataset.meses || '[]');
        const cantidades = JSON.parse(ingresosCanvas.dataset.cantidades || '[]');
        const ingresos = JSON.parse(ingresosCanvas.dataset.ingresos || '[]');
        
        if (meses.length > 0) {
            const ctx = ingresosCanvas.getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [
                        {
                            label: 'Cantidad de Servicios',
                            data: cantidades,
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            yAxisID: 'y',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Ingresos ($)',
                            data: ingresos,
                            backgroundColor: 'rgba(25, 135, 84, 0.1)',
                            borderColor: 'rgba(25, 135, 84, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            yAxisID: 'y1',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = context.raw;
                                    if (context.dataset.label === 'Ingresos ($)') {
                                        return `${label}: $${value.toLocaleString()}`;
                                    }
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Cantidad de Servicios' },
                            ticks: { stepSize: 1 }
                        },
                        y1: {
                            position: 'right',
                            beginAtZero: true,
                            title: { display: true, text: 'Ingresos ($)' },
                            grid: { drawOnChartArea: false }
                        }
                    }
                }
            });
        }
    }
});