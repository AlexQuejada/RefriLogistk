<?php $activePage = 'reportes'; ?>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-chart-line me-2"></i> Ingresos Mensuales</h1>
        <a href="/RefriLogistk/public/reportes" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Período</h6>
                    <h2 class="mb-0"><?= count($ingresos) ?> meses</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Servicios</h6>
                    <h2 class="mb-0"><?= array_sum(array_column($ingresos, 'cantidad')) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Ingresos</h6>
                    <h2 class="mb-0">$<?= number_format(array_sum(array_column($ingresos, 'ingresos')), 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h6 class="card-title">Promedio Mensual</h6>
                    <h2 class="mb-0">$<?= number_format(array_sum(array_column($ingresos, 'ingresos')) / max(1, count($ingresos)), 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Evolución Mensual</h5>
        </div>
        <div class="card-body">
            <canvas id="ingresosChart" 
                    data-meses='<?= json_encode(array_column($ingresos, 'mes')) ?>'
                    data-cantidades='<?= json_encode(array_column($ingresos, 'cantidad')) ?>'
                    data-ingresos='<?= json_encode(array_column($ingresos, 'ingresos')) ?>'>
            </canvas>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i> Datos Mensuales</h5>
            <button onclick="window.print()" class="btn btn-sm btn-light">
                <i class="fas fa-print me-1"></i> Imprimir
            </button>
        </div>
        <div class="card-body p-0">
            <?php if (empty($ingresos)): ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-2"></i>
                    <p>No hay datos de ingresos disponibles</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mes</th>
                                <th>Servicios</th>
                                <th>Ingresos</th>
                                <th>Promedio por Servicio</th>
                                <th>% del Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalIngresos = array_sum(array_column($ingresos, 'ingresos'));
                            foreach ($ingresos as $item): 
                                $porcentaje = $totalIngresos > 0 ? ($item['ingresos'] / $totalIngresos) * 100 : 0;
                                $promedio = $item['cantidad'] > 0 ? $item['ingresos'] / $item['cantidad'] : 0;
                            ?>
                            <tr>
                                <td><strong><?= $item['mes'] ?></strong></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= $item['cantidad'] ?> servicios
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        $<?= number_format($item['ingresos'], 0, ',', '.') ?>
                                    </span>
                                </td>
                                <td>$<?= number_format($promedio, 0, ',', '.') ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px; width: 100px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $porcentaje ?>%"></div>
                                        </div>
                                        <span class="small"><?= number_format($porcentaje, 1) ?>%</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th><strong>Totales</strong></th>
                                <th><strong><?= array_sum(array_column($ingresos, 'cantidad')) ?></strong></th>
                                <th><strong>$<?= number_format($totalIngresos, 0, ',', '.') ?></strong></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>