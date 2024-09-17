<?php
// Database configuration
$servername = "localhost"; // Replace with your MySQL server's hostname
$username = "root"; // Replace with your MySQL username (default is often "root")
$password = ""; // Replace with your MySQL password (default is often empty)
$database = "web_db"; // Replace with your database name

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data from the table
$sql = "SELECT ID, Nombre, Precio, Imagen, Descripcion, AnoDeCreacion, Estilo, Autor, TipoDeArte, Vendida FROM obrasdearte";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "No data found";
}


// Close the database connection
$conn->close();
?>