<?php
session_start();
include 'config.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['UsuarioID'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['UsuarioID'];
$nombre = htmlspecialchars($_SESSION['Nombre']);
$ruta_imagen = "images/perfiles/" . $usuario_id . ".webp";
$mensaje = "";

// Obtener email, teléfono y contraseña actuales
$stmt = $conn->prepare("SELECT email, telefono, contraseña FROM Usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$email_actual = $usuario['email'];
$telefono_actual = $usuario['telefono'];
$contrasena_actual = $usuario['contraseña'];

// Procesar actualización de la foto de perfil, datos y contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cambiar foto de perfil
    if (isset($_FILES['foto_perfil']) && !empty($_FILES['foto_perfil']['name'])) {
        $directorio = "images/perfiles/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $tipo_imagen = $_FILES['foto_perfil']['type'];
        if ($tipo_imagen == "image/jpeg" || $tipo_imagen == "image/png" || $tipo_imagen == "image/webp") {
            $foto_perfil = $directorio . $usuario_id . ".webp";
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
        } else {
            $mensaje = "⚠️ Formato de imagen no permitido. Usa JPG, PNG o WEBP.";
        }
    }

    // Cambiar datos (email y teléfono)
    if (isset($_POST['email']) && isset($_POST['telefono'])) {
        $nuevo_email = trim($_POST['email']);
        $nuevo_telefono = trim($_POST['telefono']);

        if (!filter_var($nuevo_email, FILTER_VALIDATE_EMAIL)) {
            $mensaje = "⚠️ Ingresa un correo electrónico válido.";
        } elseif (!preg_match("/^\d{9}$/", $nuevo_telefono)) {
            $mensaje = "⚠️ Ingresa un número de teléfono válido (9 dígitos).";
        } else {
            // Verificar si el email ya está registrado por otro usuario
            $stmt = $conn->prepare("SELECT id FROM Usuarios WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $nuevo_email, $usuario_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $mensaje = "⚠️ Este correo ya está registrado.";
            } else {
                // Actualizar datos
                $stmt = $conn->prepare("UPDATE Usuarios SET email = ?, telefono = ? WHERE id = ?");
                $stmt->bind_param("ssi", $nuevo_email, $nuevo_telefono, $usuario_id);

                if ($stmt->execute()) {
                    $mensaje = "✅ Datos actualizados correctamente.";
                    $email_actual = $nuevo_email;
                    $telefono_actual = $nuevo_telefono;
                } else {
                    $mensaje = "⚠️ Error al actualizar los datos.";
                }
            }
        }
    }

    // Cambiar contraseña (solo si los campos de contraseña están completos)
    if (
        isset($_POST['contrasena_antigua']) && isset($_POST['contrasena_nueva']) && isset($_POST['contrasena_nueva_confirmacion']) &&
        !empty($_POST['contrasena_antigua']) && !empty($_POST['contrasena_nueva']) && !empty($_POST['contrasena_nueva_confirmacion'])
    ) {
        $contrasena_antigua = $_POST['contrasena_antigua'];
        $contrasena_nueva = $_POST['contrasena_nueva'];
        $contrasena_nueva_confirmacion = $_POST['contrasena_nueva_confirmacion'];

        // Verificar que la contraseña antigua es correcta
        if (!password_verify($contrasena_antigua, $contrasena_actual)) {
            $mensaje = "⚠️ La contraseña antigua no es correcta.";
        } elseif ($contrasena_nueva != $contrasena_nueva_confirmacion) {
            $mensaje = "⚠️ Las contraseñas nuevas no coinciden.";
        } else {
            // Encriptar la nueva contraseña
            $contrasena_encriptada = password_hash($contrasena_nueva, PASSWORD_DEFAULT);

            // Actualizar la contraseña
            $stmt = $conn->prepare("UPDATE Usuarios SET contraseña = ? WHERE id = ?");
            $stmt->bind_param("si", $contrasena_encriptada, $usuario_id);

            if ($stmt->execute()) {
                $mensaje = "✅ Contraseña actualizada correctamente.";
            } else {
                $mensaje = "⚠️ Error al actualizar la contraseña.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Mi Perfil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />
</head>

<body class="body-perfil">
    <div class="profile-container">
        <h2>Perfil de <?php echo $nombre; ?></h2>

        <div class="profile-card">
            <img src="<?php echo file_exists($ruta_imagen) ? $ruta_imagen : 'images/perfiles/default.webp'; ?>" alt="Foto de perfil" class="profile-pic-perfil">

            <form action="perfil.php" method="POST" enctype="multipart/form-data">
                <label for="foto_perfil" class="file-label">Cambiar foto de perfil</label>
                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">

                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" class="input-field" value="<?php echo htmlspecialchars($email_actual); ?>" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="input-field" value="<?php echo htmlspecialchars($telefono_actual); ?>" required>

                <label for="contrasena_antigua">Contraseña antigua:</label>
                <input type="password" id="contrasena_antigua" name="contrasena_antigua" class="input-field">

                <label for="contrasena_nueva">Nueva contraseña:</label>
                <input type="password" id="contrasena_nueva" name="contrasena_nueva" class="input-field">

                <label for="contrasena_nueva_confirmacion">Confirmar nueva contraseña:</label>
                <input type="password" id="contrasena_nueva_confirmacion" name="contrasena_nueva_confirmacion" class="input-field">

                <button type="submit" class="btn">Actualizar Datos</button>
            </form>

            <?php if ($mensaje): ?>
                <p class="mensaje"><?php echo $mensaje; ?></p>
            <?php endif; ?>

            <a href="index.php" class="back-link">← Volver al inicio</a>
        </div>
    </div>
</body>

</html>
