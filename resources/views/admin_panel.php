<?php
session_start();
include 'config.php';

if (!isset($_SESSION['UsuarioID']) || $_SESSION['role'] != 1) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Panel de Administración</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Actualización de la cache de CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" alt="Logo" width="300" height="auto">
            </a>
        </div>
        <h1 class="h1-main">Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
                <li><a href="index.php"><i class="fas fa-home"></i> Volver al Inicio</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="admin-actions">
            <h2>Acciones de Administración</h2>
            <div class="admin-buttons">
                <button class="admin-btn" onclick="location.href='anadir_producto.php'">Añadir Producto</button>
                <button class="admin-btn" onclick="location.href='tabla_productos.php'">Modificar o Borrar un Producto</button>
                <button class="admin-btn" onclick="location.href='tabla_usuarios.php'">Mostrar Usuarios Registrados</button>
                <button class="admin-btn" onclick="location.href='vistas.php'">Informes</button>

            </div>
        </section>


    </main>


</body>

</html>
