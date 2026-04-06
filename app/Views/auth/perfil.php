<?php $activePage = 'perfil'; ?>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-user-circle me-2"></i> Mi Perfil</h1>
        <a href="/RefriLogistk/public/dashboard" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                    <h4><?= htmlspecialchars($usuario['nombre']) ?></h4>
                    <p class="text-muted">@<?= htmlspecialchars($usuario['username']) ?></p>
                    <span class="badge bg-primary"><?= $usuario['rol'] === 'admin' ? 'Administrador' : 'Usuario' ?></span>
                    <hr>
                    <small class="text-muted">
                        Último acceso: <?= $usuario['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acceso'])) : 'Nunca' ?>
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Información</h5>
                </div>
                <div class="card-body">
                    <form action="/RefriLogistk/public/perfil/actualizar" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['username']) ?>" disabled>
                            <small class="text-muted">El nombre de usuario no se puede cambiar</small>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar Perfil
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-key me-2"></i> Cambiar Contraseña</h5>
                </div>
                <div class="card-body">
                    <form action="/RefriLogistk/public/perfil/cambiar-password" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Contraseña actual</label>
                            <input type="password" name="password_actual" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input type="password" name="password_nueva" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" name="password_confirmar" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i> Cambiar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>