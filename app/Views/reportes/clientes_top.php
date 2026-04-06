<?php $activePage = 'reportes'; ?>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-trophy me-2"></i> Top Clientes</h1>
        <a href="/RefriLogistk/public/reportes" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Clientes</h6>
                    <h2 class="mb-0"><?= count($clientes) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Órdenes</h6>
                    <h2 class="mb-0"><?= array_sum(array_column($clientes, 'total_ordenes')) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Gastado</h6>
                    <h2 class="mb-0">$<?= number_format(array_sum(array_column($clientes, 'total_gastado')), 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Ranking de Clientes</h5>
            <button onclick="window.print()" class="btn btn-sm btn-light">
                <i class="fas fa-print me-1"></i> Imprimir
            </button>
        </div>
        <div class="card-body p-0">
            <?php if (empty($clientes)): ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-2"></i>
                    <p>No hay clientes registrados</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Cliente</th>
                                <th>Contacto</th>
                                <th>Órdenes</th>
                                <th>Total Gastado</th>
                                <th>Promedio por Orden</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $index => $cliente): ?>
                            <tr>
                                <td>
                                    <?php 
                                    $medal = '';
                                    if ($index === 0) $medal = '🥇';
                                    elseif ($index === 1) $medal = '🥈';
                                    elseif ($index === 2) $medal = '🥉';
                                    else $medal = $index + 1;
                                    ?>
                                    <span class="medalla"><?= $medal ?></span>
                                </td>
                                <td><strong><?= htmlspecialchars($cliente['nombre']) ?></strong></td>
                                <td>
                                    <?php if ($cliente['telefono']): ?>
                                        <i class="fas fa-phone text-muted"></i> <?= htmlspecialchars($cliente['telefono']) ?><br>
                                    <?php endif; ?>
                                    <?php if ($cliente['email']): ?>
                                        <i class="fas fa-envelope text-muted"></i> <?= htmlspecialchars($cliente['email']) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= $cliente['total_ordenes'] ?> servicios
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        $<?= number_format($cliente['total_gastado'], 0, ',', '.') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $promedio = $cliente['total_ordenes'] > 0 
                                        ? $cliente['total_gastado'] / $cliente['total_ordenes'] 
                                        : 0;
                                    ?>
                                    $<?= number_format($promedio, 0, ',', '.') ?>
                                </td>
                                <td>
                                    <a href="/RefriLogistk/public/clientes/ver/<?= $cliente['id'] ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Totales:</th>
                                <th><strong><?= array_sum(array_column($clientes, 'total_ordenes')) ?></strong></th>
                                <th><strong>$<?= number_format(array_sum(array_column($clientes, 'total_gastado')), 0, ',', '.') ?></strong></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if (!empty($clientes)): 
        $top5 = array_slice($clientes, 0, 5);
        $nombres = array_map(function($c) { return $c['nombre']; }, $top5);
        $ordenes = array_map(function($c) { return $c['total_ordenes']; }, $top5);
        $gastos = array_map(function($c) { return $c['total_gastado']; }, $top5);
    ?>
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Top 5 Clientes - Comparativa</h5>
        </div>
        <div class="card-body">
            <canvas id="topClientesChart" 
                    data-nombres='<?= json_encode($nombres) ?>'
                    data-ordenes='<?= json_encode($ordenes) ?>'
                    data-gastos='<?= json_encode($gastos) ?>'>
            </canvas>
        </div>
    </div>
    <?php endif; ?>
</div>