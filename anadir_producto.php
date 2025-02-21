<?php
include 'config.php';

$nombre = $precio = $tallas = $descripcion = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre'], $_POST['precio'], $_POST['tallas'], $_POST['descripcion'])) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $precio = floatval($_POST['precio']);
        $tallas = $_POST['tallas'];  // Recibimos las tallas como una cadena separada por comas
        $descripcion = $conn->real_escape_string($_POST['descripcion']); // Capturamos la descripción

        // Insertamos el producto en la tabla productos
        $sql = "INSERT INTO productos (nombre, precio, descripcion) VALUES ('$nombre', $precio, '$descripcion')";

        if ($conn->query($sql) === TRUE) {
            $id = $conn->insert_id; // Obtenemos el id del producto insertado

            // Insertamos cada talla como una fila separada en la tabla 'tallas'
            $tallas_array = explode(",", $tallas);  // Convertimos la cadena de tallas en un array
            foreach ($tallas_array as $talla) {
                $talla = trim($talla);  // Eliminamos espacios extra
                $sql_tallas = "INSERT INTO tallas (id_producto, tallas) VALUES ($id, '$talla')";
                $conn->query($sql_tallas); // Insertamos cada talla en la tabla tallas
            }

            // Subimos la imagen del producto si existe
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $target_dir = "./images/";
                $target_file = $target_dir . $id . ".webp";
                move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);
            }

            // Redirigimos a la página principal
            header("Location: ./index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir producto</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Hace que los cambios en el CSS se vean reflejados al recargar la página sin necesidad de borrar caché del navegador -->
    <script src="./js/main.js" defer></script>
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

    <div class="flex-anadir-producto">
        <section id="agregar-producto">
            <h3 class="h3-agregar">Agregar Producto</h3>
            <form method="POST" class="form-anadir-producto" enctype="multipart/form-data">
                <label>
                    Nombre del Producto:
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </label>
                <label>
                    Precio del Producto:
                    <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($precio); ?>" required>
                </label>
                <label>
                    Tallas disponibles (separadas por comas sin espacios):
                    <input type="text" name="tallas" value="<?php echo htmlspecialchars($tallas); ?>" placeholder="Ej: S,M,L,XL" required>
                </label>
                <label>
                    Descripción del Producto:
                    <textarea name="descripcion" required><?php echo htmlspecialchars($descripcion); ?></textarea>
                </label>
                <label>
                    Imagen del Producto:
                    <input type="file" name="imagen" id="imagen" required>
                </label>
                <button type="submit">Agregar Producto</button>
            </form>

        </section>

        <!-- Sección de vista previa -->
        <!-- Sección de vista previa -->
        <section id="vista-previa">
            <h3>Vista Previa del Producto</h3>
            <div id="preview-container" class="product">
                <div id="preview-info">
                    <img id="preview-image" src="images/placeholder.jpg" alt="Imagen del producto" width="40" height="auto">
                    <h3 id="preview-nombre">Nombre: </h3>
                    <p id="preview-precio">Precio: </p>
                    <p id="preview-tallas">Tallas: </p>
                    <button class="add-to-cart" disabled>Agregar al carrito</button>
                </div>
            </div>
        </section>
    </div>

</body>


</html>
