<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Variable: $title -->
    <title><?= $title ?? 'STYLESPHERE | Inicio' ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/images/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/images/apple-touch-icon.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/app.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php require __DIR__ . '/partials/header.php'; ?>

    <main class="flex-grow-1 py-4">
        <!-- Variable: $content -->
        <?= $content ?>
    </main>

    <?php require __DIR__ . '/partials/footer.php'; ?>

</body>

</html>
