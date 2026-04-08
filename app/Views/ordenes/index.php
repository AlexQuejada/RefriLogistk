<?php $activePage = 'ordenes'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tools"></i> Órdenes de Servicio</h1>
    <a href="/RefriLogistk/public/ordenes/nuevo" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nueva Orden
    </a>
</div>

<?php if (empty($ordenes)): ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> No hay órdenes de servicio registradas.
        <a href="/RefriLogistk/public/ordenes/nuevo" class="alert-link">Crea la primera orden</a>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Costo</th>
                    <th>Estado</th>        
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordenes as $orden): ?>
                <tr>
                    <td><?= $orden['id'] ?></td>
                    <td>
                        <a href="/RefriLogistk/public/clientes/ver/<?= $orden['cliente_id'] ?>">
                            <?= htmlspecialchars($orden['cliente_nombre']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars(substr($orden['descripcion'], 0, 50)) ?><?= strlen($orden['descripcion']) > 50 ? '...' : '' ?></td>
                    <td><?= date('d/m/Y', strtotime($orden['fecha'])) ?></td>
                    <td><?= $orden['costo'] ? '$' . number_format($orden['costo'], 2) : '-' ?></td>
                    <td>
                        <select class="form-select form-select-sm estado-selector d-inline-block w-auto me-1" 
                                data-id="<?= $orden['id'] ?>"
                                style="width: auto; display: inline-block;">
                            <option value="pendiente" <?= ($orden['estado'] ?? 'pendiente') == 'pendiente' ? 'selected' : '' ?>>
                                Pendiente
                            </option>
                            <option value="realizada" <?= ($orden['estado'] ?? '') == 'realizada' ? 'selected' : '' ?>>
                                Realizada
                            </option>
                            <option value="cancelada" <?= ($orden['estado'] ?? '') == 'cancelada' ? 'selected' : '' ?>>
                                Cancelada
                            </option>
                        </select>
                        
                        <button class="btn btn-sm btn-success actualizar-estado me-1" 
                                data-id="<?= $orden['id'] ?>"
                                title="Guardar estado">
                            <i class="fas fa-save"></i>
                        </button>
                        
                        <a href="/RefriLogistk/public/ordenes/ver/<?= $orden['id'] ?>" 
                        class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/RefriLogistk/public/ordenes/editar/<?= $orden['id'] ?>" 
                        class="btn btn-sm btn-warning" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/RefriLogistk/public/ordenes/eliminar/<?= $orden['id'] ?>" 
                        class="btn btn-sm btn-danger" title="Eliminar"
                        onclick="return confirm('¿Eliminar esta orden?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>