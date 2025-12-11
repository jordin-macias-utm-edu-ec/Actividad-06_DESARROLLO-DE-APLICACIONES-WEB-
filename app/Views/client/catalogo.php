<h1>🍽️ Catálogo de Espacios - El Buen Comer</h1>

<?php if (isset($_SESSION['reserva_success'])): ?>
    <div class="alert alert-success">
        ✓ <?php echo htmlspecialchars($_SESSION['reserva_success']); ?>
    </div>
    <?php unset($_SESSION['reserva_success']); ?>
<?php endif; ?>

<?php if ($is_logged_in): ?>
    <div class="header-welcome">
        <div class="welcome-text">
            Bienvenido, <strong><?php echo htmlspecialchars($user_name); ?></strong>
        </div>
        <div class="header-buttons">
            <a href="<?php echo $BASE_URL; ?>client/mis_reservas" class="btn-primary">📋 Mis Reservas</a>
            <a href="<?php echo $BASE_URL; ?>auth/logout" class="btn-secondary">🚪 Cerrar Sesión</a>
        </div>
    </div>
<?php else: ?>
    <div class="header-welcome">
        <div class="welcome-text">
            Para reservar nuestros espacios, por favor inicia sesión o regístrate
        </div>
        <div class="header-buttons">
            <a href="<?php echo $BASE_URL; ?>auth/login" class="btn-info">🔐 Iniciar Sesión</a>
            <a href="<?php echo $BASE_URL; ?>auth/register" class="btn-success-alt">📝 Registrarse</a>
        </div>
    </div>
<?php endif; ?>

<h2>Espacios Disponibles</h2>

<?php if (empty($espacios)): ?>
    <div class="alert alert-warning">
        ⚠️ No hay espacios registrados en este momento.
    </div>
<?php else: ?>
    <?php foreach ($espacios as $espacio): ?>
        <div class="salon-card">
            <!-- Imagen del espacio -->
            <div class="salon-image">
                <?php 
                    $imagenes_espacios = [
                        'salon principal' => 'https://webbox.imgix.net/images/jnsswbfftjwdsnfr/05325207-7fd9-4944-9949-47f253144422.jpg?auto=format,compress&fit=crop&crop=entropy',
                        'salón diamante' => 'https://cdn0.bodas.com.mx/vendor/5995/3_2/1280/jpg/salon-diamante-0_5_165995-168207960040712.jpeg',
                        'sala de juntas ejecutivas' => 'https://www.swissotel.com/assets/0/92/2119/2990/3029/3031/6442451693/ea726829-786d-421c-836e-02523875c6c8.jpg',
                        'terraza rooftop' => 'https://innovaretailstudio.com/wp-content/uploads/2024/07/rooftop-diseno-terraza-azotea-restaurante-hotel-bar-scaled.jpg',
                        'auditorio central' => 'https://kankio.com/wp-content/uploads/2024/08/AUDITORIO-CENTRAL-UNIVERSIDAD-LIMA_1.webp',
                        'patio jardín' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShVogt-dzJ_JP7VJNMvhl1N3gxLviKNb-0PQ&s'
                    ];
                    
                    $nombre_espacio = strtolower($espacio['nombre']);
                    $ruta_imagen = isset($imagenes_espacios[$nombre_espacio]) 
                        ? $imagenes_espacios[$nombre_espacio] 
                        : 'https://via.placeholder.com/400x300?text=Sin+Imagen';
                ?>
                <img src="<?php echo htmlspecialchars($ruta_imagen); ?>" 
                     alt="<?php echo htmlspecialchars($espacio['nombre']); ?>">
            </div>

            <!-- Contenido del espacio -->
            <div class="salon-content">
                <div>
                    <h3>📍 <?php echo htmlspecialchars($espacio['nombre']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($espacio['descripcion'])); ?></p>
                    
                    <div class="salon-info">
                        <div class="salon-info-item">
                            <strong>Aforo</strong>
                            <span><?php echo htmlspecialchars($espacio['aforo_maximo']); ?> personas</span>
                        </div>
                        <div class="salon-info-item">
                            <strong>Precio/Hora</strong>
                            <span>$<?php echo number_format($espacio['precio_hora'], 2); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="salon-actions">
                    <?php if ($is_logged_in): ?>
                        <a href="<?php echo $BASE_URL; ?>reserva/solicitar/<?php echo $espacio['id']; ?>" class="btn-reserva">
                            ✓ Solicitar Reserva
                        </a>
                    <?php else: ?>
                        <small style="color: #999;">🔒 Inicia sesión para reservar este espacio</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>