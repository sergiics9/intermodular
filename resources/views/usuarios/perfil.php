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
    <form action="<?= BASE_URL ?>/usuarios/actualizar-perfil.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Foto de perfil</label><br>
            <?php if (!empty($usuario['foto'])): ?>
                <img src="<?= BASE_URL . $usuario['foto'] ?>" alt="Foto de perfil" width="100" class="rounded mb-2">
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
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
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>
