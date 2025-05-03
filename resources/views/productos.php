<?php
// productos.php
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>

<body>
    <h1>Productos</h1>
    <ul>
        <?php foreach ($productos as $producto): ?>
            <li>
                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                <p><?php echo $producto['precio']; ?> €</p>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Categorías</h2>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li><?php echo htmlspecialchars($categoria['nombre']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>
