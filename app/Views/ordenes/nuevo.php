<?php $activePage = 'ordenes'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Nueva Orden de Servicio</h4>
            </div>
            <div class="card-body">
                <form action="/RefriLogistk/public/ordenes/nuevo" method="POST">
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <small class="form-text text-muted" id="cliente_id" name="cliente_id" required>
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción del trabajo *</label>
                        <textarea name="descripcion" class="form-control" rows="3" required placeholder="Ej: Reparación de nevera, mantenimiento de aire acondicionado..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha *</label>
                                <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Costo ($)</label>
                                <input type="number" step="0.01" name="costo" class="form-control" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="/RefriLogistk/public/ordenes" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Guardar Orden
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>