<!-- Contenedor del Formulario -->
<main class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title"><i class="fas fa-user-plus"></i> Registrarse</h1>

        <form class="auth-form" id="register-form">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@filmstream.com" required>
            </div>

            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Usuario</label>
                <input type="text" id="username" name="username" placeholder="Mínimo 4 caracteres" minlength="4" required>
            </div>

            <div class="form-group password-container">
                <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" minlength="6" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
            </div>

            <div class="form-group password-container">
                <label for="repeat-password"><i class="fas fa-redo"></i> Repetir Contraseña</label>
                <input type="password" id="repeat-password" name="repeat-password" placeholder="••••••••" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword('repeat-password')"></i>
            </div>

            <div class="terms">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Acepto los <a href="#">Términos y Condiciones</a> y la <a href="#">Política de Privacidad</a></label>
            </div>

            <button type="submit" class="auth-btn">Crear Cuenta</button>

            <div class="auth-links">
                <p>¿Ya tienes cuenta? <a href="<?= base_url('login') ?>">Inicia Sesión</a></p>
            </div>
        </form>
    </div>
</main>