<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - Error 404</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
    <style>
        .error-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 0;
        }

        .error-message {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <div class="container error-container">
        <h1 class="error-code">404</h1>
        <p class="error-message">Página no encontrada</p>
        <div class="mb-4">
            <p>La página que estás buscando no existe o ha sido movida.</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>" class="btn btn-primary">Volver al inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
