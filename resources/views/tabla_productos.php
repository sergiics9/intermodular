<?php
include 'config.php';

$sql = "SELECT id, nombre, precio, descripcion FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Lista de Productos</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Actualización de la cache de CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script>
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
                window.location.href = "borrar_producto.php?id=" + id;
            }
        }
    </script>
</head>

<body class="body-tabla-products">
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
    <h2 class="heading-tabla-products">Lista de Productos</h2>

    <!-- Tabla de productos -->
    <table class="table-products">
        <tr class="table-row-products">
            <th class="table-header-products">ID</th>
            <th class="table-header-products">Nombre</th>
            <th class="table-header-products">Precio</th>
            <th class="table-header-products">Descripción</th>
            <th class="table-header-products">Acción</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr class="table-row-products">
                <td class="table-cell-products"><?php echo $row['id']; ?></td>
                <td class="table-cell-products"><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td class="table-cell-products"><?php echo number_format($row['precio'], 2); ?> €</td>
                <td class="table-cell-products"><?php echo htmlspecialchars($row['descripcion']); ?></td>
                <td class="table-cell-products">
                    <a href="modificar_producto.php?id=<?php echo $row['id']; ?>" class="edit-button-products">Editar</a> |
                    <a href="#" onclick="confirmarEliminacion(<?php echo $row['id']; ?>)" class="delete-button-products">Borrar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Botón para volver al Panel de Administración -->
    <div class="button-container-users">
        <a href="admin_panel.php" class="back-button-users">Volver al Panel de Administración</a>
    </div>
</body>

</html>

<?php $conn->close(); ?>
