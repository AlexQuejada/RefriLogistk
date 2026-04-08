<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-users"></i> Clientes
    </h1>
    <a href="/RefriLogistk/public/clientes/nuevo" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Cliente
    </a>
</div>

<?php if (empty($clientes)): ?>

    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> No hay clientes registrados.
        <a href="/RefriLogistk/public/clientes/nuevo" class="alert-link">
            Agrega tu primer cliente
        </a>
    </div>
<?php else: ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo de cliente</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente['id'] ?></td>
                    <td>
                        <?php if (($cliente['tipo_cliente'] ?? 'particular') == 'particular'): ?>
                            <span class="badge bg-info">
                                <i class="fas fa-user"></i> Particular
                            </span>
                        <?php else: ?>
                            <span class="badge bg-primary">
                                <i class="fas fa-building"></i> Inmobiliaria
                            </span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefono'] ?: '-') ?></td>
                    <td><?= htmlspecialchars($cliente['email'] ?: '-') ?></td>
                    <td class="table-actions">

                        <a href="/RefriLogistk/public/clientes/ver/<?= $cliente['id'] ?>" 
                           class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="/RefriLogistk/public/clientes/editar/<?= $cliente['id'] ?>" 
                           class="btn btn-sm btn-warning" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="/RefriLogistk/public/clientes/eliminar/<?= $cliente['id'] ?>" 
                           class="btn btn-sm btn-danger" title="Eliminar"
                           onclick="return confirm('¿Eliminar este cliente? También se borrarán sus órdenes.')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>