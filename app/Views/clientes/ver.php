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
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($cliente['telefono'] ?: 'No especificado') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($cliente['email'] ?: 'No especificado') ?></p>
                <p><strong>Dirección:</strong> <?= htmlspecialchars($cliente['direccion'] ?: 'No especificada') ?></p>
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

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Agregar nuevo trabajo</h5>
    </div>
    <div class="card-body">
        <form action="/RefriLogistk/public/ordenes/guardar" method="POST">
            <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Descripción del trabajo</label>
                    <input type="text" name="descripcion" class="form-control" placeholder="Ej: Reparación de nevera" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Costo ($)</label>
                    <input type="number" step="0.01" name="costo" class="form-control" placeholder="0.00">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Agregar orden
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Listado de órdenes existentes -->
<h2><i class="fas fa-history"></i> Historial de Trabajos</h2>

<?php if (empty($ordenes)): ?>
    <div class="alert alert-warning text-center">
        <i class="fas fa-info-circle"></i> No hay trabajos registrados para este cliente.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Trabajo realizado</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordenes as $orden): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($orden['fecha'])) ?></td>
                    <td><?= htmlspecialchars($orden['descripcion']) ?></td>
                    <td><?= $orden['costo'] ? '$' . number_format($orden['costo'], 2) : '-' ?></td>
                    <td>
                        <a href="/RefriLogistk/public/ordenes/editar/<?= $orden['id'] ?>" 
                           class="btn btn-sm btn-warning" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/RefriLogistk/public/ordenes/eliminar/<?= $orden['id'] ?>" 
                           class="btn btn-sm btn-danger" title="Eliminar"
                           onclick="return confirm('¿Eliminar este trabajo?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>