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
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="./js/main.js" defer></script>

</head>

<body class="body-container">
    <header>
        <div class="logo">
            <a href="./index.php">
                <img src="./images/logo.png" alt="Logo de la tienda" width="300" height="auto">
            </a>
        </div>
        <h1 class="h1-main">STYLESPHERE</h1>
        <nav>
            <ul>
                <li><a href="#contacto">Contacto</a></li>
                <li><a href="./cart.php"><i class="fas fa-shopping-cart"></i></a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                    <li><a href="admin_panel.php">Admin Panel</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['UsuarioID'])): ?>
                    <li class="user-info">
                        <?php
                        $usuario_id = $_SESSION['UsuarioID'];
                        $nombre = htmlspecialchars($_SESSION['Nombre']);
                        $ruta_imagen = "images/perfiles/" . $usuario_id . ".webp";

                        if (file_exists($ruta_imagen)) {

                            echo "<img src='$ruta_imagen' alt='Foto de $nombre' class='profile-pic'>";
                        } else {
                            echo "<img src='images/perfiles/default.webp' alt='Foto por defecto' class='profile-pic' width='50' height='auto'>";
                        }
                        ?>
                        <p>Hola, <?php echo $nombre; ?>!</p>
                    </li>
                    <li><a href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="./login.php"><i class="fas fa-sign-in-alt"></i></a></li>
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

            echo "<div class='descripcion-container'><p class='descripcion-details'>" . htmlspecialchars($descripcion) . "</p></div>";
            echo "<div class='product-details-flex' data-product-id=$id>";


            echo "<img class='img-details' src='$image_path' alt='" . htmlspecialchars($nombre) . "'>";


            echo "<div class='product-info'>";
            echo "<h3>" . htmlspecialchars($nombre) . "</h3>";


            // Mostrar las tallas disponibles
            echo "<div class='sizes'>";
            foreach ($tallas_array as $talla) {
                echo "<div class='size-option' data-size='" . htmlspecialchars($talla) . "'>" . htmlspecialchars($talla) . "</div>";
            }
            echo "</div>";

            echo "<p class='precio-details'>" . number_format($precio, 2) . " €</p>";
            echo "<button class='add-to-cart'>Agregar al carrito</button>";
            echo "<a href='tabla_tallas.html' class='cancel-button-modificar-product'>Tabla de tallas</a>";

            echo "</div>";

            echo "</div>";
        } else {
            echo "<p class='error-message'>No se encontró el producto.</p>";
        }
        ?>
    </main>
</body>

</html>
