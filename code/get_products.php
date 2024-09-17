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

// Obtener la lista completa de obras de arte
$result = $conn->query("SELECT * FROM obrasdearte");

// Mostrar las obras de arte
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="artwork">';
        echo '<p>' . $row['Nombre'] . '</p>';
        echo '<button class="edit-btn" data-id="' . $row['ID'] . '">Editar</button>';
        echo '</div>';
    }
} else {
    echo 'No se encontraron obras de arte.';
}

$conn->close();
?>
