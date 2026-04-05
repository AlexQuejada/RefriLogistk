<?php $activePage = 'ordenes'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Orden de Servicio</h4>
            </div>
            <div class="card-body">
                <form action="/RefriLogistk/public/ordenes/editar/<?= $orden['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Cliente *</label>
                        <select name="cliente_id" class="form-control" required>
                            <option value="">Seleccione un cliente</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $orden['cliente_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cliente['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción del trabajo *</label>
                        <textarea name="descripcion" class="form-control" rows="3" required><?= htmlspecialchars($orden['descripcion']) ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha *</label>
                                <input type="date" name="fecha" class="form-control" value="<?= $orden['fecha'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Costo ($)</label>
                                <input type="number" step="0.01" name="costo" class="form-control" value="<?= $orden['costo'] ?>" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/RefriLogistk/public/ordenes" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Actualizar Orden
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>