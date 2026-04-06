<?php $activePage = 'dashboard'; 

$meses = [
    1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
    5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
];
$mesActual = $meses[(int)date('n')];
?>


<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Clientes</h6>
                        <h2 class="mb-0"><?= $totalClientes ?></h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
                <small class="mt-2 d-block">Total de clientes registrados</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Órdenes este mes</h6>
                        <h2 class="mb-0"><?= $ordenesMes ?></h2>
                    </div>
                    <i class="fas fa-tools fa-3x opacity-50"></i>
                </div>
                <small class="mt-2 d-block">Servicios realizados en <?= $mesActual ?></small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Ingresos del mes</h6>
                        <h2 class="mb-0">$<?= number_format($ingresosMes, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                </div>
                <small class="mt-2 d-block">Total facturado este mes</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Órdenes hoy</h6>
                        <h2 class="mb-0"><?= $ordenesHoy ?></h2>
                    </div>
                    <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                </div>
                <small class="mt-2 d-block">Servicios programados para hoy</small>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Servicios por Mes</h5>
    </div>
    <div class="card-body">
        <canvas id="serviciosChart" 
                height="80"
                data-meses='<?= json_encode(array_column($datosGrafico, 'mes')) ?>'
                data-cantidades='<?= json_encode(array_column($datosGrafico, 'cantidad')) ?>'>
        </canvas>
    </div>
</div>


<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i> Últimas Órdenes</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($ultimasOrdenes)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-2"></i>
                        <p>No hay órdenes registradas</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Fecha</th>
                                    <th>Costo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ultimasOrdenes as $orden): ?>
                                <tr onclick="window.location='/RefriLogistk/public/ordenes/ver/<?= $orden['id'] ?>'" style="cursor: pointer;">
                                    <td><?= htmlspecialchars($orden['cliente_nombre']) ?></td>
                                    <td><?= htmlspecialchars(substr($orden['descripcion'], 0, 30)) ?>...</td>
                                    <td><?= date('d/m/Y', strtotime($orden['fecha'])) ?></td>
                                    <td>$<?= number_format($orden['costo'] ?? 0, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-transparent">
                <a href="/RefriLogistk/public/ordenes" class="btn btn-sm btn-primary">
                    Ver todas las órdenes <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Próximos Servicios</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($proximosServicios)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-calendar-check fa-3x mb-2"></i>
                        <p>No hay servicios programados</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($proximosServicios as $servicio): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($servicio['cliente_nombre']) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars(substr($servicio['descripcion'], 0, 40)) ?>...</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($servicio['fecha'])) ?>
                                        </span>
                                        <br>
                                        <small class="text-muted">Tel: <?= htmlspecialchars($servicio['telefono'] ?: '—') ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


