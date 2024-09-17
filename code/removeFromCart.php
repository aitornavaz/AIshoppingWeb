<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "web_db";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a session and user ID is stored in the session
session_start();
$userEmail = $_SESSION["username"];

// Get the artworkID from the POST request
$artworkID = $_POST['id'];

// Retrieve the user ID based on the email
$userIDQuery = "SELECT ID FROM usuarios WHERE CorreoElectronico = '$userEmail'";
$userIDResult = $conn->query($userIDQuery);

if ($userIDResult->num_rows > 0) {
    $row = $userIDResult->fetch_assoc();
    $userID = $row['ID'];

    // SQL to remove the artwork from the user's cart
    $sql = "DELETE FROM carrito WHERE IDusuario = '$userID' AND IDobra = '$artworkID'";

    if ($conn->query($sql) === TRUE) {
        // Successfully removed from the cart
        echo json_encode(array('success' => true));
    } else {
        // Failed to remove from the cart
        echo json_encode(array('success' => false, 'error' => $conn->error));
    }
} else {
    // User not found
    echo json_encode(array('success' => false, 'error' => 'User not found'));
}
// Close the database connection
$conn->close();
?>
