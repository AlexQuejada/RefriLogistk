<?php $activePage = 'clientes'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> Nuevo Cliente</h4>
            </div>
            <div class="card-body">
                <form action="/RefriLogistk/public/clientes/nuevo" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo *</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_cliente" class="form-label">Tipo de cliente</label>
                        <select class="form-select" id="tipo_cliente" name="tipo_cliente" required>
                            <option value="particular" <?= (($cliente['tipo_cliente'] ?? 'particular') == 'particular') ? 'selected' : '' ?>>
                                Particular
                            </option>
                            <option value="inmobiliaria" <?= (($cliente['tipo_cliente'] ?? '') == 'inmobiliaria') ? 'selected' : '' ?>>
                                Inmobiliaria
                            </option>
                        </select>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> 
                            Los clientes inmobiliarios pueden tener múltiples propiedades o contratos.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/RefriLogistk/public/clientes" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>