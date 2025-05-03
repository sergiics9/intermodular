<?php
session_start();

header("Content-Type: application/json");
require "config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['UsuarioID'])) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
    exit;
}

if (!isset($data["nombre"], $data["email"], $data["direccion"], $data["telefono"], $data["carrito"])) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

$usuarioID = $_SESSION['UsuarioID'];
$nombre = $data["nombre"];
$email = $data["email"];
$direccion = $data["direccion"];
$telefono = $data["telefono"];
$carrito = $data["carrito"];

$conn->begin_transaction();

try {
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item["price"] * $item["quantity"];
    }

    // Insertar el pedido
    $stmt = $conn->prepare("INSERT INTO pedidos (UsuarioID, Nombre, Email, Direccion, Telefono, Fecha, Total) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->bind_param("issssd", $usuarioID, $nombre, $email, $direccion, $telefono, $total);
    $stmt->execute();
    $pedido_id = $stmt->insert_id;

    // Insertar los detalles del pedido con talla
    $stmt = $conn->prepare("INSERT INTO detalles_pedido (PedidoID, ProductoID, Cantidad, Precio, Talla) VALUES (?, ?, ?, ?, ?)");
    foreach ($carrito as $item) {
        $productoID = $item["id"];
        $cantidad = $item["quantity"];
        $precio = $item["price"];
        $talla = $item["size"];  // Aquí obtenemos la talla seleccionada para cada producto

        $stmt->bind_param("iiids", $pedido_id, $productoID, $cantidad, $precio, $talla);
        $stmt->execute();
    }

    $conn->commit();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Error al procesar el pedido: " . $e->getMessage()]);
}
