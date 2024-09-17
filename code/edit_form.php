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
// Obtener el ID de la obra de arte seleccionada
$artwork_id = $conn->real_escape_string($_POST['id']);

// Obtener los detalles de la obra de arte
$result = $conn->query("SELECT * FROM obrasdearte WHERE ID = '$artwork_id'");
$row = $result->fetch_assoc();

// Mostrar el formulario de edición dentro de un modal
echo '<form id="editForm">';
echo '<div class="form-group">';
echo '<label for="artworkName">Nombre de la Obra de Arte:</label>';
echo '<input type="text" class="form-control" id="artworkName" value="' . $row['Nombre'] . '">';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="artworkPrice">Precio de la Obra de Arte:</label>';
echo '<input type="text" class="form-control" id="artworkPrice" value="' . $row['Precio'] . '">';
echo '</div>';
// Agrega campos adicionales según la descripción de las columnas
echo '<div class="form-group">';
echo '<label for="artworkImage">Imagen de la Obra de Arte:</label>';
echo '<input type="file" class="form-control" id="artworkImage" accept="image/*">';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="artworkDescription">Descripción de la Obra de Arte:</label>';
echo '<textarea class="form-control" id="artworkDescription">' . $row['Descripcion'] . '</textarea>';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="artworkYear">Año de Creación:</label>';
echo '<input type="text" class="form-control" id="artworkYear" value="' . $row['AnoDeCreacion'] . '">';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="artworkStyle">Estilo:</label>';
echo '<input type="text" class="form-control" id="artworkStyle" value="' . $row['Estilo'] . '">';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="artworkAuthor">Autor:</label>';
echo '<input type="text" class="form-control" id="artworkAuthor" value="' . $row['Autor'] . '">';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="artworkType">Tipo de Arte:</label>';
echo '<input type="text" class="form-control" id="artworkType" value="' . $row['TipoDeArte'] . '">';
echo '</div>';
echo '<button type="button" class="btn btn-danger" onclick="deleteArtwork(' . $artwork_id . ')">Eliminar Obra de Arte</button>';
echo '<button type="button" class="btn btn-primary" onclick="updateArtwork(' . $artwork_id . ')">Guardar cambios</button>';
echo '</form>';

$conn->close();
?>
