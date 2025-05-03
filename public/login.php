<?php
session_start();
include 'config.php';


if (isset($_SESSION['UsuarioID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    if (empty($email) || empty($contraseña)) {
        echo "Por favor, ingrese su correo electrónico y contraseña.";
    } else {
        $stmt = $conn->prepare("SELECT id, Nombre, contraseña, role, telefono FROM Usuarios WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($contraseña, $user['contraseña'])) {
                $_SESSION['UsuarioID'] = $user['id'];
                $_SESSION['Nombre'] = $user['Nombre'];
                $_SESSION['Email'] = $email;
                $_SESSION['Telefono'] = $user['telefono'];
                $_SESSION['role'] = $user['role'];

                error_log("Sesión iniciada: " . print_r($_SESSION, true)); // Depuración


                if ($_SESSION['role'] == 1) {
                    header("Location: index.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "Usuario no encontrado";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Login</title>
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
    <h2>Iniciar sesión</h2>
    <form class="form" action="login.php" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br>

        <button type="submit">Iniciar sesión</button><br>
        <div class="ancord-registro">
            <hr class="hr-registro">
            <a href="registro.php">No tienes cuenta? Registrate aquí</a>
        </div>
    </form>
</body>

</html>
