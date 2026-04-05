<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'RefriLogistik' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="/RefriLogistk/public/assets/image/icono-refrites.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/RefriLogistk/public/css/app.css">

    
    
</head>
<body>


    <nav class="top-navbar">
        <div class="d-flex justify-content-between align-items-center h-100">
            <div class="d-flex align-items-center">
                
                <button class="btn text-white ms-3 d-md-none" id="sidebarToggle" style="background: transparent; border: none;">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <a class="navbar-brand" href="/RefriLogistk/public/">
                    <i class="fas fa-snowflake"></i>
                    RefriLogistik
                </a>
            </div>
            <div class="d-flex align-items-center me-4">
                <div class="dropdown">
                    <button class="btn text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" style="background: transparent; border: none;">
                        <i class="fas fa-user-circle fa-lg me-2"></i>
                        Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <ul class="list-unstyled">
                <li class="sidebar-item">
                    <a class="sidebar-link <?= $activePage === 'dashboard' ? 'active' : '' ?>" href="/RefriLogistk/public/">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= $activePage === 'clientes' ? 'active' : '' ?>" href="/RefriLogistk/public/clientes">
                        <i class="fas fa-users"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= $activePage === 'ordenes' ? 'active' : '' ?>" href="#">
                        <i class="fas fa-tools"></i>
                        <span>Órdenes de Servicio</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= $activePage === 'calendario' ? 'active' : '' ?>" href="#">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Calendario</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= $activePage === 'reportes' ? 'active' : '' ?>" href="#">
                        <i class="fas fa-file-alt"></i>
                        <span>Reportes</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-divider"></div>
            
            <ul class="list-unstyled">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-cog"></i>
                        <span>Configuración</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link text-danger" href="#">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Salir</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="sidebar-footer">
            <small class="text-muted">
                <i class="fas fa-code-branch"></i> v1.0.0
            </small>
        </div>
    </div>

    <main class="main-content">
        

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>