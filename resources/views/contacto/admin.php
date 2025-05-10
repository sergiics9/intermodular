<?php

use App\Core\Auth;

// Verificar permisos de administrador
if (!Auth::check() || Auth::role() !== 1) {
    redirect('/productos/index.php')->with('error', 'No tienes permisos para acceder a esta página')->send();
}
?>

<div class="container mt-5">
    <h1 class="mb-4">Mensajes de Contacto</h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <?php if (empty($mensajes)): ?>
        <div class="alert alert-info">
            No hay mensajes de contacto.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mensajes as $mensaje): ?>
                        <tr>
                            <td><?= $mensaje->id ?></td>
                            <td><?= htmlspecialchars($mensaje->nombre) ?></td>
                            <td><?= htmlspecialchars($mensaje->email) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($mensaje->fecha_envio)) ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $mensaje->id ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $mensaje->id ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal para ver el mensaje -->
                        <div class="modal fade" id="viewModal<?= $mensaje->id ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $mensaje->id ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewModalLabel<?= $mensaje->id ?>">Mensaje de <?= htmlspecialchars($mensaje->nombre) ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Email:</strong> <?= htmlspecialchars($mensaje->email) ?></p>
                                        <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($mensaje->fecha_envio)) ?></p>
                                        <p><strong>Mensaje:</strong></p>
                                        <div class="p-3 bg-light rounded">
                                            <?= nl2br(htmlspecialchars($mensaje->mensaje)) ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <a href="mailto:<?= htmlspecialchars($mensaje->email) ?>" class="btn btn-primary">Responder por Email</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para eliminar el mensaje -->
                        <div class="modal fade" id="deleteModal<?= $mensaje->id ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $mensaje->id ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?= $mensaje->id ?>">Confirmar eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar este mensaje de contacto?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="<?= BASE_URL ?>/contacto/destroy.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $mensaje->id ?>">
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
