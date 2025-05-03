<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de producto no válido.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado.");
}

$stmt->close();

// Si el formulario se ha enviado, actualizamos el producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre'], $_POST['precio'], $_POST['descripcion'])) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $precio = floatval($_POST['precio']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);

        $sql_update = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sdsi", $nombre, $precio, $descripcion, $id);

        if ($stmt_update->execute()) {
            echo "<p class='success-message-products'>Producto actualizado correctamente.</p>";
            echo "<a href='tabla_productos.php' class='back-button-products'>Volver a la lista</a>";
        } else {
            echo "<p class='error-message-products'>Error al actualizar el producto: " . $conn->error . "</p>";
        }

        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Editar Producto</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body class="body-modificar-product">
    <h2 class="heading-modificar-product">Editar Producto</h2>
    <form method="POST" class="form-modificar-product">
        <label class="label-modificar-product">
            Nombre del Producto:
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" class="input-modificar-product" required>
        </label>
        <label class="label-modificar-product">
            Precio del Producto:
            <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" class="input-modificar-product" required>
        </label>
        <label class="label-modificar-product">
            Descripción del Producto:
            <textarea name="descripcion" class="textarea-modificar-product" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        </label>
        <button type="submit" class="submit-button-modificar-product">Guardar Cambios</button>
    </form>
    <a href="tabla_productos.php" class="cancel-button-modificar-product">Cancelar</a>
</body>

</html>

<?php $conn->close(); ?>
