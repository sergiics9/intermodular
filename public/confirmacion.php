<?php
include 'config.php';

// Obtener el último PedidoID insertado (suponiendo que es el pedido reciente del usuario)
$query = "SELECT PedidoID FROM pedidos ORDER BY PedidoID DESC LIMIT 1";
$resultado = $conn->query($query);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $pedidoID = $fila['PedidoID'];
} else {
    $pedidoID = "No disponible";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Pedido Confirmado</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Hace que los cambios en el CSS se vean reflejados al recargar la página sin necesidad de borrar caché del navegador -->
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
    <section class="section-confirmacion">
        <h2>¡Gracias por tu compra!</h2>
        <p>Tu pedido ha sido registrado con éxito.</p>
        <p><strong>Número de pedido:</strong> #<?php echo $pedidoID; ?></p>
        <button class="add-to-cart"><a class="return" href="index.php">Volver a la tienda</a></button>
    </section>

</body>

</html>
