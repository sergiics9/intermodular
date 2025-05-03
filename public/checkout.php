<?php

session_start();

if (!isset($_SESSION['UsuarioID'])) {
    header("Location: login.php");
    exit();
}

$nombre = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '';
$email = isset($_SESSION['Email']) ? $_SESSION['Email'] : '';
$telefono = isset($_SESSION['Telefono']) ? $_SESSION['Telefono'] : '';



?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Formulario de Compra</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Hace que los cambios en el CSS se vean reflejados al recargar la página sin necesidad de borrar caché del navegador -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />
    <script src="js/cart.js" defer></script>
    <script src="js/main.js" defer></script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php">
                <img src="./images/logo.png" alt="Logo de la tienda" width="300" height="auto">
            </a>
        </div>
        <h1 class="h1-main">STYLESPHERE</h1> <!-- lo mantengo oculto por seo -->
        <nav>
            <ul>
                <li><a href="./index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>
    <hr>
    <main>
        <h2 class="h1-form-compra">Rellena los datos para terminar tu compra</h2>
        <div class="form-container">
            <form class="form" id="formCompra">
                <label>Nombre: <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required></label>
                <label>Email: <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required></label>
                <label>Dirección: <input type="text" name="direccion" id="direccion" required></label>
                <label>Teléfono: <input type="tel" name="telefono" id="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required></label>
                <button type="submit">Finalizar Compra</button>
            </form>
            <div id="order-summary">
                <h3>Resumen del Pedido</h3>
                <div id="cart-items"></div>
                <div id="total-price"></div>
            </div>
        </div>
    </main>
</body>


</html>
