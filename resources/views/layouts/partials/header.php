<?php

use App\Core\Auth; ?>
<header class="bg-dark text-white pt-2 pb-0">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-3">
                <a href="<?= BASE_URL ?>" class="text-white text-decoration-none">
                    <h3>Tienda Online</h3>
                </a>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <form action="<?= BASE_URL . '/productos/search.php'; ?>" method="get" class="d-flex w-100" style="max-width: 500px;">
                    <input type="text" name="q" class="form-control me-2" placeholder="Buscar producto" value="<?= htmlspecialchars($q ?? ""); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Área de identificación y carrito -->
            <div class="col-3 text-end">
                <?php if (!Auth::check()): ?>
                    <a href="<?= BASE_URL . '/auth/show-login.php'; ?>" class="btn btn-outline-light me-2">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="<?= BASE_URL . '/auth/show-register.php'; ?>" class="btn btn-primary">
                        Registro
                    </a>
                <?php else: ?>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?= htmlspecialchars(Auth::user()['nombre']) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?= BASE_URL . '/pedidos/index.php'; ?>">Mis Pedidos</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= BASE_URL . '/auth/logout.php'; ?>">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                    <a href="<?= BASE_URL . '/carrito/index.php'; ?>" class="btn btn-primary ms-2">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Barra de navegación -->
    <nav class="mt-2" style="background-color: #343a40;">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link <?= request()->routeIs('/productos/index.php') ? 'bg-white text-dark rounded-top' : 'text-white' ?>"
                    href="<?= BASE_URL . '/productos/index.php'; ?>">
                    Productos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= request()->routeIs('/categorias/index.php') ? 'bg-white text-dark rounded-top' : 'text-white' ?>"
                    href="<?= BASE_URL . '/categorias/index.php'; ?>">
                    Categorías
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= request()->routeIs('/contacto/index.php') ? 'bg-white text-dark rounded-top' : 'text-white' ?>"
                    href="<?= BASE_URL . '/contacto/index.php'; ?>">
                    Contacto
                </a>
            </li>
            <?php if (Auth::check() && Auth::role() === 1): ?>
                <li class="nav-item">
                    <a class="nav-link text-warning"
                        href="<?= BASE_URL . '/productos/create.php'; ?>">
                        Añadir Producto
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
