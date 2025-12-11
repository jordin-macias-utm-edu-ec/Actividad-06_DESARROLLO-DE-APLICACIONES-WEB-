<h1>📝 Crear Nueva Cuenta</h1>

<p style="text-align: center; color: #666; font-size: 1.1em; margin-bottom: 2rem;">
    Regístrate para empezar a reservar nuestros espacios
</p>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo BASE_URL; ?>auth/registerSubmit" style="max-width: 400px; margin: 0 auto;">
    <label for="nombre">👤 Nombre Completo</label>
    <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre">

    <label for="email">📧 Correo Electrónico</label>
    <input type="email" id="email" name="email" required placeholder="tu@email.com">

    <label for="password">🔑 Contraseña</label>
    <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres">

    <label for="password_confirm">🔐 Confirmar Contraseña</label>
    <input type="password" id="password_confirm" name="password_confirm" required placeholder="Repite tu contraseña">

    <button type="submit">Crear Mi Cuenta</button>
</form>

<p style="text-align: center; margin-top: 1.5rem;">
    ¿Ya tienes cuenta? 
    <a href="<?php echo BASE_URL; ?>auth/login" style="color: #2ecc71; font-weight: 600; text-decoration: none;">Inicia sesión aquí →</a>
</p>