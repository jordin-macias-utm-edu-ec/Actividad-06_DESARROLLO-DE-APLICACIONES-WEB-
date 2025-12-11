<h1>⚙️ Dashboard del Administrador</h1>

<div class="header-welcome">
    <div class="welcome-text">
        Bienvenido, <strong><?php echo htmlspecialchars($userName); ?></strong>
    </div>
    <div class="header-buttons">
        <a href="<?php echo $BASE_URL; ?>admin/reservas" class="btn-primary">📋 Ver Reservas</a>
        <a href="<?php echo $BASE_URL; ?>admin/espacios" class="btn-secondary">🏢 Gestionar Espacios</a>
        <a href="<?php echo $BASE_URL; ?>auth/logout" class="btn-danger">🚪 Cerrar Sesión</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 2rem 0;">
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #2ecc71;">
        <h3 style="margin-top: 0;">📊 Panel de Control</h3>
        <p style="color: #666;">Aquí puedes gestionar todas las reservas y espacios del restaurante.</p>
        <a href="<?php echo $BASE_URL; ?>admin/reservas" style="color: #2ecc71; font-weight: 600; text-decoration: none;">Ir a Reservas →</a>
    </div>
    
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #3498db;">
        <h3 style="margin-top: 0;">🏢 Espacios</h3>
        <p style="color: #666;">Administra los espacios disponibles para reservas.</p>
        <a href="<?php echo $BASE_URL; ?>admin/espacios" style="color: #3498db; font-weight: 600; text-decoration: none;">Ir a Espacios →</a>
    </div>
    
    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f39c12;">
        <h3 style="margin-top: 0;">👥 Usuarios</h3>
        <p style="color: #666;">Consulta la lista de usuarios registrados.</p>
        <a href="<?php echo $BASE_URL; ?>client/catalogo" style="color: #f39c12; font-weight: 600; text-decoration: none;">Ir al Catálogo →</a>
    </div>
</div>

<h2 style="margin-top: 3rem;">Acciones Rápidas</h2>

<div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <p style="margin-top: 0; color: #666;">
        Desde aquí puedes acceder rápidamente a las funciones más importantes del sistema.
    </p>
    <ul style="list-style: none; padding: 0;">
        <li style="padding: 12px 0; border-bottom: 1px solid #eee;">
            <a href="<?php echo $BASE_URL; ?>admin/reservas" style="color: #2ecc71; text-decoration: none; font-weight: 500;">
                ✓ Revisar Solicitudes de Reserva Pendientes
            </a>
        </li>
        <li style="padding: 12px 0; border-bottom: 1px solid #eee;">
            <a href="<?php echo $BASE_URL; ?>admin/espacios" style="color: #3498db; text-decoration: none; font-weight: 500;">
                ✓ Ver Disponibilidad de Espacios
            </a>
        </li>
        <li style="padding: 12px 0;">
            <a href="<?php echo $BASE_URL; ?>client/catalogo" style="color: #9b59b6; text-decoration: none; font-weight: 500;">
                ✓ Volver al Catálogo de Espacios
            </a>
        </li>
    </ul>
</div>