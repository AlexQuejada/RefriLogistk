<?php

namespace Core;

abstract class Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function view($viewPath, $data = [])
    {
        extract($data);

        $headerFile = __DIR__ . "/../Views/layout/header.php";
        $viewFile = __DIR__ . "/../Views/{$viewPath}.php";
        $footerFile = __DIR__ . "/../Views/layout/footer.php";

        if (!file_exists($headerFile)) {
            die("ERROR: No se encuentra header.php en: " . $headerFile);
        }
        
        if (!file_exists($viewFile)) {
            die("ERROR: No se encuentra la vista: " . $viewFile);
        }
        
        if (!file_exists($footerFile)) {
            die("ERROR: No se encuentra footer.php en: " . $footerFile);
        }

        require_once $headerFile;
        require_once $viewFile;
        require_once $footerFile;
    }
    
    protected function requireAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Debe iniciar sesión';
            $this->redirect('/RefriLogistk/public/login');
        }
    }
}