<footer class="modern-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="footer-title">STYLESPHERE</h5>
                <p class="text-muted">Tu tienda de moda online con las últimas tendencias en ropa y accesorios.</p>
                <div class="mt-3">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>

            <div class="col-md-2 col-6 mb-4 mb-md-0">
                <h5 class="footer-title">Comprar</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_URL ?>/productos/index.php" class="footer-link">Productos</a></li>
                    <li><a href="<?= BASE_URL ?>/categorias/index.php" class="footer-link">Categorías</a></li>
                    <li><a href="#" class="footer-link">Novedades</a></li>
                    <li><a href="#" class="footer-link">Ofertas</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-6 mb-4 mb-md-0">
                <h5 class="footer-title">Ayuda</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">Envíos</a></li>
                    <li><a href="#" class="footer-link">Devoluciones</a></li>
                    <li><a href="#" class="footer-link">Tallas</a></li>
                    <li><a href="<?= BASE_URL ?>/contacto/index.php" class="footer-link">Contacto</a></li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5 class="footer-title">Suscríbete</h5>
                <p class="text-muted">Recibe nuestras novedades y ofertas exclusivas.</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control search-input" placeholder="Tu email" aria-label="Email">
                    <button class="btn btn-primary" type="button">Suscribir</button>
                </div>
            </div>
        </div>

        <div class="row footer-bottom text-center">
            <div class="col-md-6 text-md-start">
                <p class="mb-0">&copy; <?= date('Y'); ?> STYLESPHERE. Todos los derechos reservados.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#" class="footer-link">Términos y Condiciones</a></li>
                    <li class="list-inline-item"><a href="#" class="footer-link">Privacidad</a></li>
                    <li class="list-inline-item"><a href="#" class="footer-link">Cookies</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="<?= BASE_URL ?>/js/main.js"></script>
