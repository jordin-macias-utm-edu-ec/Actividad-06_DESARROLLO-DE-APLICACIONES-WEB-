<?php
namespace App\Core;

// Incluir configuración para acceder a BASE_URL
require_once dirname(__DIR__, 2) . '/config.php';

class Router {

    public function handleRequest() {
        
        // 1. Obtener y limpiar la URI
        $request_uri = $_GET['url'] ?? ''; 
        $request_uri = trim($request_uri, '/');
        
        // 2. Limpieza de la Ruta Base
        $path_to_remove = trim(BASE_URL, '/'); 
        
        // CORRECCIÓN CLAVE: Usamos '~' (tilde) como delimitador de regex.
        $pattern = "~^(" . preg_quote($path_to_remove, '~') . "|public)/?~i"; 
        $request_uri = preg_replace($pattern, '', $request_uri, 1);
        
        // 3. Dividir la URI limpia
        $parts = explode('/', filter_var($request_uri, FILTER_SANITIZE_URL));
        
        // 4. Determinar el Controlador, la Acción y los Parámetros
        
        if (empty($parts[0])) {
            $controllerName = 'Client';
            $actionName = 'catalogo'; // Acción por defecto
            $params = [];
        } else {
            $controllerName = ucfirst($parts[0]);
            $actionName = $parts[1] ?? 'index'; 
            
            // CRÍTICO: Capturar todos los segmentos restantes como parámetros
            $params = array_slice($parts, 2); 
        }
        
        // 5. Preparar la clase y la ruta
        $controllerClass = "App\\Controllers\\{$controllerName}Controller";
        $controllerPath = dirname(__DIR__) . "/Controllers/{$controllerName}Controller.php";

        // 6. Verificar y Ejecutar
        if (!file_exists($controllerPath)) {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 Not Found</h1><p>Controlador no encontrado: {$controllerClass}</p>";
            exit;
        }
        
        require_once $controllerPath;
        
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
        
            if (method_exists($controller, $actionName)) {
                
                // Ejecutar la acción, pasando los parámetros capturados
                call_user_func_array([$controller, $actionName], $params); 
                
            } else {
                header("HTTP/1.0 404 Not Found");
                echo "<h1>404 Not Found</h1><p>Acción no encontrada en el controlador: {$actionName}</p>";
                exit;
            }
        }
    }
}