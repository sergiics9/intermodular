<?php
include 'config.php';

$sql = "SELECT id, nombre, email, telefono, role FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Lista de Usuarios</title>
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

    <script>
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
                window.location.href = "borrar_usuario.php?id=" + id;
            }
        }
    </script>
</head>

<body class="body-tabla-users">
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
    <h2 class="heading-tabla-users">Lista de Usuarios</h2>

    <!-- Tabla de usuarios -->
    <table class="table-users">
        <tr class="table-row-users">
            <th class="table-header-users">ID</th>
            <th class="table-header-users">Nombre</th>
            <th class="table-header-users">Email</th>
            <th class="table-header-users">Teléfono</th>
            <th class="table-header-users">Rol</th>
            <th class="table-header-users">Acción</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr class="table-row-users">
                <td class="table-cell-users"><?php echo $row['id']; ?></td>
                <td class="table-cell-users"><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td class="table-cell-users"><?php echo htmlspecialchars($row['email']); ?></td>
                <td class="table-cell-users"><?php echo htmlspecialchars($row['telefono']); ?></td>
                <td class="table-cell-users"><?php echo $row['role'] == 1 ? 'Administrador' : 'Usuario'; ?></td>
                <td class="table-cell-users">
                    <a href="modificar_usuario.php?id=<?php echo $row['id']; ?>" class="edit-button-users">Editar</a> |
                    <a href="#" onclick="confirmarEliminacion(<?php echo $row['id']; ?>)" class="delete-button-users">Borrar</a>
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
