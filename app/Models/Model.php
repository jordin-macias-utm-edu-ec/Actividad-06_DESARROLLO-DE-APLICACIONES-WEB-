<?php
namespace App\Models;

use App\Core\Database;

class Model {
    protected $db;
    protected $table; // Propiedad para el nombre de la tabla

    public function __construct() {
        // Inicializa la conexión a la base de datos usando la clase Core\Database
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Método genérico para obtener todos los registros
    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Método genérico para obtener un registro por ID
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Método genérico para insertar datos
     * @param array $data Array asociativo de [columna => valor]
     */
    public function insert(array $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($query);

        return $stmt->execute($data);
    }

    // (Otros métodos como update y delete se añadirán según sea necesario)
}