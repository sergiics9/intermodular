<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : null;

    if (empty($nombre) || empty($email) || empty($mensaje)) {
        echo "<p>Error: Todos los campos son obligatorios.</p>";
        echo "<a href='./index.php'><button>Volver al inicio</button></a>";
        exit();
    }

    try {
        $sqlInsert = "INSERT INTO Contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("sss", $nombre, $email, $mensaje);
        $stmtInsert->execute();

        echo "<p>Mensaje enviado con éxito.</p>";
        echo "<a href='./index.php'><button>Volver al inicio</button></a>";
    } catch (mysqli_sql_exception $e) {
        echo "<p>Error en la base de datos: " . $e->getMessage() . "</p>";
        echo "<a href='./index.php'><button>Volver al inicio</button></a>";
    }

    if (isset($stmtInsert)) {
        $stmtInsert->close();
    }
}

$conn->close();
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

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
