<?php $activePage = 'reportes'; ?>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-file-alt me-2"></i> Reportes</h1>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Órdenes por Fecha</h5>
                </div>
                <div class="card-body">
                    <p>Genera reportes de órdenes en un rango de fechas específico.</p>
                    <p class="text-muted small">Incluye: resumen de totales, órdenes pendientes, realizadas y canceladas.</p>
                    <a href="/RefriLogistk/public/reportes/ordenes" class="btn btn-primary">
                        <i class="fas fa-chart-line me-1"></i> Generar Reporte
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i> Top Clientes</h5>
                </div>
                <div class="card-body">
                    <p>Ranking de los clientes que más servicios han solicitado.</p>
                    <p class="text-muted small">Ordenados por cantidad de órdenes y total gastado.</p>
                    <a href="/RefriLogistk/public/reportes/clientes-top" class="btn btn-success">
                        <i class="fas fa-chart-line me-1"></i> Ver Top Clientes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Ingresos Mensuales</h5>
                </div>
                <div class="card-body">
                    <p>Visualiza los ingresos mes a mes en gráfico y tabla.</p>
                    <p class="text-muted small">Últimos 12 meses de facturación.</p>
                    <a href="/RefriLogistk/public/reportes/ingresos-mensuales" class="btn btn-info">
                        <i class="fas fa-chart-line me-1"></i> Ver Ingresos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>