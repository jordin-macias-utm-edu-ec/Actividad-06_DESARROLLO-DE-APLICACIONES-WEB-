<?php
// ===============================================
// PUNTO DE ENTRADA ÚNICO: index.php
// ===============================================

// 1. Cargar el archivo de configuración global
require_once dirname(__DIR__) . '/config.php';

// 2. Autocargador (Loader) simple para las clases de Core y Controllers
spl_autoload_register(function ($class) {
    // Convierte el namespace (ej. App\Core\Router) a una ruta de archivo (ej. app/Core/Router.php)
    $file = dirname(__DIR__) . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// 3. Ejecutar el Router
use App\Core\Router;

$router = new Router();
$router->handleRequest();

// NOTA: Si ves errores aquí, asegúrate de tener una regla .htaccess para 
// redirigir todas las peticiones a este index.php.
?>

