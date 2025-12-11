<?php
namespace App\Core; // Namespace para organizar las clases

// Incluye el archivo de configuración para acceder a las constantes
require_once dirname(__DIR__, 2) . '/config.php';

class Database {
    private $conn;

    // Método que intenta conectar a la base de datos
    public function getConnection() {
        $this->conn = null;

        try {
            // Conexión usando PDO y las constantes definidas en config.php
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $this->conn = new \PDO($dsn, DB_USER, DB_PASS);

            // Configurar PDO para reportar errores y usar codificación UTF8
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");

        } catch (\PDOException $exception) {
            // En caso de error de conexión, muestra un mensaje
            die("Error de conexión a la base de datos: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
?>