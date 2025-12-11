<?php
namespace App\Controllers;

use App\Models\Reserva;
use App\Models\Espacio;
use App\Core\View;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__, 2) . '/config.php';

class ReservaController {
    
    private $reservaModel;
    private $espacioModel;

    public function __construct() {
        $this->reservaModel = new Reserva();
        $this->espacioModel = new Espacio();
    }

    /**
     * Verifica que el usuario sea un cliente logueado
     */
    private function checkClientAuth() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== ROL_CLIENTE) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }

    /**
     * Método 1: Muestra el formulario de solicitud de reserva
     */
    public function solicitar($espacio_id) {
        $this->checkClientAuth();

        $espacio = $this->espacioModel->find($espacio_id);

        if (!$espacio) {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 - Espacio no encontrado</h1>";
            exit;
        }

        $error = $_SESSION['reserva_error'] ?? '';
        unset($_SESSION['reserva_error']);

        View::render('client/solicitar_reserva', [
            'espacio' => $espacio,
            'BASE_URL' => BASE_URL,
            'error' => $error
        ]);
    }

    /**
     * Método 2: Procesa la solicitud de reserva
     */
    public function guardar() {
        $this->checkClientAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'client/catalogo');
            exit;
        }

        $espacio_id = $_POST['espacio_id'] ?? null;
        $inicio = $_POST['fecha_inicio'] ?? null;
        $fin = $_POST['fecha_fin'] ?? null;
        $comensales = $_POST['comensales'] ?? 1;
        
        // Validaciones básicas
        if (!$espacio_id || !$inicio || !$fin) {
            $_SESSION['reserva_error'] = "Todos los campos son obligatorios.";
            header('Location: ' . BASE_URL . 'reserva/solicitar/' . $espacio_id);
            exit;
        }

        // Convertir a formato DateTime para validar
        try {
            $fecha_inicio = new \DateTime($inicio);
            $fecha_fin = new \DateTime($fin);
            
            // Validar que la fecha fin sea posterior a la fecha inicio
            if ($fecha_fin <= $fecha_inicio) {
                $_SESSION['reserva_error'] = "La fecha de fin debe ser posterior a la fecha de inicio.";
                header('Location: ' . BASE_URL . 'reserva/solicitar/' . $espacio_id);
                exit;
            }
            
            // Validar que la fecha sea en el futuro
            if ($fecha_inicio < new \DateTime()) {
                $_SESSION['reserva_error'] = "No puedes reservar para fechas pasadas.";
                header('Location: ' . BASE_URL . 'reserva/solicitar/' . $espacio_id);
                exit;
            }
        } catch (\Exception $e) {
            $_SESSION['reserva_error'] = "Formato de fecha inválido.";
            header('Location: ' . BASE_URL . 'reserva/solicitar/' . $espacio_id);
            exit;
        }

        // Revalidar disponibilidad
        if ($this->reservaModel->checkAvailability($espacio_id, $inicio, $fin)) {
            $_SESSION['reserva_error'] = "El espacio ya está reservado o solicitado en ese horario.";
            header('Location: ' . BASE_URL . 'reserva/solicitar/' . $espacio_id);
            exit;
        }

        // Guardar reserva
        $data = [
            'user_id' => $_SESSION['user_id'],
            'espacio_id' => $espacio_id,
            'inicio' => $inicio,
            'fin' => $fin,
            'comensales' => $comensales,
            'proposito' => $_POST['proposito'] ?? 'Sin propósito', 
            'requerimientos' => $_POST['requerimientos'] ?? '',
            'estado' => 'pendiente' 
        ];

        if ($this->reservaModel->saveNew($data)) {
            $_SESSION['reserva_success'] = "✓ Solicitud de reserva enviada con éxito. El administrador la revisará pronto.";
            header('Location: ' . BASE_URL . 'client/catalogo');
            exit;
        } else {
            $_SESSION['reserva_error'] = "Hubo un error interno al guardar la reserva.";
            header('Location: ' . BASE_URL . 'reserva/solicitar/' . $espacio_id);
            exit;
        }
    }
}