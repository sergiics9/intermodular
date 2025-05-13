<?php

use App\Core\Auth; ?>
<header class="modern-header sticky-top">
    <div class="container">
        <div class="row py-3 align-items-center">
            <!-- Logo -->
            <div class="col-auto me-auto">
                <a href="<?= BASE_URL ?>/productos" class="d-flex align-items-center text-decoration-none">
                    <img src="<?= BASE_URL ?>/images/logo.png" alt="STYLESPHERE" height="40" class="me-2">
                    <span class="brand-title d-none d-sm-inline">STYLESPHERE</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="col col-md-5 col-lg-4 px-0 px-md-2">
                <form action="<?= BASE_URL . '/productos/search.php'; ?>" method="get" class="search-container">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control search-input" placeholder="Buscar producto" value="<?= htmlspecialchars($q ?? ""); ?>">
                        <button type="submit" class="btn btn-primary search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Actions -->
            <div class="col-auto ms-auto d-flex align-items-center">
                <!-- Dark Mode Toggle -->
                <div class="theme-toggle me-3" id="themeToggle">
                    <i class="fas fa-sun theme-toggle-light"></i>
                    <i class="fas fa-moon theme-toggle-dark"></i>
                </div>

                <!-- Auth & Cart -->
                <?php if (!Auth::check()): ?>
                    <a href="<?= BASE_URL . '/auth/show-login.php'; ?>" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-sign-in-alt"></i><span class="d-none d-md-inline ms-1">Login</span>
                    </a>
                    <a href="<?= BASE_URL . '/auth/show-register.php'; ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus d-inline d-md-none"></i><span class="d-none d-md-inline">Registro</span>
                    </a>
                <?php else: ?>
                    <div class="dropdown me-2">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            <span class="d-none d-md-inline"><?= htmlspecialchars(Auth::user()['nombre']) ?></span>
                            <?php if (Auth::role() === 1): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php endif; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?= BASE_URL . '/pedidos/index.php'; ?>">Mis Pedidos</a></li>
                            <?php if (Auth::role() === 1): ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/productos/create.php'; ?>">Añadir Producto</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/contacto/admin.php'; ?>">Mensajes de Contacto</a></li>
                            <?php endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= BASE_URL . '/auth/logout.php'; ?>">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                    <a href="<?= BASE_URL . '/carrito/index.php'; ?>" class="btn btn-primary btn-sm position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <?php
                        $carrito = session()->get('carrito', []);
                        if (count($carrito) > 0):
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= count($carrito) ?>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-lg navbar-light p-0 mb-3">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern <?= request()->routeIs('/productos/index.php') ? 'active' : '' ?>" href="<?= BASE_URL . '/productos/index.php'; ?>">
                            Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern <?= request()->routeIs('/categorias/index.php') ? 'active' : '' ?>" href="<?= BASE_URL . '/categorias/index.php'; ?>">
                            Categorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-modern <?= request()->routeIs('/contacto/index.php') ? 'active' : '' ?>" href="<?= BASE_URL . '/contacto/index.php'; ?>">
                            Contacto
                        </a>
                    </li>
                    <?php if (Auth::check() && Auth::role() === 1): ?>
                        <li class="nav-item">
                            <a class="nav-link nav-link-modern text-primary" href="<?= BASE_URL . '/productos/create.php'; ?>">
                                <i class="fas fa-plus-circle me-1"></i>Añadir Producto
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>

<script>
    // Initialize theme toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function(event) {
                event.preventDefault();
                const currentTheme = localStorage.getItem('theme') || 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', newTheme);
                document.documentElement.setAttribute('data-theme', newTheme);

                // Apply theme-specific styles
                if (newTheme === 'dark') {
                    document.querySelectorAll('.card').forEach(card => {
                        card.style.backgroundColor = '#1e1e1e';
                        card.style.borderColor = '#2c2c2c';
                    });
                } else {
                    document.querySelectorAll('.card').forEach(card => {
                        card.style.removeProperty('background-color');
                        card.style.removeProperty('border-color');
                    });
                }
            });
        }
    });
</script>
