<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de usuario no válido.");
}

$id = intval($_GET['id']);

// Obtener los datos del usuario
$sql = "SELECT nombre, email, telefono, role FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    die("Usuario no encontrado.");
}

// Si el formulario se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $role = intval($_POST['role']);

    $sqlUpdate = "UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, role = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssii", $nombre, $email, $telefono, $role, $id);

    if ($stmtUpdate->execute()) {
        echo "<p class='success-message'>Usuario actualizado correctamente.</p>";
        echo "<a href='tabla_usuarios.php' class='back-link'>Volver a la lista</a>";
        exit();
    } else {
        echo "<p class='error-message'>Error al actualizar el usuario: " . $conn->error . "</p>";
    }

    $stmtUpdate->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Modificar Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />

    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Hace que los cambios en el CSS se vean reflejados al recargar la página sin necesidad de borrar caché del navegador -->
</head>

<body class="body-modificar-user">
    <h2 class="heading-modificar-user">Modificar Usuario</h2>
    <form method="POST" class="form-modificar-user">
        <label class="label-modificar-user">Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required class="input-modificar-user"></label><br>
        <label class="label-modificar-user">Email: <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required class="input-modificar-user"></label><br>
        <label class="label-modificar-user">Teléfono: <input type="text" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required class="input-modificar-user"></label><br>
        <label class="label-modificar-user">Rol: <br>
            <select name="role" required class="select-modificar-user">
                <option value="0" <?php echo $usuario['role'] == 0 ? 'selected' : ''; ?>>Usuario</option>
                <option value="1" <?php echo $usuario['role'] == 1 ? 'selected' : ''; ?>>Administrador</option>
            </select>
        </label><br>
        <button type="submit" class="submit-button-modificar-user">Actualizar</button>
    </form>
    <a href="tabla_usuarios.php" class="back-link-modificar-user">Volver a la lista</a>
</body>

</html>
