<?php
namespace App\Models;

class Espacio extends Model {
    protected $table = 'espacios';

    // Aquí se pueden agregar métodos específicos para Espacios
    public function getActivos() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE estado = 'activo'");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}