<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'El Buen Comer'); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div style="font-weight: 700; font-size: 1.3em;">🍽️ El Buen Comer</div>
            <div>
                <a href="<?php echo BASE_URL; ?>client/catalogo">Catálogo</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard Admin</a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>client/mis_reservas">Mis Reservas</a>
                    <?php endif; ?>
                    <span style="margin: 0 10px;">|</span>
                    <span>Hola, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>
                    <a href="<?php echo BASE_URL; ?>auth/logout">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>auth/login">Iniciar Sesión</a>
                    <a href="<?php echo BASE_URL; ?>auth/register">Registrarse</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    
    <main id="content">
        <?php 
        // Esta variable $content_view es asignada por la clase View
        include $content_view; 
        ?>
    </main>
    
    <footer>
        <p>&copy; <?php echo date('Y'); ?> El Buen Comer - Reservas de Espacios</p>
        <p>Todos los derechos reservados. | Contacto: info@elbuen comer.com</p>
    </footer>
</body>
</html>