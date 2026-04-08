<?php $activePage = 'ordenes'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-file-alt"></i> Detalle de Orden</h1>
    <a href="/RefriLogistk/public/ordenes" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información de la Orden</h5>
            </div>
            <div class="card-body">
                <p><strong>Descripción:</strong></p>
                <p><?= nl2br(htmlspecialchars($orden['descripcion'])) ?></p>
                <hr>
                <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($orden['fecha'])) ?></p>
                <p><strong>Precio normal:</strong> $<?= number_format($orden['precio_normal'] ?? 0, 2) ?></p>
                <p> <strong>Descuento:</strong> <span class="text-success">-$<?= number_format($orden['descuento'] ?? 0, 2) ?></span></p>
                <p><strong>Precio final:</strong> <span class="fw-bold">$<?= number_format($orden['costo'] ?? 0, 2) ?></span></p>
                <p><strong>Costo:</strong> <?= $orden['costo'] ? '$' . number_format($orden['costo'], 2) : 'No especificado' ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-user"></i> Cliente</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> <?= htmlspecialchars($orden['cliente_nombre']) ?></p>
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($orden['telefono'] ?: 'No especificado') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($orden['email'] ?: 'No especificado') ?></p>
                <a href="/RefriLogistk/public/clientes/ver/<?= $orden['cliente_id'] ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i> Ver cliente
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="fas fa-cog"></i> Acciones</h5>
            </div>
            <div class="card-body">
                <a href="/RefriLogistk/public/ordenes/editar/<?= $orden['id'] ?>" class="btn btn-warning w-100 mb-2">
                    <i class="fas fa-edit"></i> Editar orden
                </a>
                <a href="/RefriLogistk/public/ordenes/eliminar/<?= $orden['id'] ?>" 
                   class="btn btn-danger w-100"
                   onclick="return confirm('¿Eliminar esta orden?')">
                    <i class="fas fa-trash"></i> Eliminar orden
                </a>
            </div>
        </div>
    </div>
</div>