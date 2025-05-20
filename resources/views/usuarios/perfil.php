<?php

use App\Core\Auth;

$usuario = $usuario ?? Auth::user();
$errors = escapeArray(session()->getFlash('errors', []));
$old = session()->getFlash('old', []);
?>
<div class="container mt-5">
    <h1>Mi Perfil</h1>
    <?php if (session()->getFlash('success')): ?>
        <div class="alert alert-success"><?= htmlspecialchars(session()->getFlash('success')) ?></div>
    <?php endif; ?>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/usuarios/actualizar-perfil.php" method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <?php
                                $fotoUrl = !empty($usuario['foto']) ? BASE_URL . $usuario['foto'] : BASE_URL . '/images/perfiles/default.webp';
                                ?>
                                <img src="<?= $fotoUrl ?>" alt="Foto de perfil" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cambiar foto de perfil</label>
                                <input type="file" name="foto" class="form-control">
                                <div class="form-text">La imagen se guardará automáticamente con tu ID de usuario.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($old['nombre'] ?? $usuario['nombre']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? $usuario['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" name="telefono" class="form-control" value="<?= htmlspecialchars($old['telefono'] ?? $usuario['telefono']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nueva contraseña (opcional)</label>
                            <input type="password" name="password" class="form-control">
                            <div class="form-text">Deja este campo en blanco si no deseas cambiar tu contraseña.</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
