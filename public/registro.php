<?php
session_start();
include 'config.php';

// Redirigir a index.php si el usuario ya está logueado
if (isset($_SESSION['UsuarioID'])) {
    header("Location: index.php");
    exit(); // Asegura que el script no siga ejecutándose después de la redirección
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['contraseña'];

    if (empty($nombre) || empty($email) || empty($telefono) || empty($contraseña) || empty($_FILES['foto_perfil']['name'])) {
        echo "Por favor, complete todos los campos y suba una foto de perfil.";
    } else {
        if (!preg_match("/^\d{9}$/", $telefono)) {
            echo "Por favor, ingrese un número de teléfono válido (9 dígitos).";
        } else {
            $hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("SELECT Email FROM Usuarios WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "Este correo electrónico ya está registrado.";
            } else {
                $stmt = $conn->prepare("INSERT INTO Usuarios (nombre, email, telefono, contraseña, role) VALUES (?, ?, ?, ?, 0)");
                $stmt->bind_param("ssss", $nombre, $email, $telefono, $hashed_password);

                if ($stmt->execute()) {
                    $usuario_id = $stmt->insert_id;

                    $directorio = "images/perfiles/";
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }

                    $foto_perfil = $directorio . $usuario_id . ".webp";

                    $tipo_imagen = $_FILES['foto_perfil']['type'];
                    if ($tipo_imagen == "image/jpeg" || $tipo_imagen == "image/png" || $tipo_imagen == "image/webp") {
                        move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
                        header("Location: confirm_registro.php");
                        exit();
                    } else {
                        echo "Formato de imagen no permitido. Usa JPG, PNG o WEBP.";
                    }
                } else {
                    echo "Error al registrar al usuario: " . $conn->error;
                }
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
    <title>Stylesphere | Registro</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

<body>
    <header>
        <div class="logo">
            <a href="./index.php">
                <img src="./images/logo.png" alt="Logo de la tienda" width="300" height="auto">
            </a>
        </div>
        <h1 class="h1-main">STYLESPHERE</h1>
        <nav>
            <ul>
                <li><a href="./index.php#contacto">Contacto</a></li>
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
                            echo "<img src='$ruta_imagen' alt='Foto de $nombre' class='profile-pic'  width='50' height='auto'>";
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
    <hr>
    <h2>Registro</h2>
    <form class="form" action="registro.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        <label for="foto_perfil">Foto de perfil:</label>
        <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" required><br>

        <button type="submit">Registrarse</button>
    </form>
</body>

</html>
