<!-- Contenedor del Formulario -->
<main class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title"><i class="fas fa-user-plus"></i> Registrarse</h1>

        <?php $validation = \Config\Services::Validation(); ?>
        <form class="auth-form" id="register-form" method="post" action="<?php echo base_url('/register-form') ?>">
            <?= csrf_field(); ?>
            <?php if (!empty(session()->getFlashdata('fail'))): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
            <?php endif; ?>
            <?php if (!empty(session()->getFlashdata('success'))): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@filmstream.com">
                <?php if ($validation->getError('email')): ?>
                    <div class="alert alert-danger">
                        <?= $error = $validation->getError('email') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Usuario</label>
                <input type="text" id="username" name="username" placeholder="Mínimo 4 caracteres" minlength="4">
                <?php if ($validation->getError('username')): ?>
                    <div class="alert alert-danger">
                        <?= $error = $validation->getError('username') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group password-container">
                <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" minlength="6">
                <?php if ($validation->getError('password')): ?>
                    <div class="alert alert-danger">
                        <?= $validation->getError('password') ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="form-group password-container">
                <label for="repeat-password"><i class="fas fa-redo"></i> Repetir Contraseña</label>
                <input type="password" id="repeat-password" name="confirm_password" placeholder="••••••••">
                <?php if ($validation->getError('confirm_password')): ?>
                    <div class="alert alert-danger">
                        <?= $validation->getError('confirm_password') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="terms">
                <input type="checkbox" id="terms" name="terms">
                <label for="terms">Acepto los <a href="#">Términos y Condiciones</a> y la <a href="#">Política de Privacidad</a></label>
                <?php if ($validation->getError('terms')): ?>
                    <div class="alert alert-danger">
                        <?= $validation->getError('terms') ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="auth-btn">Crear Cuenta</button>

            <div class="auth-links">
                <p>¿Ya tienes cuenta? <a href="<?= base_url('login') ?>">Inicia Sesión</a></p>
            </div>
        </form>
    </div>
</main>