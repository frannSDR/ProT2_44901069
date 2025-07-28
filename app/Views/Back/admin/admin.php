<main class="admin-container">
    <div class="admin-header">
        <h1><i class="fa-solid fa-user-gear"></i> Panel de Administración</h1>
        <p>Gestiona el contenido de FilmStream</p>
    </div>

    <!-- estadisticas -->
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-film"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_movies ?></h3>
                <p>Películas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tv"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_series ?></h3>
                <p>Series</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?= $total_usuarios ?></h3>
                <p>Usuarios</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <h3>5,420</h3>
                <p>Reseñas</p>
            </div>
        </div>
    </div>

    <!-- dashboard de administracion -->
    <div class="admin-menu">
        <div class="admin-section">
            <h2><i class="fas fa-film"></i> Gestión de Películas</h2>
            <p>Administra el catálogo de películas</p>
            <div class="admin-actions">
                <a href="<?= base_url('admin/peliculas') ?>" class="admin-btn primary">
                    <i class="fas fa-list"></i> Ver Todas
                </a>
                <a href="<?= base_url('admin/peliculas/agregar') ?>" class="admin-btn success">
                    <i class="fas fa-plus"></i> Agregar Nueva
                </a>
            </div>
        </div>

        <div class="admin-section">
            <h2><i class="fas fa-tv"></i> Gestión de Series</h2>
            <p>Administra el catálogo de series y episodios</p>
            <div class="admin-actions">
                <a href="<?= base_url('admin/series') ?>" class="admin-btn primary">
                    <i class="fas fa-list"></i> Ver Todas
                </a>
                <a href="<?= base_url('admin/series/agregar') ?>" class="admin-btn success">
                    <i class="fas fa-plus"></i> Agregar Nueva
                </a>
            </div>
        </div>

        <div class="admin-section">
            <h2><i class="fas fa-users"></i> Gestión de Usuarios</h2>
            <p>Administra usuarios y permisos</p>
            <div class="admin-actions">
                <a href="<?= base_url('admin/usuarios') ?>" class="admin-btn primary">
                    <i class="fas fa-list"></i> Ver Todos
                </a>
                <a href="<?= base_url('admin/usuarios/crear') ?>" class="admin-btn success">
                    <i class="fas fa-user-plus"></i> Crear Usuario
                </a>
            </div>
        </div>

        <div class="admin-section">
            <h2><i class="fas fa-tags"></i> Gestión de Géneros</h2>
            <p>Administra categorías y géneros</p>
            <div class="admin-actions">
                <a href="<?= base_url('admin/generos') ?>" class="admin-btn primary">
                    <i class="fas fa-list"></i> Ver Todos
                </a>
                <a href="<?= base_url('admin/generos/agregar') ?>" class="admin-btn success">
                    <i class="fas fa-plus"></i> Agregar Género
                </a>
            </div>
        </div>

        <div class="admin-section">
            <h2><i class="fas fa-comments"></i> Gestión de Reseñas</h2>
            <p>Moderar comentarios y reseñas</p>
            <div class="admin-actions">
                <a href="<?= base_url('admin/reviews') ?>" class="admin-btn primary">
                    <i class="fas fa-list"></i> Ver Todas
                </a>
                <a href="<?= base_url('admin/reviews/pendientes') ?>" class="admin-btn warning">
                    <i class="fas fa-clock"></i> Pendientes <span class="badge">12</span>
                </a>
            </div>
        </div>

        <div class="admin-section">
            <h2><i class="fas fa-chart-bar"></i> Reportes</h2>
            <p>Estadísticas y análisis del sitio</p>
            <div class="admin-actions">
                <a href="<?= base_url('admin/reportes') ?>" class="admin-btn info">
                    <i class="fas fa-chart-line"></i> Ver Reportes
                </a>
                <a href="<?= base_url('admin/backup') ?>" class="admin-btn secondary">
                    <i class="fas fa-download"></i> Backup BD
                </a>
            </div>
        </div>
    </div>

    <!--actividad reciente -->
    <div class="recent-activity">
        <h2><i class="fas fa-history"></i> Actividad Reciente</h2>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon success">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="activity-content">
                    <p><strong>Nueva película agregada:</strong> "Dune: Part Two"</p>
                    <span class="activity-time">Hace 2 horas</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon warning">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="activity-content">
                    <p><strong>Serie actualizada:</strong> "The Last of Us - Temporada 2"</p>
                    <span class="activity-time">Hace 4 horas</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon danger">
                    <i class="fas fa-trash"></i>
                </div>
                <div class="activity-content">
                    <p><strong>Usuario eliminado:</strong> usuario_spam_123</p>
                    <span class="activity-time">Hace 1 día</span>
                </div>
            </div>
        </div>
    </div>
</main>