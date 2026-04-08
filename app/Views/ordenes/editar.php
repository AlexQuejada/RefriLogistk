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
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha y hora del servicio</label>
                            <input type="datetime-local" class="form-control" id="fecha" name="fecha" 
                                value="<?= date('Y-m-d\TH:i', strtotime($orden['fecha'] ?? date('Y-m-d H:i'))) ?>" required>
                            <small class="form-text text-muted">Selecciona la fecha y hora programada para el servicio</small>
                        </div>
                        <div class="col-md-4">
                                <label for="precio_normal" class="form-label">Precio normal</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="precio_normal" name="precio_normal" 
                                        value="<?= $orden['precio_normal'] ?? '' ?>">
                                </div>
                                <small class="form-text text-muted">Precio sin descuento</small>
                            </div>
                            <div class="col-md-4">
                                <label for="descuento" class="form-label">Descuento</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="descuento" name="descuento" 
                                        value="<?= $orden['descuento'] ?? '' ?>">
                                </div>
                                <small class="form-text text-muted">Monto a descontar</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="costo" class="form-label">Precio final</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" id="costo" name="costo" 
                                    value="<?= $orden['costo'] ?? '' ?>" required>
                            </div>
                            <small class="form-text text-muted">Total a pagar</small>
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