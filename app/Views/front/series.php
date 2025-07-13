<main class="peliculas-container">
    <!-- menu lateral para filtros -->
    <aside class="filters-sidebar">
        <h3><i class="fas fa-filter"></i> Filtros</h3>

        <!-- barra de busqueda -->
        <div class="media-filter-group">
            <label for="search"><i class="fas fa-search"></i> Buscar</label>
            <input type="text" id="search" placeholder="Nombre de la serie...">
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

    <!-- grid de las series -->
    <section class="movies-grid">
        <div class="grid-header">
            <h2><i class="fas fa-film"></i> Todas las Series</h2>
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
            <div class="movie-card">
                <div class="movie-cover">
                    <img src="https://image.tmdb.org/t/p/original/lA9CNSdo50iQPZ8A2fyVpMvJZAf.jpg" alt="Interstellar">
                    <div class="movie-rating"><i class="fas fa-star"></i> 8.6</div>
                </div>
                <h3 class="movie-title">Twin Peaks</h3>
                <p class="movie-genre">Thriller · 1991</p>
            </div>

            <div class="movie-card">
                <div class="movie-cover">
                    <img src="https://image.tmdb.org/t/p/original/uNctKf62RRL8RKPTrdyFrcttwT2.jpg" alt="The Dark Knight">
                    <div class="movie-rating"><i class="fas fa-star"></i> 9.0</div>
                </div>
                <h3 class="movie-title">Fallout</h3>
                <p class="movie-genre">Acción · 2024</p>
            </div>
        </div>

        <!-- paginacion -->
        <div class="pagination">
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#"><i class="fas fa-chevron-right"></i></a>
        </div>
    </section>
</main>