<meta name="base-url" content="<?= base_url() ?>">

<main class="admin-container">
    <div class="admin-header">
        <div class="admin-header-content">
            <div class="header-left">
                <h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>
                <p>Administra usuarios registrados en FilmStream</p>
            </div>
            <div class="header-right">
                <a href="<?= base_url('admin/usuarios/crear') ?>" class="admin-btn success">
                    <i class="fas fa-user-plus"></i> Crear Usuario
                </a>
                <a href="<?= base_url('admin') ?>" class="admin-btn secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Panel
                </a>
            </div>
        </div>
    </div>

    <!-- mensajes de success o error -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- filtros y busqueda de usuarios -->
    <div class="admin-filters">
        <form method="get" class="filter-group">
            <input type="text" name="search" value="<?= esc($current_search ?? '') ?>"
                placeholder="Buscar por nombre o email..." class="search-input">
            <select name="status" class="filter-select">
                <option value="">Todos los estados</option>
                <option value="1" <?= ($current_status === '1') ? 'selected' : '' ?>>Activos</option>
                <option value="0" <?= ($current_status === '0') ? 'selected' : '' ?>>Inactivos</option>
            </select>
            <select name="role" class="filter-select">
                <option value="">Todos los roles</option>
                <option value="1" <?= ($current_role === '1') ? 'selected' : '' ?>>Administradores</option>
                <option value="0" <?= ($current_role === '0') ? 'selected' : '' ?>>Usuarios</option>
            </select>
            <button type="submit" class="admin-btn primary">
                <i class="fas fa-search"></i> Buscar
            </button>
            <a href="<?= base_url('admin/usuarios') ?>" class="admin-btn secondary">
                <i class="fas fa-times"></i> Limpiar
            </a>
        </form>
    </div>

    <!-- estadisticas -->
    <div class="users-stats">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3><?= isset($usuarios_activos) ? $usuarios_activos : 0 ?></h3>
                <p>Usuarios Activos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stat-info">
                <h3><?= isset($usuarios_inactivos) ? $usuarios_inactivos : 0 ?></h3>
                <p>Usuarios Inactivos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-info">
                <h3><?= isset($total_admins) ? $total_admins : 0 ?></h3>
                <p>Administradores</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?= isset($total_usuarios) ? $total_usuarios : 0 ?></h3>
                <p>Total Usuarios</p>
            </div>
        </div>
    </div>

    <!-- tabla de usuarios -->
    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Registro</th>
                    <th>Último Login</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($usuarios) && is_array($usuarios) && !empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <?php if (is_array($usuario)): ?>
                            <tr id="usuario-<?= $usuario['user_id'] ?>">
                                <td>#<?= str_pad($usuario['user_id'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td>
                                    <div class="user-avatar">
                                        <?php if (!empty($usuario['user_img'])): ?>
                                            <img src="<?= base_url('uploads/avatars/' . $usuario['user_img']) ?>" alt="Avatar">
                                        <?php else: ?>
                                            <div class="avatar-placeholder">
                                                <?= strtoupper(substr($usuario['nickname'], 0, 2)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <strong><?= esc($usuario['nickname']) ?></strong>
                                    </div>
                                </td>
                                <td><?= esc($usuario['email']) ?></td>
                                <td>
                                    <span class="status-badge <?= $usuario['is_active'] ? 'active' : 'inactive' ?>">
                                        <i class="fas fa-circle"></i>
                                        <?= $usuario['is_active'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="role-badge <?= $usuario['is_admin'] ? 'admin' : 'user' ?>">
                                        <i class="fas <?= $usuario['is_admin'] ? 'fa-crown' : 'fa-user' ?>"></i>
                                        <?= $usuario['is_admin'] ? 'Admin' : 'Usuario' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (isset($usuario['created_at'])): ?>
                                        <?= date('d/m/Y', strtotime($usuario['created_at'])) ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($usuario['last_login']) && $usuario['last_login']): ?>
                                        <?= time_elapsed_string($usuario['last_login']) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Nunca</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= base_url('admin/usuarios/ver/' . $usuario['user_id']) ?>"
                                            class="action-btn view" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/usuarios/editar/' . $usuario['user_id']) ?>"
                                            class="action-btn edit" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn <?= $usuario['is_active'] ? 'warning' : 'success' ?>"
                                            title="<?= $usuario['is_active'] ? 'Desactivar' : 'Activar' ?>"
                                            onclick="cambiarEstado(<?= $usuario['user_id'] ?>)">
                                            <i class="fas <?= $usuario['is_active'] ? 'fa-ban' : 'fa-check' ?>"></i>
                                        </button>
                                        <?php if ($usuario['user_id'] != session()->get('user_id')): ?>
                                            <button class="action-btn delete" title="Eliminar"
                                                onclick="confirmarEliminacion(<?= $usuario['user_id'] ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">
                            <p>No se encontraron usuarios.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <?php if (isset($pager)): ?>
        <div class="pagination-container">
            <div class="pagination-info">
                Mostrando resultados de la búsqueda
            </div>
            <div class="pagination">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</main>

<!-- Modal de confirmación -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h3>
        </div>
        <div class="modal-body">
            <p>¿Estás seguro de que deseas eliminar este usuario?</p>
            <p class="warning-text">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button class="admin-btn secondary" onclick="cerrarModal()">Cancelar</button>
            <button class="admin-btn danger" onclick="eliminarUsuario()">Eliminar</button>
        </div>
    </div>
</div>