<main class="peliculas-container">
    <!-- menu lateral para filtros -->
    <aside class="filters-sidebar">
        <h3><i class="fas fa-filter"></i> Filtros</h3>

        <!-- barra de busqueda -->
        <div class="media-filter-group">
            <label for="search"><i class="fas fa-search"></i> Buscar</label>
            <input type="text" id="search" placeholder="Nombre de película...">
        </div>

        <!-- categorias -->
        <div class="media-filter-group">
            <h4><i class="fas fa-tags"></i> Géneros</h4>
            <ul class="filter-list">
                <li><a href="#" class="active">Todas</a></li>
                <li><a href="#">Acción</a></li>
                <li><a href="#">Ciencia Ficción</a></li>
                <li><a href="#">Drama</a></li>
                <li><a href="#">Comedia</a></li>
                <li><a href="#">Terror</a></li>
            </ul>
        </div>

        <!-- año -->
        <div class="media-filter-group">
            <h4><i class="fas fa-calendar-alt"></i> Año</h4>
            <select class="form-select">
                <option selected>Todos</option>
                <option>2020 - 2023</option>
                <option>2010 - 2019</option>
                <option>2000 - 2009</option>
            </select>
        </div>

        <!-- valoracion -->
        <div class="media-filter-group">
            <h4><i class="fas fa-star"></i> Valoracion Minima</h4>
            <div class="rating-filter">
                <input type="range" min="0" max="10" value="7" step="0.5">
                <span>7+</span>
            </div>
        </div>
    </aside>

    <!-- grid de peliculas -->
    <section class="movies-grid">
        <div class="grid-header">
            <h2><i class="fas fa-film"></i> Todas las Películas</h2>
            <div class="sort-options">
                <span>Ordenar:</span>
                <select class="form-select">
                    <option selected>Recientes</option>
                    <option>Mejor Valoradas</option>
                    <option>A-Z</option>
                </select>
            </div>
        </div>

        <div class="grid-content">
            <?php foreach ($movies as $movie): ?>
                <?php if ($movie['activa'] == true): ?>
                    <div class="movie-card">
                        <div class="movie-cover">
                            <img src="<?= $movie['poster'] ?>" alt="<?= $movie['titulo'] ?>">
                            <div class="movie-rating"><i class="fas fa-star"></i> <?= $movie['valoracion'] ?></div>
                        </div>
                        <h3 class="menu-movie-title"><a href="<?= base_url('pelicula/' . $movie['movie_id']) ?>"><?= esc($movie['titulo']) ?></a></h3>
                        <p class="movie-genre">
                            <?php foreach ($movie['generos'] as $index => $genero): ?>
                                <?= esc($genero['nombre']) ?>
                                <?= $index < count($movie['generos']) - 1 ? '·' : '' ?>
                            <?php endforeach; ?>
                            · <?= $movie['año'] ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- paginacion -->
        <!-- paginacion -->
        <div class="pagination">
            <?php if ($currentMoviesPage > 1): ?>
                <a href="<?= base_url('peliculas?movies_page=' . ($currentMoviesPage - 1)) ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalMoviesPage; $i++): ?>
                <a href="<?= base_url('peliculas?movies_page=' . $i) ?>" class="<?= $i == $currentMoviesPage ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentMoviesPage < $totalMoviesPage): ?>
                <a href="<?= base_url('peliculas?movies_page=' . ($currentMoviesPage + 1)) ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
    </section>
</main>