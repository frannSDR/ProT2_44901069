    <!-- Contenedor del Formulario -->
    <main class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h1>

            <form class="auth-form" id="login-form">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ej: fran1703" required>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="auth-btn">Ingresar</button>

                <div class="auth-links">
                    <a href="#">¿Olvidaste tu contraseña?</a>
                    <p>¿No tienes cuenta? <a href="<?= base_url('register') ?>">Regístrate aquí</a></p>
                </div>
            </form>
        </div>
    </main>