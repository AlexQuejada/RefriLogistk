<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


spl_autoload_register(function ($class) {

    $baseDir = __DIR__ . '/../app/';

    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});


use Controllers\ClienteController;
use Controllers\OrdenController;
use Controllers\DashboardController;
use Controllers\CalendarioController;
use Controllers\ReporteController;
use Controllers\AuthController;

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$path = parse_url($requestUri, PHP_URL_PATH);
$basePath = '/RefriLogistk/public';

if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}
$path = trim($path, '/');


$publicRoutes = ['login', 'logout'];

if (in_array($path, $publicRoutes) || $path === '') {
    if ($path === 'login') {
        $controller = new AuthController();
        if ($requestMethod === 'POST') {
            $controller->authenticate();
        } else {
            $controller->login();
        }
        exit;
    }
    
    if ($path === 'logout') {
        $controller = new AuthController();
        $controller->logout();
        exit;
    }
    
    if ($path === '') {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /RefriLogistk/public/login');
            exit;
        } else {
            $controller = new DashboardController();
            $controller->index();
            exit;
        }
    }
}


if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Debe iniciar sesión para acceder a esta página';
    header('Location: /RefriLogistk/public/login');
    exit;
}

if ($path === 'dashboard') {
    $controller = new DashboardController();
    $controller->index();
    
} elseif ($path === 'clientes') {
    $controller = new ClienteController();
    $controller->index();
    
} elseif ($path === 'clientes/buscar' && $requestMethod === 'GET') {
    $controller = new ClienteController();
    $controller->buscar();

} elseif ($path === 'clientes/nuevo') {
    $controller = new ClienteController();

    if ($requestMethod === 'POST') {
        $controller->store();
    } else {
        $controller->create();
    }
    
} elseif (preg_match('/^clientes\/ver\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->show($matches[1]);
    
} elseif (preg_match('/^clientes\/editar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();

    if ($requestMethod === 'POST') {
        $controller->update($matches[1]);
    } else {
        $controller->edit($matches[1]);
    }
    
} elseif (preg_match('/^clientes\/eliminar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->destroy($matches[1]);
    
} elseif ($path === 'ordenes/cambiar-estado' && $requestMethod === 'POST') {
    $controller = new OrdenController();
    $controller->cambiarEstado();

} elseif ($path === 'ordenes') {
    $controller = new OrdenController();
    $controller->index();
    
} elseif ($path === 'ordenes/nuevo') {
    $controller = new OrdenController();
    if ($requestMethod === 'POST') {
        $controller->store();
    } else {
        $controller->create();
    }
    
} elseif (preg_match('/^ordenes\/ver\/(\d+)$/', $path, $matches)) {
    $controller = new OrdenController();
    $controller->show($matches[1]);
    
} elseif (preg_match('/^ordenes\/editar\/(\d+)$/', $path, $matches)) {
    $controller = new OrdenController();
    if ($requestMethod === 'POST') {
        $controller->update($matches[1]);
    } else {
        $controller->edit($matches[1]);
    }
    
} elseif (preg_match('/^ordenes\/eliminar\/(\d+)$/', $path, $matches)) {
    $controller = new OrdenController();
    $controller->destroy($matches[1]);
    
} elseif ($path === 'ordenes/guardar' && $requestMethod === 'POST') {
    $controller = new ClienteController();
    $controller->storeOrden();
    
} elseif ($path === 'calendario') {
    $controller = new CalendarioController();
    $controller->index();
    
} elseif ($path === 'calendario/eventos') {
    $controller = new CalendarioController();
    $controller->eventos();
    
} elseif ($path === 'calendario/agendar' && $requestMethod === 'POST') {
    $controller = new CalendarioController();
    $controller->agendar();
    
} elseif (preg_match('/^calendario\/cambiar-estado\/(\d+)$/', $path, $matches) && $requestMethod === 'POST') {
    $controller = new CalendarioController();
    $controller->cambiarEstado($matches[1]);
    
} elseif ($path === 'reportes') {
    $controller = new ReporteController();
    $controller->index();
    
} elseif ($path === 'reportes/ordenes') {
    $controller = new ReporteController();
    $controller->ordenes();
    
} elseif ($path === 'reportes/ordenes/excel') {
    $controller = new ReporteController();
    $controller->excel();
    
} elseif ($path === 'reportes/clientes-top') {
    $controller = new ReporteController();
    $controller->clientesTop();
    
} elseif ($path === 'reportes/ingresos-mensuales') {
    $controller = new ReporteController();
    $controller->ingresosMensuales();
    
} elseif ($path === 'perfil') {
    $controller = new AuthController();
    $controller->perfil();
    
} elseif ($path === 'perfil/actualizar' && $requestMethod === 'POST') {
    $controller = new AuthController();
    $controller->updatePerfil();
    
} elseif ($path === 'perfil/cambiar-password' && $requestMethod === 'POST') {
    $controller = new AuthController();
    $controller->cambiarPassword();
    
} else {

    http_response_code(404);
    echo "<h1>404 - Página no encontrada</h1>";
    echo "<p>Ruta solicitada: /{$path}</p>";
    echo "<p><a href='/RefriLogistk/public/dashboard'>Ir al Dashboard</a></p>";
}