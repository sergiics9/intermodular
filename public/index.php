<?php
session_start();
include 'config.php';

$busqueda = "";
if (isset($_GET['busqueda'])) {
    $busqueda = $conn->real_escape_string($_GET['busqueda']);
}
$min = isset($_GET['min']) ? (int)$_GET['min'] : 0;
$max = isset($_GET['max']) ? (int)$_GET['max'] : 250;
$orden = isset($_GET['orden']) ? $_GET['orden'] : "";
$categoria = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Home</title>
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

<body>
    <header>
        <div class="logo">
            <a href="./index.php">
                <img src="./images/logo.png" alt="Logo de la tienda" width="300" height="auto">
            </a>
        </div>
        <h1 class="h1-main">STYLESPHERE</h1>
        <nav>
            <div class="flex-busqueda">
                <form class="busqueda" method="GET" action="">
                    <input type="text" name="busqueda" placeholder="Buscar productos..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

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


                            echo "<a href='perfil.php'><img src='$ruta_imagen' alt='Foto de $nombre' class='profile-pic'></a>";
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
    <main>
        <div class="flex-filtro">


            <!-- FILTROS -->
            <section class="filtros">
                <form class="form-filtros" method="GET" id="filtroForm">
                    <input type="hidden" name="categoria" value="<?php echo $categoria; ?>"> <!-- Mantiene la categoría seleccionada -->

                    <label for="precio">Filtrar por precio</label>
                    <div class="range-slider">
                        <input type="range" id="minPrecio" name="min" min="0" max="250" step="1" value="<?php echo $min; ?>">
                        <input type="range" id="maxPrecio" name="max" min="0" max="250" step="1" value="<?php echo $max; ?>">
                        <div class="slider-track"></div>
                    </div>
                    <div class="values">
                        <span id="minValor"><?php echo $min; ?> €</span>
                        <span id="maxValor"><?php echo $max; ?> €</span>
                    </div>

                    <label for="orden">Ordenar por</label>
                    <select class="select-filtro" name="orden" id="orden">
                        <option value="">Nuestra Selección</option>
                        <option value="novedades" <?php if ($orden == "novedades") echo "selected"; ?>>Novedades</option>
                        <option value="nombre_asc" <?php if ($orden == "nombre_asc") echo "selected"; ?>>Nombre (A - Z)</option>
                        <option value="nombre_desc" <?php if ($orden == "nombre_desc") echo "selected"; ?>>Nombre (Z - A)</option>
                        <option value="precio_asc" <?php if ($orden == "precio_asc") echo "selected"; ?>>Precio (Menor > Mayor)</option>
                        <option value="precio_desc" <?php if ($orden == "precio_desc") echo "selected"; ?>>Precio (Mayor > Menor)</option>
                    </select>

                </form>

            </section>

            <section class="header-products">
                <h2 class="h2-main">Lista de Productos</h2>
                <nav class="categorias-nav">
                    <a href="index.php" class="<?php echo empty($categoria) ? 'active' : ''; ?>">Todas</a>
                    <a href="index.php?categoria=1" class="<?php echo ($categoria == 1) ? 'active' : ''; ?>">Camisetas</a>
                    <a href="index.php?categoria=2" class="<?php echo ($categoria == 2) ? 'active' : ''; ?>">Sudaderas</a>
                    <a href="index.php?categoria=3" class="<?php echo ($categoria == 3) ? 'active' : ''; ?>">Gorras</a>
                </nav>
            </section>


        </div>
        <div class="container">
            <?php
            $sql = "SELECT id, nombre, precio FROM productos WHERE precio BETWEEN $min AND $max";

            // Si hay búsqueda, agregar condición
            if (!empty($busqueda)) {
                $sql .= " AND nombre LIKE '%$busqueda%'";
            }

            if (!empty($categoria)) {
                $categoria_id = (int) $categoria; // Convertir a número por seguridad
                $sql .= " AND categoria_id = $categoria_id";
            }



            switch ($orden) {
                case 'nombre_asc':
                    $sql .= " ORDER BY nombre ASC";
                    break;
                case 'nombre_desc':
                    $sql .= " ORDER BY nombre DESC";
                    break;
                case 'precio_asc':
                    $sql .= " ORDER BY precio ASC";
                    break;
                case 'precio_desc':
                    $sql .= " ORDER BY precio DESC";
                    break;
                case 'novedades':
                    $sql .= " ORDER BY fecha_creacion DESC";
                    break;
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $nombre = $row["nombre"];
                    $precio = $row["precio"];
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

                    echo "<div class='product' data-product-id=$id>";
                    echo "<a href='detalle.php?id=" . $id . "' '>";
                    echo "<img src='$image_path' alt='" . htmlspecialchars($nombre) . "'>";
                    echo "</a>";
                    echo "<div class='container-h3'>";
                    echo "<h3>" . htmlspecialchars($nombre) . "</h3>";
                    echo "</div>";

                    // Mostrar las tallas disponibles
                    echo "<div class='sizes'>";
                    foreach ($tallas_array as $talla) {
                        echo "<div class='size-option' data-size='" . htmlspecialchars($talla) . "'>" . htmlspecialchars($talla) . "</div>";
                    }
                    echo "</div>";

                    echo "<p >" . number_format($precio, 2) . " €</p>";
                    echo "<button class='add-to-cart'>Agregar al carrito</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No se encontraron resultados para este producto </p>";
            }
            ?>

        </div>
        </section>
        <hr>

        <section id="contacto">
            <h3>Contacto</h3>
            <form class="form" action="./contacto.php" method="post" id="contact-form">
                <label>Nombre <input name="nombre" type="text" id="nombre" required></label>
                <label>Email <input name="email" type="email" id="email" required></label>
                <label>Mensaje <textarea name="mensaje" id="mensaje" required></textarea></label>
                <button type="submit">Enviar mensaje</button>
            </form>
        </section>
    </main>
    <?php $conn->close(); ?>
</body>

<footer>
    <p>Desarrollada por Sergi Casiano Soler | 1º DAW - 24/25 ♥️</p>
</footer>

</html>
