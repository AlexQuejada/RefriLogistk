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


use Controllers\ClienteController;
use Controllers\OrdenController;

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

//limpiador Url debuger parcial por silas :3

$path = parse_url($requestUri, PHP_URL_PATH);
$basePath = '/RefriLogistk/public';

if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}
$path = trim($path, '/');

echo "<!-- Debug: path = '{$path}' -->";


//pagina de inicio/dashboar -.-
if ($path === '' || $path === 'index.php') {

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
    

    } elseif (preg_match('/^ordenes\/editar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->editOrden($matches[1]);
    

} elseif (preg_match('/^ordenes\/actualizar\/(\d+)$/', $path, $matches) && $requestMethod === 'POST') {
    $controller = new ClienteController();
    $controller->updateOrden($matches[1]);



} elseif (preg_match('/^ordenes\/eliminar\/(\d+)$/', $path, $matches)) {
    $controller = new ClienteController();
    $controller->destroyOrden($matches[1]);
    

    } elseif ($path === 'ordenes') {
    $controller = new OrdenController();
    $controller->index();
    
// Formulario nueva orden
} elseif ($path === 'ordenes/nuevo') {
    $controller = new OrdenController();
    if ($requestMethod === 'POST') {
        $controller->store();
    } else {
        $controller->create();
    }
    
// Ver detalle de orden
} elseif (preg_match('/^ordenes\/ver\/(\d+)$/', $path, $matches)) {
    $controller = new OrdenController();
    $controller->show($matches[1]);
    
// Editar orden (mostrar formulario)
} elseif (preg_match('/^ordenes\/editar\/(\d+)$/', $path, $matches)) {
    $controller = new OrdenController();
    if ($requestMethod === 'POST') {
        $controller->update($matches[1]);
    } else {
        $controller->edit($matches[1]);
    }
    
// Eliminar orden
} elseif (preg_match('/^ordenes\/eliminar\/(\d+)$/', $path, $matches)) {
    $controller = new OrdenController();
    $controller->destroy($matches[1]);

// Rico y delicioso "404" como busques lo que no hay
} else {

    http_response_code(404);
    echo "<h1>404 - Página no encontrada</h1>";
    echo "<p>La ruta solicitada no existe: /{$path}</p>";
    echo "<p><a href='/RefriLogistk/public/clientes'>Ir a Clientes</a></p>";}