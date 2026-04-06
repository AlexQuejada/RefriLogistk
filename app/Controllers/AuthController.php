<?php

namespace Controllers;

use Core\Controller;
use Models\Usuario;

class AuthController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new Usuario();
    }

    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/RefriLogistk/public/dashboard');
        }
        
        $viewFile = __DIR__ . "/../Views/auth/login.php";
        
        if (!file_exists($viewFile)) {
            die("ERROR: No se encuentra la vista de login");
        }
        
        require_once $viewFile;
        exit;
    }

    public function authenticate()
    {
        // DEBUG temporal - revisa el log después de intentar login
        error_log("=== INTENTO DE LOGIN ===");
        error_log("POST: " . print_r($_POST, true));
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/login');
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            error_log("ERROR: Campos vacíos");
            $_SESSION['error'] = 'Por favor complete todos los campos';
            $this->redirect('/RefriLogistk/public/login');
        }

        error_log("Buscando usuario: " . $username);
        $usuario = $this->usuarioModel->findByUsername($username);
        
        if (!$usuario) {
            error_log("Usuario NO encontrado: " . $username);
            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            $this->redirect('/RefriLogistk/public/login');
        }
        
        error_log("Usuario encontrado, verificando contraseña...");
        
        if (!password_verify($password, $usuario['password'])) {
            error_log("Contraseña INCORRECTA para: " . $username);
            error_log("Hash en BD: " . $usuario['password']);
            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            $this->redirect('/RefriLogistk/public/login');
        }

        error_log(" LOGIN EXITOSO para: " . $username);

        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_nombre'] = $usuario['nombre'];
        $_SESSION['user_username'] = $usuario['username'];
        $_SESSION['user_rol'] = $usuario['rol'];
        
        $this->usuarioModel->updateUltimoAcceso($usuario['id']);
        
        $_SESSION['success'] = 'Bienvenido ' . $usuario['nombre'];
        $this->redirect('/RefriLogistk/public/dashboard');
    }

    public function logout()
    {
        session_destroy();
        $_SESSION = [];
        $this->redirect('/RefriLogistk/public/login');
    }

    public function perfil()
    {
        $this->requireAuth();
        
        $usuario = $this->usuarioModel->find($_SESSION['user_id']);
        
        $this->view('auth/perfil', [
            'title' => 'Mi Perfil',
            'usuario' => $usuario
        ]);
    }

    public function updatePerfil()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/perfil');
        }

        $result = $this->usuarioModel->updatePerfil($_SESSION['user_id'], $_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Perfil actualizado correctamente';
            $_SESSION['user_nombre'] = $_POST['nombre'];
        } else {
            $_SESSION['error'] = 'Error al actualizar el perfil';
        }
        
        $this->redirect('/RefriLogistk/public/perfil');
    }

    public function cambiarPassword()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/RefriLogistk/public/perfil');
        }

        $passwordActual = $_POST['password_actual'] ?? '';
        $passwordNueva = $_POST['password_nueva'] ?? '';
        $passwordConfirmar = $_POST['password_confirmar'] ?? '';

        if (empty($passwordActual) || empty($passwordNueva) || empty($passwordConfirmar)) {
            $_SESSION['error'] = 'Complete todos los campos';
            $this->redirect('/RefriLogistk/public/perfil');
        }

        if ($passwordNueva !== $passwordConfirmar) {
            $_SESSION['error'] = 'Las contraseñas nuevas no coinciden';
            $this->redirect('/RefriLogistk/public/perfil');
        }

        $result = $this->usuarioModel->cambiarPassword($_SESSION['user_id'], $passwordActual, $passwordNueva);
        
        if ($result) {
            $_SESSION['success'] = 'Contraseña actualizada correctamente';
        } else {
            $_SESSION['error'] = 'Contraseña actual incorrecta';
        }
        
        $this->redirect('/RefriLogistk/public/perfil');
    }
}