<?php $activePage = 'calendario'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-alt"></i> Calendario de Servicios</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgendar">
        <i class="fas fa-plus"></i> Agendar Servicio
    </button>
</div>


<div class="row mb-4">
    <div class="col-md-3 mb-2">
        <div class="card bg-warning text-dark card-stats">
            <div class="card-body">
                <h5 class="card-title">Pendientes</h5>
                <h2 class="mb-0"><?= $estadisticas['pendientes'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <div class="card bg-success text-white card-stats">
            <div class="card-body">
                <h5 class="card-title">Realizadas</h5>
                <h2 class="mb-0"><?= $estadisticas['realizadas'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <div class="card bg-danger text-white card-stats">
            <div class="card-body">
                <h5 class="card-title">Canceladas</h5>
                <h2 class="mb-0"><?= $estadisticas['canceladas'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <div class="card bg-info text-white card-stats">
            <div class="card-body">
                <h5 class="card-title">Para hoy</h5>
                <h2 class="mb-0"><?= $estadisticas['hoy'] ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="leyenda-calendario">
    <div class="leyenda-item">
        <div class="leyenda-color pendiente"></div>
        <span>Pendiente</span>
    </div>
    <div class="leyenda-item">
        <div class="leyenda-color realizada"></div>
        <span>Realizada</span>
    </div>
    <div class="leyenda-item">
        <div class="leyenda-color cancelada"></div>
        <span>Cancelada</span>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-week"></i> Calendario</h5>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-week"></i> Calendario</h5>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Próximos Servicios</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($pendientes)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-check-circle fa-3x mb-2"></i>
                        <p>No hay servicios pendientes</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($pendientes as $orden): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?= htmlspecialchars($orden['cliente_nombre']) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars(substr($orden['descripcion'], 0, 40)) ?>...</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-warning text-dark">
                                            <?= date('d/m/Y', strtotime($orden['fecha'])) ?>
                                        </span>
                                        <form action="/RefriLogistk/public/calendario/cambiar-estado/<?= $orden['id'] ?>" method="POST" class="mt-2">
                                            <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="pendiente" <?= $orden['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                <option value="realizada" <?= $orden['estado'] === 'realizada' ? 'selected' : '' ?>>Realizada</option>
                                                <option value="cancelada" <?= $orden['estado'] === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalAgendar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Agendar Servicio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/RefriLogistk/public/calendario/agendar" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Cliente *</label>
                        <select name="cliente_id" class="form-control" required>
                            <option value="">Seleccione un cliente</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha *</label>
                        <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <textarea name="descripcion" class="form-control" rows="3" required placeholder="Ej: Reparación de nevera, mantenimiento..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Costo ($)</label>
                        <input type="number" step="0.01" name="costo" class="form-control" placeholder="0.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agendar</button>
                </div>
            </form>
        </div>
    </div>
</div>


