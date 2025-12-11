<h1>🔐 Iniciar Sesión</h1>

<p style="text-align: center; color: #666; font-size: 1.1em; margin-bottom: 2rem;">
    Accede a tu cuenta para realizar reservas
</p>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        ✓ <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo BASE_URL; ?>auth/loginSubmit" style="max-width: 400px; margin: 0 auto;">
    <label for="email">📧 Correo Electrónico</label>
    <input type="email" id="email" name="email" required placeholder="tu@email.com">

    <label for="password">🔑 Contraseña</label>
    <input type="password" id="password" name="password" required placeholder="Tu contraseña">

    <button type="submit">Entrar en Mi Cuenta</button>
</form>

<p style="text-align: center; margin-top: 1.5rem;">
    ¿No tienes cuenta? 
    <a href="<?php echo BASE_URL; ?>auth/register" style="color: #2ecc71; font-weight: 600; text-decoration: none;">Regístrate aquí →</a>
</p>