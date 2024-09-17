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

// Obtener los datos del formulario de edición
$artwork_id = $conn->real_escape_string($_POST['id']);
$artworkName = $conn->real_escape_string($_POST['name']);
$artworkPrice = $conn->real_escape_string($_POST['price']);
$artworkDescription = $conn->real_escape_string($_POST['description']);
$artworkYear = $conn->real_escape_string($_POST['year']);
$artworkStyle = $conn->real_escape_string($_POST['style']);
$artworkAuthor = $conn->real_escape_string($_POST['author']);
$artworkType = $conn->real_escape_string($_POST['type']);

// Actualizar los datos en la base de datos
$query = "UPDATE obrasdearte SET
    Nombre = '$artworkName',
    Precio = '$artworkPrice',
    Descripcion = '$artworkDescription',
    AnoDeCreacion = '$artworkYear',
    Estilo = '$artworkStyle',
    Autor = '$artworkAuthor',
    TipoDeArte = '$artworkType'
    WHERE ID = '$artwork_id'";

$result = $conn->query($query);

if ($result) {
    // Verificar si se ha seleccionado una nueva imagen
    if (!empty($_FILES['image']['name'])) {
        // Procesar y guardar la nueva imagen (ajusta según tus necesidades)
        $target_dir = "assets/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        // Actualizar la columna de imagen en la base de datos
        $conn->query("UPDATE obrasdearte SET Imagen = '$target_file' WHERE ID = '$artwork_id'");
    }

    echo "¡La obra de arte se actualizó correctamente!";
} else {
    echo "Error al actualizar la obra de arte: " . $conn->error;
}

$conn->close();
?>
