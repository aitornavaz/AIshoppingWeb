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

// Assuming you have a session and user email is stored in the session
session_start();
$userEmail = $_SESSION["username"];

// Get the artworkID from the GET request
$artworkID = $_GET['elementID'];

// Retrieve the user ID based on the email
$userIDQuery = "SELECT ID FROM usuarios WHERE CorreoElectronico = '$userEmail'";
$userIDResult = $conn->query($userIDQuery);

if ($userIDResult->num_rows > 0) {
    $row = $userIDResult->fetch_assoc();
    $userID = $row['ID'];

    // Check if the artwork is already in the user's cart
    $checkCartQuery = "SELECT * FROM carrito WHERE IDusuario = '$userID' AND IDobra = '$artworkID'";
    $checkCartResult = $conn->query($checkCartQuery);

    if ($checkCartResult->num_rows > 0) {
        // Artwork is already in the cart
        echo json_encode(array('success' => false, 'message' => 'Item is already in the cart'));
    } else {
        // Check if the artwork is available (vendida is false)
        $checkAvailabilityQuery = "SELECT vendida FROM obrasdearte WHERE ID = '$artworkID'";
        $checkAvailabilityResult = $conn->query($checkAvailabilityQuery);

        if ($checkAvailabilityResult->num_rows > 0) {
            $artworkData = $checkAvailabilityResult->fetch_assoc();
            $isArtworkSold = $artworkData['vendida'];

            if (!$isArtworkSold) {
                // Add the artwork to the user's cart
                $addToCartQuery = "INSERT INTO carrito (IDusuario, IDobra) VALUES ('$userID', '$artworkID')";

                if ($conn->query($addToCartQuery) === TRUE) {
                    // Successfully added to the cart
                    echo json_encode(array('success' => true, 'message' => 'Item added to cart successfully'));
                } else {
                    // Failed to add to the cart
                    echo json_encode(array('success' => false, 'error' => $conn->error));
                }
            } else {
                // Artwork is sold
                echo json_encode(array('success' => false, 'message' => 'Item is sold and cannot be added to the cart'));
            }
        } else {
            // Failed to check availability
            echo json_encode(array('success' => false, 'error' => 'Failed to check artwork availability'));
        }
    }
} else {
    // User not found
    echo json_encode(array('success' => false, 'error' => 'User not found'));
}

// Close the database connection
$conn->close();
?>
