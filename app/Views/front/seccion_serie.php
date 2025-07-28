<!-- Contenedor principal de la sección película -->
<div class="movie-detail-wrapper">
    <!-- banner de la película -->
    <div class="movie-banner" style="background-image: url('<?= $serie['banner'] ?>');">
        <div class="banner-overlay"></div>
        <div class="banner-content">
            <h1><?= esc($serie['titulo']) ?></h1>
            <div class="banner-rating">
                <span class="stars"><?= str_repeat('★', floor($serie['valoracion'] / 2)) . str_repeat('☆', 5 - floor($serie['valoracion'] / 2)) ?></span>
                <span class="rating-value"><?= number_format($serie['valoracion'] / 2, 1) ?>/5</span>
            </div>
        </div>
    </div>
    <section class="movie-detail-content-wrapper">

        <!-- contenido principal -->
        <div class="contenedor-principal">
            <div class="contenido-principal">
                <div class="movie-header">
                    <div class="detail-movie-cover">
                        <img src="<?= $serie['poster'] ?>" alt="Portada de <?= esc($serie['titulo']) ?>" class="detail-cover-image">
                    </div>
                    <div class="movie-details">
                        <div class="movie-section-meta">
                            <span class="meta-item"><i class="fas fa-calendar-alt"></i> <?= $serie['año_inicio'] ?></span>
                            <span class="meta-item"><i class="fas fa-film"></i> <?= $serie['temporadas'] ?? '' ?> temporada<?= $serie['temporadas'] > 1 ? 's' : '' ?></span>
                            <span class="meta-item"><i class="fas fa-video"></i> <?= esc($serie['director'] ?? 'No especificado') ?></span>
                            <span class="meta-item"><i class="fas fa-users"></i> <?= esc($serie['reparto']) ?></span>
                            <span class="meta-item"><i class="fas fa-tags"></i>
                                <?php foreach ($generos as $index => $genero): ?>
                                    <span><?= $genero['nombre'] ?><?= $index < count($generos) - 1 ? ', ' : '' ?></span>
                                <?php endforeach; ?>
                            </span>
                        </div>
                        <div class="movie-description">
                            <p><?= esc($serie['acercade']) ?></p>
                        </div>
                        <div class="movie-info-extra">
                            <span class="info-tag original-title"><i class="fas fa-globe"></i>Titulo Original: <span style="font-weight: bold;"><?= esc($serie['titulo_original']) ?></span></span>
                            <span class="info-tag quality"><i class="bi bi-film"></i>Calidad: <span style="font-weight: bold;">720p / 1080p</span> </span>
                            <span class="info-tag rating"><i class="fas fa-star"></i>Valoracion (IMDB):<span style="font-weight: bold;">
                                    <?= $serie['valoracion'] ?>/10</span></span>
                        </div>
                    </div>
                </div>

                <h2 class="titulo-sinopsis">Sinopsis</h2>
                <div class="tab-content active" id="about">
                    <div class="movie-synopsis">
                        <?= esc($serie['sinopsis']) ?>
                    </div>
                </div>

                <h2 class="titulo-sinopsis" style="margin-top: 30px;">Trailer</h2>
                <div class="visuales-container">
                    <?php if ($serie['trailer']): ?>
                        <div class="trailer-container">
                            <iframe
                                src="https://www.youtube.com/embed/<?= $serie['trailer'] ?>"
                                title="Trailer de <?= esc($serie['titulo']) ?>"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                $streamsPorIdioma = [];
                foreach ($temporadas as $temporada) {
                    foreach ($temporada['episodios'] as $episodio) {
                        if (!empty($episodio['streams'])) {
                            foreach ($episodio['streams'] as $stream) {
                                $idioma = $stream['idioma'] ?? 'lat';
                                $streamsPorIdioma[$idioma][] = $stream;
                            }
                        }
                    }
                }
                ?>

                <!-- Reproductor de serie -->
                <h2 class="titulo-sinopsis" style="margin-top: 30px;">Reproducir Serie</h2>
                <div class="player-section">
                    <!-- Controles principales en una sola línea -->
                    <div class="player-controls">
                        <div class="season-selector-compact">
                            <label>Selecciona:</label>
                            <select id="season-select" class="season-select-modern">
                                <?php foreach ($temporadas as $temporada): ?>
                                    <option value="<?= $temporada['numero_temporada'] ?>">Temporada <?= $temporada['numero_temporada'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <?php
                        // verificar si hay streams disponibles
                        $hayStreams = false;
                        $idiomasDisponibles = [];
                        foreach ($temporadas as $temporada) {
                            foreach ($temporada['episodios'] as $episodio) {
                                if (!empty($episodio['streams'])) {
                                    $hayStreams = true;
                                    foreach ($episodio['streams'] as $stream) {
                                        $idiomasDisponibles[$stream['idioma']] = true;
                                    }
                                }
                            }
                        }
                        ?>

                        <?php if ($hayStreams && count($idiomasDisponibles) > 1): ?>
                            <div class="language-selector-compact">
                                <label>Idioma:</label>
                                <div class="language-tabs-mini">
                                    <?php foreach ($idiomasDisponibles as $idioma => $value): ?>
                                        <button class="lang-tab <?= $idioma === 'lat' ? 'active' : '' ?>" data-language="<?= $idioma ?>">
                                            <?= $idioma === 'sub' ? 'Subtitulado' : 'Espanol Latino' ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- lista de episodios -->
                    <div class="episodes-list-modern">
                        <?php foreach ($temporadas as $temporada): ?>
                            <div class="season-episodes-modern" data-season="<?= $temporada['numero_temporada'] ?>">
                                <?php foreach ($temporada['episodios'] as $episodio): ?>
                                    <div class="episode-item-modern" data-episode="<?= $episodio['nro_episodio'] ?>">
                                        <div class="episode-number"><?= $episodio['nro_episodio'] ?></div>
                                        <div class="episode-info">
                                            <h4 class="episode-title-modern"><?= esc($episodio['titulo']) ?></h4>
                                            <p class="episode-duration"><?= $episodio['duracion'] ?> min</p>
                                            <?php if (!empty($episodio['sinopsis'])): ?>
                                                <p class="episode-synopsis"><?= esc($episodio['sinopsis']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="episode-actions">
                                            <?php if (!empty($episodio['streams'])): ?>
                                                <!-- boton de main para reproducir -->
                                                <button class="play-episode-btn" data-episode="<?= $episodio['nro_episodio'] ?>">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                                <!-- dropdown con los servidores -->
                                                <div class="servers-dropdown">
                                                    <button class="servers-toggle">
                                                        <i class="fas fa-server"></i>
                                                        <i class="fas fa-chevron-down"></i>
                                                    </button>
                                                    <div class="servers-menu">
                                                        <?php foreach ($episodio['streams'] as $stream): ?>
                                                            <?php if ($stream != null): ?>
                                                                <div class="server-item" data-url="<?= esc($stream['stream_url']) ?>" data-language="<?= $stream['idioma'] ?>">
                                                                    <span class="server-name"><?= esc($stream['server']) ?></span>
                                                                    <span class="server-quality"><?= esc($stream['calidad']) ?></span>
                                                                    <span class="server-lang"><?= $stream['idioma'] === 'sub' ? 'SUB' : 'LAT' ?></span>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="server-item no-stream">
                                                                    <span class="no-stream-text">Sin link disponible</span>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="no-streams-indicator">Sin links.</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- contenedor para el reproductor -->
                    <div id="video-player" class="video-player-container"></div>
                </div>

                <!-- reseñas de usuarios -->
                <div class="seccion-resenas">
                    <h2 class="titulo-sinopsis">Reseñas de usuarios</h2>

                    <div class="estadisticas-resenas">
                        <div class="puntuacion-general">
                            <div class="puntuacion-numero"><?= (number_format($serie['valoracion'], 1) / 2) ?></div>
                            <div class="estrellas">
                                <?php
                                $estrellasLlenas = floor($serie['valoracion'] / 2);
                                $mediaEstrella = (($serie['valoracion'] / 2) - $estrellasLlenas) >= 0.5;

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
                            <div class="total-resenas">Valoración de <?= (number_format($serie['valoracion'], 1) / 2) ?>/10</div>
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
    </section>

    <script>
        window.baseUrl = "<?= base_url() ?>";
        window.serieId = <?= esc($serie['serie_id']) ?>;
        window.guardarResenaUrl = "<?= base_url('serie/' . $serie['serie_id'] . '/guardar-resena') ?>";
        window.isUserLoggedIn = <?= session()->has('user_id') ? 'true' : 'false' ?>;
        window.loginUrl = "<?= base_url('login') ?>";
    </script>
</div>