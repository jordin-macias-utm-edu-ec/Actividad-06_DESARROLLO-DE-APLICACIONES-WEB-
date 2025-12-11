<?php
namespace App\Controllers;

use App\Models\Espacio;
use App\Models\Reserva;
use App\Core\View;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__, 2) . '/config.php';

class ClientController {

    private $espacioModel;
    private $reservaModel;

    public function __construct() {
        $this->espacioModel = new Espacio();
        $this->reservaModel = new Reserva();
    }

    /**
     * Método: Mostrar el catálogo de espacios
     */
    public function catalogo() {
        if (session_status() == PHP_SESSION_NONE) { 
            session_start(); 
        }
        
        $espacios = $this->espacioModel->findAll();

        $is_logged_in = isset($_SESSION['user_id']); 
        $user_name = $_SESSION['user_name'] ?? 'Invitado';

        View::render('client/catalogo', [
            'espacios' => $espacios,
            'is_logged_in' => $is_logged_in,
            'user_name' => $user_name,
            'BASE_URL' => BASE_URL
        ]);
    }

    /**
     * Método: Mostrar mis reservas (solo para usuarios logueados)
     */
    public function mis_reservas() {
        if (session_status() == PHP_SESSION_NONE) { 
            session_start(); 
        }

        // Verificar si el usuario está logueado
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        
        // Obtener todas las reservas del usuario actual
        $reservas = $this->reservaModel->findByUserId($user_id);

        View::render('client/mis_reservas', [
            'reservas' => $reservas,
            'BASE_URL' => BASE_URL
        ]);
    }
}