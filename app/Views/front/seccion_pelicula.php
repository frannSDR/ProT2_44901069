<!-- Contenedor principal de la sección película -->
<div class="movie-detail-wrapper">
    <!-- banner de la película -->
    <div class="movie-banner" style="background-image: url('<?= $movie['banner'] ?>');">
        <div class="banner-overlay"></div>
        <div class="banner-content">
            <h1><?= esc($movie['titulo']) ?></h1>
            <div class="banner-rating">
                <span class="stars"><?= str_repeat('★', floor($movie['valoracion'] / 2)) . str_repeat('☆', 5 - floor($movie['valoracion'] / 2)) ?></span>
                <span class="rating-value"><?= number_format($movie['valoracion'] / 2, 1) ?>/5</span>
            </div>
        </div>
    </div>

    <!-- contenido principal -->
    <div class="contenedor-principal">
        <div class="contenido-principal">
            <div class="movie-header">
                <div class="movie-cover">
                    <img src="<?= $movie['poster'] ?>" alt="Portada de <?= esc($movie['titulo']) ?>" class="cover-image">
                </div>
                <div class="movie-details">
                    <div class="movie-section-meta">
                        <span class="meta-item"><i class="fas fa-calendar-alt"></i> <?= $movie['año'] ?></span>
                        <span class="meta-item"><i class="fas fa-clock"></i> <?= $movie['duracion'] ?? '120' ?> min</span>
                        <span class="meta-item"><i class="fas fa-video"></i> <?= esc($movie['director'] ?? 'No especificado') ?></span>
                        <span class="meta-item"><i class="fas fa-users"></i> <?= esc($movie['reparto']) ?></span>
                        <span class="meta-item"><i class="fas fa-tags"></i>
                            <?php foreach ($generos as $index => $genero): ?>
                                <span><?= $genero['nombre'] ?><?= $index < count($generos) - 1 ? ', ' : '' ?></span>
                            <?php endforeach; ?>
                        </span>
                    </div>
                    <div class="movie-description">
                        <p><?= esc($movie['sinopsis']) ?></p>
                    </div>
                    <div class="movie-info-extra">
                        <span class="info-tag original-title"><i class="fas fa-globe"></i> <?= esc($movie['titulo_original']) ?></span>
                        <span class="info-tag quality"><i class="fas fa-hd-video"></i> <?= esc($movie['calidad'] ?? '1080p') ?></span>
                        <span class="info-tag rating"><i class="fas fa-star"></i> <?= $movie['valoracion'] ?>/10</span>
                    </div>
                </div>
            </div>

            <h2 class="titulo-sinopsis">Sinopsis</h2>
            <div class="tab-content active" id="about">
                <div class="movie-synopsis">
                    <?= esc($movie['sinopsis']) ?>
                </div>
            </div>

            <h2 class="titulo-sinopsis" style="margin-top: 30px;">Trailer</h2>
            <div class="visuales-container">
                <?php if ($movie['trailer']): ?>
                    <div class="trailer-container">
                        <iframe
                            src="https://www.youtube.com/embed/<?= $movie['trailer'] ?>"
                            title="Trailer de <?= esc($movie['titulo']) ?>"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php endif; ?>
            </div>

            <!-- reproductor de película -->
            <h2 class="titulo-sinopsis" style="margin-top: 30px;">Reproducir Película</h2>
            <div class="player-section">
                <div class="player-controls">
                    <button id="play-movie-btn" class="play-movie-button">
                        <i class="fas fa-play"></i>
                        <span>Ver Película</span>
                    </button>
                    <div class="player-info">
                        <span class="quality-info">
                            <i class="fas fa-hd-video"></i>
                            Calidad: <?= esc($movie['calidad']) ?>
                        </span>
                        <span class="file-info" id="file-info" style="display: none;">
                            <i class="fas fa-download"></i>
                            <span id="download-speed">0 KB/s</span> |
                            <span id="peers-count">0 peers</span>
                        </span>
                    </div>
                </div>

                <div id="movie-player-container" class="movie-player-container" style="display: none;">
                    <div class="player-header">
                        <h3>
                            <i class="fas fa-film"></i>
                            Reproduciendo: <?= esc($movie['titulo']) ?>
                        </h3>
                        <button id="close-player-btn" class="close-player-button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div id="video-player" class="video-player">
                        <!-- Aquí se insertará el reproductor de video -->
                        <div class="player-loading">
                            <div class="loading-spinner">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                            <p>Cargando película...</p>
                            <div class="loading-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" id="loading-progress"></div>
                                </div>
                                <span id="loading-text">Preparando...</span>
                            </div>
                        </div>
                    </div>

                    <div class="player-footer">
                        <div class="player-stats">
                            <span class="stat-item">
                                <i class="fas fa-tachometer-alt"></i>
                                Velocidad: <span id="speed-display">0 KB/s</span>
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-users"></i>
                                Peers: <span id="peers-display">0</span>
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-percentage"></i>
                                Progreso: <span id="progress-display">0%</span>
                            </span>
                        </div>
                        <div class="player-actions">
                            <button id="fullscreen-btn" class="action-button">
                                <i class="fas fa-expand"></i>
                                Pantalla completa
                            </button>
                            <button id="download-btn" class="action-button">
                                <i class="fas fa-download"></i>
                                Descargar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mensaje si no hay magnet link -->
                <?php if (empty($movie['magnet_link'])): ?>
                    <div class="no-player-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Película no disponible</h4>
                        <p>Esta película aún no está disponible para reproducir en línea.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- reseñas de usuarios -->
            <div class="seccion-resenas">
                <h2 class="titulo-sinopsis">Reseñas de usuarios</h2>

                <div class="estadisticas-resenas">
                    <div class="puntuacion-general">
                        <div class="puntuacion-numero"><?= number_format($movie['valoracion'], 1) ?></div>
                        <div class="estrellas">
                            <?php
                            $estrellasLlenas = floor($movie['valoracion'] / 2);
                            $mediaEstrella = (($movie['valoracion'] / 2) - $estrellasLlenas) >= 0.5;

                            for ($i = 1; $i <= 5; $i++):
                                if ($i <= $estrellasLlenas): ?>
                                    <i class="fas fa-star"></i>
                                <?php elseif ($i == $estrellasLlenas + 1 && $mediaEstrella): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                            <?php endif;
                            endfor; ?>
                        </div>
                        <div class="total-resenas">Valoración de <?= number_format($movie['valoracion'], 1) ?>/10</div>
                    </div>
                </div>

                <div class="filtros-resenas">
                    <div class="selector-orden">
                        <label for="orden-resenas">Ordenar por:</label>
                        <select id="orden-resenas" name="orden-resenas">
                            <option value="recientes">Más recientes</option>
                            <option value="mejores">Mejor valoradas</option>
                        </select>
                    </div>
                    <div class="filtro-estrellas">
                        <span class="filtro-texto">Filtrar:</span>
                        <button class="boton-filtro activo" data-estrellas="all">Todas</button>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <button class="boton-filtro" data-estrellas="<?= $i ?>"><?= $i ?>★</button>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="lista-resenas">
                    <!-- Ejemplo de reseña -->
                    <div class="resena-item">
                        <div class="resena-header">
                            <div class="usuario-info">
                                <div class="usuario-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="usuario-datos">
                                    <h4>Usuario Ejemplo</h4>
                                    <div class="fecha-resena">Hace 2 días</div>
                                </div>
                            </div>
                            <div class="puntuacion-resena">
                                <div class="estrellas-resena">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="puntuacion-numero">8/10</span>
                            </div>
                        </div>
                        <div class="resena-contenido">
                            <h5>Excelente película</h5>
                            <p>Una película increíble con una trama fascinante y efectos visuales impresionantes. Altamente recomendada para los amantes del cine.</p>
                        </div>
                        <div class="resena-acciones">
                            <button class="boton-util">
                                <i class="fas fa-thumbs-up"></i> Útil (12)
                            </button>
                            <button class="boton-responder">
                                <i class="fas fa-reply"></i> Responder
                            </button>
                        </div>
                    </div>
                </div>

                <div id="formulario-resena" class="formulario-resena-container" style="display: none;">
                    <div class="formulario-resena">
                        <div class="encabezado-formulario">
                            <h3>Escribe tu reseña</h3>
                            <button id="cerrar-formulario" class="boton-cerrar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <!-- formulario para que el usuario escriba su reseña -->
                        <form id="nueva-resena">
                            <div class="grupo-formulario">
                                <label for="titulo-resena">Título de la reseña</label>
                                <input type="text" id="titulo-resena" name="titulo-resena" placeholder="Ej: ¡Una película increíble!">
                                <div class="alert alert-danger error-msg" id="error-titulo-resena"></div>
                            </div>
                            <div class="grupo-formulario">
                                <label>Tu puntuación</label>
                                <div class="rating-estrellas">
                                    <input type="radio" id="estrella5" name="rating" value="5">
                                    <label for="estrella5" class="estrella"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="estrella4" name="rating" value="4">
                                    <label for="estrella4" class="estrella"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="estrella3" name="rating" value="3">
                                    <label for="estrella3" class="estrella"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="estrella2" name="rating" value="2">
                                    <label for="estrella2" class="estrella"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="estrella1" name="rating" value="1">
                                    <label for="estrella1" class="estrella"><i class="fas fa-star"></i></label>
                                </div>
                                <div class="alert alert-danger error-msg" id="error-rating"></div>
                            </div>
                            <div class="grupo-formulario">
                                <label for="texto-resena">Tu reseña</label>
                                <textarea id="texto-resena" name="texto-resena" rows="5" placeholder="Comparte tu opinión sobre esta película..."></textarea>
                                <div class="alert alert-danger error-msg" id="error-texto-resena"></div>
                            </div>
                            <div class="acciones-formulario">
                                <button type="button" id="cancelar-resena" class="boton-secundario">Cancelar</button>
                                <button type="submit" class="boton-primario">Enviar reseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.baseUrl = "<?= base_url() ?>";
        window.movieId = <?= esc($movie['movie_id']) ?>;
        window.guardarResenaUrl = "<?= base_url('pelicula/' . $movie['movie_id'] . '/guardar-resena') ?>";
        window.isUserLoggedIn = <?= session()->has('user_id') ? 'true' : 'false' ?>;
        window.loginUrl = "<?= base_url('login') ?>";
        window.magnetLink = "<?= esc($movie['magnet_link'] ?? '') ?>";
    </script>
</div>