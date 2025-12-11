<h1>📋 Revisión de Solicitudes de Reserva</h1>

<div style="margin-bottom: 2rem;">
    <a href="<?php echo $BASE_URL; ?>admin/dashboard" class="btn-secondary">← Volver al Dashboard</a>
</div>

<?php if (empty($reservas)): ?>
    <div class="alert alert-info">
        ℹ️ No hay solicitudes de reserva pendientes o confirmadas en este momento.
    </div>
<?php else: ?>
    <div style="margin-bottom: 1rem; color: #666;">
        <strong><?php echo count($reservas); ?></strong> solicitud(es) encontrada(s)
    </div>
    
    <div class="reservas-list">
        <?php foreach ($reservas as $reserva): 
            $estado_lower = strtolower($reserva['estado']);
            $estado_class = 'estado-' . $estado_lower;
            $estado_display = ucfirst($reserva['estado']);
        ?>
        
            <div class="reserva-card">
                
                <div class="reserva-header">
                    <div>
                        <h3>Reserva #<?php echo htmlspecialchars($reserva['id']); ?></h3>
                        <small style="color: #666;">📍 <?php echo htmlspecialchars($reserva['espacio_nombre']); ?></small>
                    </div>
                    <span class="estado-tag <?php echo $estado_class; ?>"><?php echo $estado_display; ?></span>
                </div>

                <div class="reserva-details">
                    <p>
                        <strong>👤 Cliente:</strong> 
                        <a href="mailto:<?php echo htmlspecialchars($reserva['user_email']); ?>" style="color: #3498db; text-decoration: none;">
                            <?php echo htmlspecialchars($reserva['user_email']); ?>
                        </a>
                    </p>
                    <p>
                        <strong>📅 Inicio:</strong> 
                        <?php 
                            $fecha_inicio = new DateTime($reserva['fecha_inicio']);
                            echo $fecha_inicio->format('d/m/Y H:i');
                        ?>
                    </p>
                    <p>
                        <strong>📅 Fin:</strong> 
                        <?php 
                            $fecha_fin = new DateTime($reserva['fecha_fin']);
                            echo $fecha_fin->format('d/m/Y H:i');
                        ?>
                    </p>
                    <p>
                        <strong>⏱️ Duración:</strong>
                        <?php 
                            $duracion = $fecha_inicio->diff($fecha_fin);
                            $horas = ($duracion->days * 24) + $duracion->h;
                            $minutos = $duracion->i;
                            echo $horas . 'h ' . $minutos . 'min';
                        ?>
                    </p>
                </div>
                
                <div class="reserva-actions">
                    <?php if ($reserva['estado'] === 'pendiente'): ?>
                        <a href="<?php echo $BASE_URL; ?>admin/aprobar/<?php echo $reserva['id']; ?>" class="btn-action btn-confirmar">
                            ✓ Aprobar
                        </a>
                        <a href="<?php echo $BASE_URL; ?>admin/rechazar/<?php echo $reserva['id']; ?>" class="btn-action btn-rechazar">
                            ✗ Rechazar
                        </a>
                    <?php else: ?>
                        <p class="accion-completada">
                            ✓ Acción tomada: <strong><?php echo $estado_display; ?></strong>
                        </p>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div style="margin-top: 2rem;">
    <a href="<?php echo $BASE_URL; ?>admin/dashboard" class="btn-secondary">← Volver al Dashboard</a>
</div>