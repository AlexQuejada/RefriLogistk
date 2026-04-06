<?php $activePage = 'reportes'; ?>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-alt me-2"></i> Reporte de Órdenes</h1>
        <a href="/RefriLogistk/public/reportes" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
    
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i> Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="/RefriLogistk/public/reportes/ordenes" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="<?= $fechaInicio ?>">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="form-control" value="<?= $fechaFin ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Órdenes</h6>
                    <h2 class="mb-0"><?= $resumen['total_ordenes'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Realizadas</h6>
                    <h2 class="mb-0"><?= $resumen['realizadas'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h6 class="card-title">Pendientes</h6>
                    <h2 class="mb-0"><?= $resumen['pendientes'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Ingresos</h6>
                    <h2 class="mb-0">$<?= number_format($resumen['total_ingresos'] ?? 0, 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Detalle de Órdenes</h5>
            <div>
                <a href="/RefriLogistk/public/reportes/ordenes/excel?fecha_inicio=<?= $fechaInicio ?>&fecha_fin=<?= $fechaFin ?>" 
                   class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel me-1"></i> Exportar Excel
                </a>
                <button onclick="window.print()" class="btn btn-sm btn-secondary">
                    <i class="fas fa-print me-1"></i> Imprimir
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($ordenes)): ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-2"></i>
                    <p>No hay órdenes en el rango de fechas seleccionado</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Costo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ordenes as $orden): ?>
                            <tr>
                                <td><?= $orden['id'] ?></td>
                                <td><?= htmlspecialchars($orden['cliente_nombre']) ?></td>
                                <td><?= date('d/m/Y', strtotime($orden['fecha'])) ?></td>
                                <td><?= htmlspecialchars(substr($orden['descripcion'], 0, 50)) ?>...</td>
                                <td><?= $orden['costo'] ? '$' . number_format($orden['costo'], 2) : '-' ?></td>
                                <td>
                                    <?php
                                    $badgeClass = match($orden['estado']) {
                                        'pendiente' => 'bg-warning text-dark',
                                        'realizada' => 'bg-success',
                                        'cancelada' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $orden['estado'] ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>