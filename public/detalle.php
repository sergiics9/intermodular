<?php
include 'config.php';

// Recuperar el id del producto desde la URL
if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
} else {
    echo "No se especificó un producto.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Detalles del producto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Hace que los cambios en el CSS se vean reflejados al recargar la página sin necesidad de borrar caché del navegador -->
    <script src="./js/main.js" defer></script>
    <script src="./js/filtro.js" defer></script>

</head>

<body class="body-container">
    <header class="header">
        <div class="logo">
            <a href="./index.php">
                <img src="./images/logo.png" alt="Logo de la tienda" width="300" height="auto">
            </a>
        </div>
        <h1 class="h1-main">STYLESPHERE</h1>
        <nav class="nav">
            <ul>
                <li class="nav-item"><a href="#contacto" class="nav-link">Contacto</a></li>
                <li class="nav-item"><a href="./cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i></a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                    <li class="nav-item"><a href="admin_panel.php" class="nav-link">Admin Panel</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['UsuarioID'])): ?>
                    <li class="nav-item user-info">
                        <img src="images/perfiles/<?php echo $_SESSION['UsuarioID']; ?>.webp" alt="Foto de <?php echo $_SESSION['Nombre']; ?>" class="profile-pic">
                        <p>Hola, <?php echo $_SESSION['Nombre']; ?>!</p>
                    </li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="./login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i></a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="product-details-container">
        <?php
        $sql = "SELECT id, nombre, precio, descripcion FROM productos WHERE id = $id_producto";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row["id"];
            $nombre = $row["nombre"];
            $precio = $row["precio"];
            $descripcion = $row["descripcion"];
            $image_path = "images/{$id}.webp";

            // Consulta para obtener las tallas individuales
            $tallas_sql = "SELECT tallas FROM tallas WHERE id_producto = $id";
            $tallas_result = $conn->query($tallas_sql);
            $tallas_array = [];

            if ($tallas_result->num_rows > 0) {
                while ($row_talla = $tallas_result->fetch_assoc()) {
                    $tallas_array[] = $row_talla["tallas"];
                }
            }
        ?>

            <div class="product-details-flex" data-product-id="<?php echo $id; ?>">
                <div class="product-info">
                    <h3 class="product-name"><?php echo htmlspecialchars($nombre); ?></h3>
                    <p class="descripcion-details"><?php echo htmlspecialchars($descripcion); ?></p>

                    <div class="sizes">
                        <?php foreach ($tallas_array as $talla): ?>
                            <div class="size-option" data-size="<?php echo htmlspecialchars($talla); ?>"><?php echo htmlspecialchars($talla); ?></div>
                        <?php endforeach; ?>
                    </div>

                    <p class="precio-details"><?php echo number_format($precio, 2); ?> €</p>
                    <button class="add-to-cart">Agregar al carrito</button>
                    <div class="links-container">
                        <a href="tabla_tallas.html" class="back-link-modificar-user">Tabla de tallas</a>
                        <a href="index.php" class="back-link-modificar-user2">Volver</a>
                    </div>
                </div>

                <img class="img-details" src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($nombre); ?>">

            </div>

        <?php
        } else {
            echo "<p class='error-message'>No se encontró el producto.</p>";
        }
        ?>
    </main>
</body>

</html>
