<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intermodular";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
