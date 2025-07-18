<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <link href="<?= base_url('assets/css/bootstrap/bootstrap.min.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- seccion del navbar  -->
    <header>
        <div class="logo">
            <a href="<?= base_url('/') ?>"><i class="bi bi-play-circle-fill"></i> FilmStream</a>
        </div>

        <!-- boton del menu hamburguesa -->
        <button class="hamburger" aria-label="Menú" aria-expanded="false">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>

        <nav class="site-navbar">
            <ul>
                <li><a href="<?= base_url('peliculas') ?>"><i class="fas fa-film"></i> Películas</a></li>
                <li><a href="<?= base_url('series') ?>"><i class="fas fa-tv"></i> Series</a></li>
                <?php if (!session()->get('is_active')): ?>
                    <li><a href="<?= base_url('login') ?>"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    <li><a href="<?= base_url('register') ?>" class="btn-register"><i class="fas fa-user-plus"></i> Registrarse</a></li>
                <?php else: ?>
                    <?php if (session()->get('is_admin') != 0): ?>
                        <li><a href="<?= base_url('admin') ?>"><i class="fa-solid fa-user-gear"></i> Admin</a></li>
                    <?php endif; ?>
                    <li><span style="color: #ccc; font-weight: 500; font-size: 16px;">Hola, <?= esc(session()->get('nickname')) ?></span></li>
                    <li><a href="<?= base_url('logout') ?>" class="btn-register"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>