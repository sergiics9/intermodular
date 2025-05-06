<div class="container mt-4">
    <h2 class="mb-4"><?= "Resultados para '$q'" ?></h2>

    <?php if (session()->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($peliculas)): ?>
        <p>No se encontraron resultados para "<?= htmlspecialchars($q) ?>".</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($peliculas as $pelicula): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title"><?= htmlspecialchars($pelicula->titulo) ?></h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text"><strong>Estreno:</strong> <?= htmlspecialchars($pelicula->estreno) ?></p>
                            <p class="card-text"><strong>Duración:</strong> <?= htmlspecialchars($pelicula->duracion) ?> minutos</p>
                            <p class="card-text"><strong>Sinopsis:</strong> <?= htmlspecialchars($pelicula->sinopsis) ?></p>
                        </div>
                        <div class="card-footer mt-auto">
                            <a href="show.php?id=<?= $pelicula->id ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="edit.php?id=<?= $pelicula->id ?>" class="btn btn-warning btn-sm">Editar</a>
                            <form action="destroy.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $pelicula->id ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    
         <!-- Paginación -->
         <div class="d-flex justify-content-center align-items-center mt-4">
            <?php if ($page > 1): ?>
                <a href="?q=<?= urlencode($q) ?>&page=<?= $page - 1 ?>" class="text-decoration-none me-4">&laquo; Anterior</a>
            <?php endif; ?>
    
            <span>Página <?= $page ?> de <?= $totalPages ?></span>
    
            <?php if ($page + 1 <= $totalPages): ?>
                <a href="?q=<?= urlencode($q) ?>&page=<?= $page + 1 ?>" class="text-decoration-none ms-4">Siguiente &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
