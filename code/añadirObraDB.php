<?php
// Database configuration
$servername = "localhost"; // Replace with your MySQL server's hostname
$username = "root"; // Replace with your MySQL username (default is often "root")
$password = ""; // Replace with your MySQL password (default is often empty)
$database = "gpi"; // Replace with your database name
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to safely escape data
function sanitizeInput($input) {
    global $conn;
    return $conn->real_escape_string($input);
}


// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $price = sanitizeInput($_POST["price"]);
    $image = sanitizeInput($_FILES["image"]["name"]); // Assuming your file input has the name "image"
    $description = sanitizeInput($_POST["description"]);
    $year = sanitizeInput($_POST["year"]);
    $style = sanitizeInput($_POST["style"]);
    $author = sanitizeInput($_POST["author"]);
    $artType = sanitizeInput($_POST["artType"]);

    // Upload image to a folder on the server
    $targetDirectory = "assets/images/"; // Create this directory in your project
    $targetFile = $targetDirectory . basename($image);

    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    // Get the last inserted ID from obrasdearte
    $lastIDQuery = "SELECT MAX(ID) AS lastID FROM obrasdearte";
    $result = $conn->query($lastIDQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $lastID = $row['lastID'];
        $newID = $lastID + 1;
    } else {
        // Default to 1 if no records exist
        $newID = 0;
    }

    // Insert data into the database with the new ID
    $sql = "INSERT INTO obrasdearte (ID, Nombre, Precio, Imagen, Descripcion, AnoDeCreacion, Estilo, Autor, TipoDeArte)
            VALUES ($newID, '$name', $price, '$image', '$description', $year, '$style', '$author', '$artType')";
            

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
