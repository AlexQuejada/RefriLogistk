<?php $activePage = 'clientes'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Cliente</h4>
            </div>
            <div class="card-body">
                <form action="/RefriLogistk/public/clientes/editar/<?= $cliente['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo *</label>
                        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($cliente['telefono']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="2"><?= htmlspecialchars($cliente['direccion']) ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/RefriLogistk/public/clientes/ver/<?= $cliente['id'] ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>