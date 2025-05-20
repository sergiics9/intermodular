<?php
// Improved error display logic
$errors = session()->getFlash('errors') ?? [];
if (!empty($errors)):
?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
