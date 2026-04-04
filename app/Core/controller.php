<?php

namespace Core;

abstract class Controller
{
    /**
     * Redirigir a otra URL
     */
    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Renderizar una vista
     */
    protected function view($viewPath, $data = [])
    {
        // Extraer variables para que estén disponibles en la vista
        extract($data);
        
        // Incluir layout y vista
        require_once __DIR__ . "/../Views/layout/header.php";
        require_once __DIR__ . "/../Views/{$viewPath}.php";
        require_once __DIR__ . "/../Views/layout/footer.php";
    }
}