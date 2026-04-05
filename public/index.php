<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


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

// Limpiar la URL - ajusta 'RefriLogistk' al nombre exacto de tu carpeta
$path = parse_url($requestUri, PHP_URL_PATH);
$basePath = '/RefriLogistk/public';

if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}
$path = trim($path, '/');

echo "<!-- Debug: path = '{$path}' -->";

// ============================================
// ENRUTADOR - Director de tráfico
// ============================================

// Página de inicio / Dashboard
if ($path === '' || $path === 'index.php') {

    $controller = new ClienteController();
    $controller->index();
    
// Listado de clientes
} elseif ($path === 'clientes') {
    $controller = new ClienteController();
    $controller->index();
    
// Formulario nuevo cliente
} elseif ($path === 'clientes/nuevo') {
    $controller = new ClienteController();

    if ($requestMethod === 'POST') {
        $controller->store();
    } else {
        $controller->create();
    }
    
// Ver detalle de cliente
} elseif (preg_match('/^clientes\/ver\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->show($matches[1]);
    
// Editar cliente
} elseif (preg_match('/^clientes\/editar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();

    if ($requestMethod === 'POST') {
        $controller->update($matches[1]);
    } else {
        $controller->edit($matches[1]);
    }
    
// Eliminar cliente
} elseif (preg_match('/^clientes\/eliminar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->destroy($matches[1]);
    
// Guardar orden (POST)
} elseif ($path === 'ordenes/guardar' && $requestMethod === 'POST') {
    $controller = new ClienteController();
    $controller->storeOrden();
    
// Eliminar orden
} elseif (preg_match('/^ordenes\/eliminar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->destroyOrden($matches[1]);
    
// Si no existe la ruta -> 404
} else {

    http_response_code(404);
    echo "<h1>404 - Página no encontrada</h1>";
    echo "<p>La ruta solicitada no existe: /{$path}</p>";
    echo "<p><a href='/RefriLogistk/public/clientes'>Ir a Clientes</a></p>";}