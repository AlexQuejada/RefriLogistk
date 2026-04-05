<?php $activePage = 'clientes'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user"></i> <?= htmlspecialchars($cliente['nombre']) ?></h1>
    <a href="/RefriLogistk/public/clientes" class="btn btn-secondary">← Volver</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5>Información de Contacto</h5>
            </div>
            <div class="card-body">
                <p><strong>📞 Teléfono:</strong> <?= htmlspecialchars($cliente['telefono'] ?: 'No especificado') ?></p>
                <p><strong>✉️ Email:</strong> <?= htmlspecialchars($cliente['email'] ?: 'No especificado') ?></p>
                <p><strong>📍 Dirección:</strong> <?= htmlspecialchars($cliente['direccion'] ?: 'No especificada') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h3>$<?= number_format($cliente['total_gastado'] ?? 0, 2) ?></h3>
                <p>Total gastado</p>
                <hr>
                <h4><?= $cliente['total_ordenes'] ?? 0 ?></h4>
                <p>Trabajos realizados</p>
            </div>
        </div>
    </div>
</div>

<h2>Historial de Trabajos</h2>
<div class="alert alert-info">
    Próximamente: historial de órdenes de servicio
</div>