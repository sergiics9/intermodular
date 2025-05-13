<?php

use App\Core\Auth; ?>
<header class="modern-header">
    <div class="container">
        <div class="row align-items-center py-3">
            <div class="col-md-2 col-6">
                <a href="<?= BASE_URL ?>/productos" class="text-decoration-none">
                    <h3 class="brand-title mb-0">Styleshpere</h3>
                </a>
            </div>
            <div class="col-md-2 col-6 text-center d-none d-md-block">
                <a href="<?= BASE_URL ?>/productos">
                    <img src="<?= BASE_URL ?>/images/logo.png" alt="Logo" width="100" height="auto">
                </a>
            </div>
            <div class="col-md-5 col-12 mt-3 mt-md-0">
                <div class="search-container">
                    <form action="<?= BASE_URL . '/productos/search.php'; ?>" method="get" class="d-flex">
                        <input type="text" name="q" class="form-control search-input flex-grow-1"
                            placeholder="Buscar producto" value="<?= htmlspecialchars($q ?? ""); ?>">
                        <button type="submit" class="btn btn-primary search-button ms-2">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Área de identificación y carrito -->
            <div class="col-md-3 col-12 mt-3 mt-md-0 text-md-end text-center d-flex justify-content-end align-items-center">
                <div class="theme-toggle me-3" id="themeToggle" title="Cambiar tema">
                    <i class="fas fa-moon theme-toggle-dark"></i>
                    <i class="fas fa-sun theme-toggle-light"></i>
                </div>
                <?php if (!Auth::check()): ?>
                    <a href="<?= BASE_URL . '/auth/show-login.php'; ?>" class="btn btn-outline-primary me-2">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="<?= BASE_URL . '/auth/show-register.php'; ?>" class="btn btn-primary">
                        Registro
                    </a>
                <?php else: ?>
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <?php
                            $user = Auth::user();
                            echo htmlspecialchars($user ? $user['nombre'] : 'Usuario');
                            ?>
                            <?php if (Auth::check() && Auth::role() === 1): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php endif; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?= BASE_URL . '/pedidos/index.php'; ?>">Mis Pedidos</a></li>
                            <?php if (Auth::check() && Auth::role() === 1): ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/productos/create.php'; ?>">Añadir Producto</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL . '/contacto/admin.php'; ?>">Mensajes de Contacto</a></li>
                            <?php endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= BASE_URL . '/auth/logout.php'; ?>">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                    <a href="<?= BASE_URL . '/carrito/index.php'; ?>" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Barra de navegación -->
    <div class="container-fluid border-top border-bottom py-2">
        <div class="container">
            <nav class="nav justify-content-center justify-content-md-start">
                <a class="nav-link-modern <?= request()->routeIs('/productos/index.php') ? 'active' : '' ?>"
                    href="<?= BASE_URL . '/productos/index.php'; ?>">
                    Productos
                </a>
                <a class="nav-link-modern <?= request()->routeIs('/categorias/index.php') ? 'active' : '' ?>"
                    href="<?= BASE_URL . '/categorias/index.php'; ?>">
                    Categorías
                </a>
                <a class="nav-link-modern <?= request()->routeIs('/contacto/index.php') ? 'active' : '' ?>"
                    href="<?= BASE_URL . '/contacto/index.php'; ?>">
                    Contacto
                </a>
                <?php if (Auth::check() && Auth::role() === 1): ?>
                    <a class="nav-link-modern text-primary"
                        href="<?= BASE_URL . '/productos/create.php'; ?>">
                        <i class="fas fa-plus-circle me-1"></i>Añadir Producto
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>
