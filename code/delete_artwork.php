<?php
// Database configuration
$servername = "localhost"; // Replace with your MySQL server's hostname
$username = "root"; // Replace with your MySQL username (default is often "root")
$password = ""; // Replace with your MySQL password (default is often empty)
$database = "web_db"; // Replace with your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Obtener el ID de la obra de arte a eliminar
$artwork_id = $conn->real_escape_string($_POST['id']);

// Eliminar la obra de arte de la base de datos
$query = "DELETE FROM obrasdearte WHERE ID = '$artwork_id'";
$result = $conn->query($query);

if ($result) {
    echo "¡La obra de arte se eliminó correctamente!";
} else {
    echo "Error al eliminar la obra de arte: " . $conn->error;
}

$conn->close();
?>
