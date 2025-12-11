<h1>📅 Solicitud de Reserva: <?php echo htmlspecialchars($espacio['nombre']); ?></h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo $BASE_URL; ?>reserva/guardar">
    <input type="hidden" name="espacio_id" value="<?php echo htmlspecialchars($espacio['id']); ?>">

    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
        <h3>ℹ️ Información del Espacio</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <strong>Aforo Máximo:</strong><br>
                <span style="color: #2ecc71; font-size: 1.3em;">👥 <?php echo htmlspecialchars($espacio['aforo_maximo']); ?> personas</span>
            </div>
            <div>
                <strong>Precio por Hora:</strong><br>
                <span style="color: #2ecc71; font-size: 1.3em;">💵 $<?php echo number_format($espacio['precio_hora'], 2); ?></span>
            </div>
        </div>
    </div>

    <label for="fecha_inicio">📍 Fecha y Hora de Inicio</label>
    <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>

    <label for="fecha_fin">📍 Fecha y Hora de Fin</label>
    <input type="datetime-local" id="fecha_fin" name="fecha_fin" required>

    <label for="comensales">👥 Número de Personas</label>
    <input type="number" id="comensales" name="comensales" min="1" max="<?php echo htmlspecialchars($espacio['aforo_maximo']); ?>" required value="1">

    <label for="proposito">🎉 Propósito del Evento</label>
    <input type="text" id="proposito" name="proposito" placeholder="Ej: Cumpleaños, Conferencia, Cena de Negocios..." required>

    <label for="requerimientos">✨ Requerimientos Especiales (Opcional)</label>
    <textarea id="requerimientos" name="requerimientos" placeholder="Descríbenos si necesitas algo especial: decoración, catering adicional, etc."></textarea>

    <button type="submit">✓ Enviar Solicitud de Reserva</button>
</form>

<p style="text-align: center; margin-top: 1.5rem;">
    <a href="<?php echo $BASE_URL; ?>client/catalogo" style="color: #3498db; text-decoration: none;">← Volver al Catálogo</a>
</p>