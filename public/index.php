<?php

// Iniciar sesión para mensajes flash
session_start();

// Autoloader manual (carga las clases automáticamente)
spl_autoload_register(function ($class) {
    $prefix = '';
    $baseDir = __DIR__ . '/../app/';
    
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Importar controladores
use Controllers\ClienteController;

// Obtener la URL solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Limpiar la URL para obtener la ruta
$path = parse_url($requestUri, PHP_URL_PATH);
$path = str_replace('/RefriLogitk/public', '', $path);
$path = trim($path, '/');

// Enrutamiento simple (por ahora)
if ($path === '' || $path === 'index.php') {
    // Página de inicio - listar clientes
    $controller = new ClienteController();
    $controller->index();
    
} elseif ($path === 'clientes') {
    $controller = new ClienteController();
    $controller->index();

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
    
} elseif ($path === 'ordenes/guardar' && $requestMethod === 'POST') {
    $controller = new ClienteController();
    $controller->storeOrden();
    
} elseif (preg_match('/^ordenes\/eliminar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->destroyOrden($matches[1]);
    
} else {
    // 404 - No encontrado
    http_response_code(404);
    echo "404 - Página no encontrada";
}

