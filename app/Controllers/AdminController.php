<?php
namespace App\Controllers;

use App\Models\Espacio; 
use App\Models\Reserva;
use App\Core\View; // <-- ¡CLAVE! Añadimos el sistema de vistas

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__, 2) . '/config.php';

class AdminController {
    
    private $espacioModel; 
    private $reservaModel; 

    public function __construct() {
        $this->espacioModel = new Espacio();
        $this->reservaModel = new Reserva(); 
    }
    
    private function checkAuth() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== ROL_ADMIN) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }
    
    // =======================================================
    // VISTAS PRINCIPALES DEL ADMINISTRADOR (USANDO VISTAS)
    // =======================================================
    public function dashboard() {
        $this->checkAuth(); 
        
        $userName = $_SESSION['user_name'] ?? 'Admin';

        // Usar la vista para mostrar el Dashboard
        View::render('admin/dashboard', [
            'userName' => $userName,
            'BASE_URL' => BASE_URL
        ]);
    }

    // =======================================================
    // GESTIÓN DE RESERVAS (USANDO VISTAS)
    // =======================================================
    public function reservas() {
        $this->checkAuth();
        
        $reservas = $this->reservaModel->getAllWithUserInfo(); 

        // Usar la vista para mostrar la tabla de reservas
        View::render('admin/reservas', [
            'reservas' => $reservas,
            'BASE_URL' => BASE_URL
        ]);
    }

    // NUEVOS MÉTODOS DE ACCIÓN PARA EL ADMINISTRADOR
    public function aprobar($reserva_id) {
        $this->checkAuth();
        if ($this->reservaModel->updateState($reserva_id, 'confirmada')) {
            header('Location: ' . BASE_URL . 'admin/reservas');
        } else {
            // Esto debería redirigir a una vista de error
            echo "Error al aprobar la reserva."; 
        }
    }

    public function rechazar($reserva_id) {
        $this->checkAuth();
        if ($this->reservaModel->updateState($reserva_id, 'rechazada')) {
            header('Location: ' . BASE_URL . 'admin/reservas');
        } else {
             // Esto debería redirigir a una vista de error
            echo "Error al rechazar la reserva.";
        }
    }
    
    // GESTIÓN DE ESPACIOS (CRUD) -
    public function espacios() { /* ... */ }
    public function crear() { /* ... */ }
    public function guardar() { /* ... */ }
}