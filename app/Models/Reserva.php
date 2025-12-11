<?php
namespace App\Models;

class Reserva extends Model {
    protected $table = 'reservas';

    /**
     * Verifica si existe alguna reserva (confirmada o pendiente) que se solape
     * con el rango de tiempo solicitado.
     *
     * @param int $espacio_id ID del espacio a reservar.
     * @param string $fecha_inicio Fecha y hora de inicio (formato YYYY-MM-DD HH:MM:SS).
     * @param string $fecha_fin Fecha y hora de fin.
     * @return bool True si hay solapamiento (NO disponible), False si está disponible.
     */
    public function checkAvailability($espacio_id, $fecha_inicio, $fecha_fin) {
        $query = "SELECT COUNT(*) 
                  FROM {$this->table} 
                  WHERE espacio_id = :espacio_id
                  AND estado IN ('pendiente', 'confirmada')
                  AND (
                      (:fecha_inicio < fecha_fin) 
                      AND (:fecha_fin > fecha_inicio)
                  )";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':espacio_id', $espacio_id);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * Guarda una nueva reserva en la base de datos con estado 'pendiente'.
     * @param array $data Datos de la reserva.
     * @return bool
     */
    public function saveNew($data) {
        $query = "INSERT INTO {$this->table} (usuario_id, espacio_id, fecha_inicio, fecha_fin, comensales, proposito, requerimientos, estado) 
                  VALUES (:usuario_id, :espacio_id, :fecha_inicio, :fecha_fin, :comensales, :proposito, :requerimientos, 'pendiente')";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':usuario_id' => $data['user_id'],
            ':espacio_id' => $data['espacio_id'],
            ':fecha_inicio' => $data['inicio'],
            ':fecha_fin' => $data['fin'],
            ':comensales' => $data['comensales'],
            ':proposito' => $data['proposito'] ?? 'Sin propósito', 
            ':requerimientos' => $data['requerimientos'] ?? '',
        ]);
    }

    /**
     * Obtiene todas las reservas de un usuario específico.
     * @param int $usuario_id ID del usuario
     * @return array Array de reservas
     */
    public function findByUserId($usuario_id) {
        $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, r.comensales, r.proposito, r.requerimientos, e.nombre as espacio_nombre
                  FROM {$this->table} r
                  JOIN espacios e ON r.espacio_id = e.id
                  WHERE r.usuario_id = :usuario_id
                  ORDER BY r.fecha_inicio DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las reservas pendientes/confirmadas con el email de usuario y el nombre del espacio.
     * @return array
     */
    public function getAllWithUserInfo() {
        $query = "SELECT r.id, r.fecha_inicio, r.fecha_fin, r.estado, u.email as user_email, e.nombre as espacio_nombre
                  FROM {$this->table} r
                  JOIN usuarios u ON r.usuario_id = u.id
                  JOIN espacios e ON r.espacio_id = e.id
                  WHERE r.estado IN ('pendiente', 'confirmada')
                  ORDER BY r.fecha_inicio ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza el estado de una reserva específica (Aprobar/Rechazar).
     * @param int $id ID de la reserva
     * @param string $estado Nuevo estado ('confirmada' o 'rechazada')
     * @return bool
     */
    public function updateState($id, $estado) {
        $query = "UPDATE {$this->table} SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}