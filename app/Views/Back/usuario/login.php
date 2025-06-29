    <!-- Contenedor del Formulario -->
    <main class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo base_url('/login-form') ?>" class="auth-form" id="login-form">
                <?= csrf_field(); ?>
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