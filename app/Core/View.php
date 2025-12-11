<?php
namespace App\Core;

class View {
    
    // Directorio base donde se encuentran todas las vistas
    const BASE_VIEW_PATH = __DIR__ . '/../../app/Views/';

    /**
     * Carga una vista y le pasa datos (variables) si existen.
     * @param string $viewName Nombre del archivo de la vista (ej: 'admin/dashboard').
     * @param array $data Variables que se pasarán a la vista.
     */
    public static function render($viewName, $data = []) {
        
        extract($data);

        // 1. Definimos la ruta COMPLETA de la vista específica (ej: login.php)
        $content_view = self::BASE_VIEW_PATH . str_replace('.', '/', $viewName) . '.php';

        if (!file_exists($content_view)) {
            die("Error: La vista '{$viewName}' no fue encontrada.");
        }

        // 2. Definimos la ruta del Layout Base
        $layout_path = self::BASE_VIEW_PATH . 'layout/main.php';

        if (file_exists($layout_path)) {
            // 3. Incluimos el Layout Base.
            // Nota: Al incluir main.php, se ejecutarán las variables $content_view, $title, etc.
            require $layout_path; 
        } else {
            // Si no hay layout, solo renderizamos el contenido
            require $content_view;
        }
    }
}