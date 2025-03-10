<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de producto no válido.");
}

$id = intval($_GET['id']);

// Eliminamos el producto
$sql = "DELETE FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<p>Producto eliminado correctamente.</p>";
} else {
    echo "<p>Error al eliminar el producto: " . $conn->error . "</p>";
}

$stmt->close();
$conn->close();

echo "<a href='tabla_productos.php'>Volver a la lista</a>";
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #000;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 99vh;
        text-align: center;
    }
</style>
