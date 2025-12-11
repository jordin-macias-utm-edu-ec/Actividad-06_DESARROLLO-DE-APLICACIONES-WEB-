<h1>📋 Mis Reservas</h1>

<div style="margin-bottom: 2rem;">
    <a href="<?php echo $BASE_URL; ?>client/catalogo" class="btn-secondary">← Volver al Catálogo</a>
</div>

<?php if (empty($reservas)): ?>
    <div class="alert alert-info">
        ℹ️ Aún no tienes reservas. 
        <a href="<?php echo $BASE_URL; ?>client/catalogo" style="color: #0c5460; font-weight: 600;">
            Consulta nuestros espacios disponibles →
        </a>
    </div>
<?php else: ?>
    <div style="margin-bottom: 1rem; color: #666;">
        Tienes <strong><?php echo count($reservas); ?></strong> reserva(s)
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
                        <h3>📍 <?php echo htmlspecialchars($reserva['espacio_nombre']); ?></h3>
                        <small style="color: #666;">Reserva #<?php echo htmlspecialchars($reserva['id']); ?></small>
                    </div>
                    <span class="estado-tag <?php echo $estado_class; ?>"><?php echo $estado_display; ?></span>
                </div>

                <div class="reserva-details">
                    <p>
                        <strong>📅 Fecha de Inicio:</strong> 
                        <br>
                        <?php 
                            $fecha_inicio = new DateTime($reserva['fecha_inicio']);
                            echo $fecha_inicio->format('d de F de Y - H:i');
                        ?>
                    </p>
                    <p>
                        <strong>📅 Fecha de Fin:</strong> 
                        <br>
                        <?php 
                            $fecha_fin = new DateTime($reserva['fecha_fin']);
                            echo $fecha_fin->format('d de F de Y - H:i');
                        ?>
                    </p>
                    <p>
                        <strong>👥 Número de Personas:</strong> 
                        <?php echo htmlspecialchars($reserva['comensales']); ?>
                    </p>
                    <p>
                        <strong>🎉 Propósito:</strong> 
                        <?php echo htmlspecialchars($reserva['proposito']); ?>
                    </p>
                    
                    <?php if (!empty($reserva['requerimientos'])): ?>
                        <p>
                            <strong>✨ Requerimientos:</strong> 
                            <?php echo nl2br(htmlspecialchars($reserva['requerimientos'])); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="reserva-actions">
                    <?php if ($reserva['estado'] === 'pendiente'): ?>
                        <div style="width: 100%; text-align: center; padding: 10px 0; color: #f39c12;">
                            <strong>⏳ Esperando aprobación del administrador</strong>
                        </div>
                    <?php elseif ($reserva['estado'] === 'confirmada'): ?>
                        <div style="width: 100%; text-align: center; padding: 10px 0; color: #2ecc71;">
                            <strong>✓ Reserva Confirmada</strong>
                            <p style="font-size: 0.9em; margin-top: 5px;">
                                Nos vemos en el lugar y fecha indicados. ¡Gracias por tu preferencia!
                            </p>
                        </div>
                    <?php elseif ($reserva['estado'] === 'rechazada'): ?>
                        <div style="width: 100%; text-align: center; padding: 10px 0; color: #e74c3c;">
                            <strong>✗ Reserva Rechazada</strong>
                            <p style="font-size: 0.9em; margin-top: 5px;">
                                <a href="<?php echo $BASE_URL; ?>client/catalogo" style="color: #3498db; text-decoration: none;">
                                    Intenta otra fecha o espacio →
                                </a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div style="margin-top: 2rem;">
    <a href="<?php echo $BASE_URL; ?>client/catalogo" class="btn-secondary">← Volver al Catálogo</a>
</div>