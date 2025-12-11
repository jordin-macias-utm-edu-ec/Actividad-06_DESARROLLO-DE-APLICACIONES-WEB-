<?php
namespace App\Models;

class Usuario extends Model {
    protected $table = 'usuarios';

    /**
     * Busca un usuario por su email.
     * @param string $email
     * @return array|false
     */
    public function findByEmail($email) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Inserta un nuevo usuario en la base de datos.
     * @param array $data Datos del usuario (nombre, email, password_hash, rol).
     * @return bool
     */
    public function insert($data) {
        // Usamos $this->table que es 'usuarios'
        $query = "INSERT INTO {$this->table} (nombre, email, password, rol) 
                  VALUES (:nombre, :email, :password, :rol)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':rol' => $data['rol']
        ]);
    }
}