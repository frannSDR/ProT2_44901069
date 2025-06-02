    <!-- seccion del footer -->
    <footer class="footer">
        <div class="footer-container">
            <!-- seccion del logo y redes sociales -->
            <div class="footer-section">
                <div class="footer-logo">
                    <a href="<?= base_url('/') ?>"><i class="bi bi-play-circle-fill"></i> FilmStream</a>
                </div>
                <p class="footer-description">
                    Disfruta de las mejores películas y series en streaming, sin anuncios y en la mejor calidad.
                </p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- seccion de enlaces -->
            <div class="footer-section">
                <h3 class="footer-title">Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="<?= base_url('#') ?>"><i class="fas fa-film"></i> Películas</a></li>
                    <li><a href="<?= base_url('#') ?>"><i class="fas fa-tv"></i> Series</a></li>
                    <li><a href="<?= base_url('quienes-somos') ?>"><i class="fas fa-users"></i> Quiénes Somos</a></li>
                    <li><a href="<?= base_url('acerca-de') ?>"><i class="fas fa-info-circle"></i> Acerca de</a></li>
                </ul>
            </div>

            <!-- seccion de cuenta -->
            <div class="footer-section">
                <h3 class="footer-title">Cuenta</h3>
                <ul class="footer-links">
                    <li><a href="<?= base_url('login') ?>"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    <li><a href="<?= base_url('register') ?>"><i class="fas fa-user-plus"></i> Registrarse</a></li>
                </ul>
            </div>

            <!-- seccion de contacto -->
            <div class="footer-section">
                <h3 class="footer-title">Contacto</h3>
                <ul class="footer-contact">
                    <li><i class="fas fa-envelope"></i> contacto@filmstream.com</li>
                    <li><i class="fas fa-phone"></i> +54 379 414-5678</li>
                    <li><i class="fas fa-map-marker-alt"></i> Corrientes, Corrientes, Argentina</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 FilmStream. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="<?= base_url('assets/js/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
    </body>

    </html>