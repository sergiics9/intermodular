<?php
include 'config.php'; // Conexión a la base de datos

// Crear vistas con las consultas SQL proporcionadas
$queries = [
    "CREATE OR REPLACE VIEW cantidad_productos_por_categoria AS
    SELECT c.nombre AS categoria, COUNT(p.id) AS cantidad_productos
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre",

    "CREATE OR REPLACE VIEW precio_promedio_por_categoria AS
    SELECT c.nombre AS categoria, ROUND(AVG(p.precio), 2) AS precio_promedio
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre",

    "CREATE OR REPLACE VIEW categorias_mas_5_productos AS
    SELECT c.nombre AS categoria, COUNT(p.id) AS cantidad_productos
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre
    HAVING COUNT(p.id) > 5",

    "CREATE OR REPLACE VIEW categorias_precio_promedio_mayor_100 AS
    SELECT c.nombre AS categoria, ROUND(AVG(p.precio), 2) AS precio_promedio
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre
    HAVING AVG(p.precio) > 100",

    "CREATE OR REPLACE VIEW producto_mas_caro_por_categoria AS
    SELECT p.nombre AS producto, c.nombre AS categoria, p.precio
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    AND p.precio = (SELECT MAX(precio) FROM productos WHERE categoria_id = p.categoria_id)",

    "CREATE OR REPLACE VIEW cantidad_productos_ordenados AS
    SELECT c.nombre AS categoria, COUNT(p.id) AS cantidad_productos
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre
    ORDER BY cantidad_productos DESC",

    "CREATE OR REPLACE VIEW categorias_producto_mas_barato_mayor_50 AS
    SELECT c.nombre AS categoria, MIN(p.precio) AS precio_minimo
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre
    HAVING MIN(p.precio) > 50",

    "CREATE OR REPLACE VIEW promedio_precio_mas_3_productos AS
    SELECT c.nombre AS categoria, ROUND(AVG(p.precio), 2) AS precio_promedio, COUNT(p.id) AS cantidad_productos
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre
    HAVING COUNT(p.id) > 3",

    "CREATE OR REPLACE VIEW suma_precios_por_categoria AS
    SELECT c.nombre AS categoria, SUM(p.precio) AS total_precio
    FROM productos p, categorias c
    WHERE p.categoria_id = c.id
    GROUP BY c.nombre"
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylesphere | Informes Vistas</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>"> <!-- Evita la caché de CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./images/favicon.svg" />
    <link rel="shortcut icon" href="./images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./images/apple-touch-icon.png" />
    <link rel="manifest" href="./images/site.webmanifest" />

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
</body>

</html>
<?php
// Ejecutar las consultas para crear las vistas
foreach ($queries as $query) {
    if ($conn->query($query) !== TRUE) {
        echo "Error al crear una vista: " . $conn->error . "<br>";
    }
}

// Función para mostrar una vista en tabla con diseño mejorado
function mostrarVista($conn, $vista, $titulo)
{
    echo "<h2 class='heading-tabla-products'>$titulo</h2>";
    $query = "SELECT * FROM $vista";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table class='table-products'>";
        echo "<tr class='table-row-products'>";

        // Encabezados de tabla
        while ($campo = $result->fetch_field()) {
            echo "<th class='table-header-products'>{$campo->name}</th>";
        }
        echo "</tr>";

        // Filas de la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='table-row-products'>";
            foreach ($row as $valor) {
                echo "<td class='table-cell-products'>{$valor}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-data-products'>No hay datos disponibles.</p>";
    }
}

// Mostrar cada vista con los mismos estilos
mostrarVista($conn, "cantidad_productos_por_categoria", "Cantidad de productos por categoría");
mostrarVista($conn, "precio_promedio_por_categoria", "Precio promedio por categoría");
mostrarVista($conn, "categorias_mas_5_productos", "Categorías con más de 5 productos");
mostrarVista($conn, "categorias_precio_promedio_mayor_100", "Categorías con precio medio superior a 100");
mostrarVista($conn, "producto_mas_caro_por_categoria", "Producto más caro por categoría");
mostrarVista($conn, "cantidad_productos_ordenados", "Número de productos por categoría (Ordenado)");
mostrarVista($conn, "categorias_producto_mas_barato_mayor_50", "Categorías donde el producto más barato cuesta más de 50");
mostrarVista($conn, "promedio_precio_mas_3_productos", "Media de precios por categoría con más de 3 productos");
mostrarVista($conn, "suma_precios_por_categoria", "Suma del precio de todos los productos por categoría");

// Botón para volver al Panel de Administración
echo '<div class="button-container-users">
    <a href="admin_panel.php" class="back-button-users">Volver al Panel de Administración</a>
</div>';

$conn->close();
?>
