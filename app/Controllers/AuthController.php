<?php
namespace App\Controllers;

use App\Models\Usuario;
use App\Core\View; 
use App\Models\Model; // Se recomienda si tu Usuario hereda de Model
use App\Core\Database; // Se recomienda si tu Usuario usa Database

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__, 2) . '/config.php';

class AuthController {

    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario(); 
    }

    /**
     * Muestra el formulario de inicio de sesión (Usando Vista).
     */
    public function login() {
        if (isset($_SESSION['user_role'])) {
            $redirect = ($_SESSION['user_role'] === ROL_ADMIN) ? 'admin/dashboard' : 'client/catalogo';
            header('Location: ' . BASE_URL . $redirect);
            exit;
        }

        $error = $_SESSION['error'] ?? '';
        $success = $_SESSION['login_success'] ?? '';
        unset($_SESSION['error']);
        unset($_SESSION['login_success']);

        View::render('auth/login', [
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Procesa el formulario de inicio de sesión.
     */
    public function loginSubmit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->usuarioModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol']; 

            $redirect = ($user['rol'] === ROL_ADMIN) ? 'admin/dashboard' : 'client/catalogo';
            header('Location: ' . BASE_URL . $redirect);
            exit;
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas.';
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset(); 
            session_destroy(); 
        }
        header('Location: ' . BASE_URL . 'client/catalogo');
        exit;
    }

    /**
     * Muestra el formulario de registro (Usando Vista).
     */
    public function register() {
        if (isset($_SESSION['user_role'])) {
            header('Location: ' . BASE_URL . 'client/catalogo');
            exit;
        }

        $error = $_SESSION['register_error'] ?? '';
        unset($_SESSION['register_error']);
        
        View::render('auth/register', [
            'error' => $error,
        ]);
    }

    /**
    * Procesa el formulario de registro, valida y guarda al nuevo usuario.
    */
    public function registerSubmit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth/register');
            exit;
        }

        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if (empty($nombre) || empty($email) || empty($password)) {
            $_SESSION['register_error'] = 'Todos los campos son obligatorios.';
            header('Location: ' . BASE_URL . 'auth/register');
            exit;
        }

        if ($password !== $password_confirm) {
            $_SESSION['register_error'] = 'Las contraseñas no coinciden.';
            header('Location: ' . BASE_URL . 'auth/register');
            exit;
        }

        if ($this->usuarioModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'El email ya está registrado.';
            header('Location: ' . BASE_URL . 'auth/register');
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'nombre' => $nombre,
            'email' => $email,
            'password' => $hashed_password,
            'rol' => ROL_CLIENTE
        ];

        if ($this->usuarioModel->insert($data)) {
            $_SESSION['login_success'] = '¡Registro exitoso! Por favor, inicia sesión.';
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        } else {
            $_SESSION['register_error'] = 'Error al guardar el usuario en la base de datos.';
            header('Location: ' . BASE_URL . 'auth/register');
            exit;
        }
    }
}