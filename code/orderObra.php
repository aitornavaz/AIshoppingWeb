<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "web_db";

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

// Assuming you have a session and user ID is stored in the session
session_start();
$userEmail = $_SESSION["username"];

// Retrieve the user ID based on the email
$userIDQuery = "SELECT ID FROM usuarios WHERE CorreoElectronico = '$userEmail'";
$userIDResult = $conn->query($userIDQuery);

if (!($userIDResult->num_rows > 0)) {
    // User not found
    echo json_encode(array('success' => false, 'error' => 'User not found'));
    exit();
}

// Fetch the user ID from the result
$userIDRow = $userIDResult->fetch_assoc();
$userID = $userIDRow['ID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Personal Data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $birthDate = $_POST["birthDate"];
    $nationality = $_POST["nationality"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $streetAddress = $_POST["streetAddress"];
    $city = $_POST["city"];
    $country = $_POST["country"];

    // Payment Data
    $paymentMethod = $_POST["paymentMethod"];
    $additionalInfo = $_POST["additionalInfo"];

    // Get the IDObra values from the carrito table
    $carritoQuery = $conn->query("SELECT IDObra FROM carrito WHERE IDUsuario = $userID");
    $IDObraArray = [];

    while ($row = $carritoQuery->fetch_assoc()) {
        $IDObraArray[] = $row['IDObra'];
    }

    // Save data into the database for each IDObra
    foreach ($IDObraArray as $IDObra) {
        $stmt = $conn->prepare("INSERT INTO compras (ID, IDUsuario, IDObraDeArte, FechaDeCompra, Cantidad, Datos) VALUES (?, ?, ?, NOW(), ?, ?)");

        // Assuming Cantidad is obtained based on your application logic
        $cantidad = 1; // Replace with your logic to get the quantity

        // Combine personal and payment data into a JSON string
        $datos = json_encode([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'birthDate' => $birthDate,
            'nationality' => $nationality,
            'email' => $email,
            'phone' => $phone,
            'streetAddress' => $streetAddress,
            'city' => $city,
            'country' => $country,
            'paymentMethod' => $paymentMethod,
            'additionalInfo' => json_decode($additionalInfo, true) // Decode JSON string
        ]);
        // Get the last inserted ID from obrasdearte
        $lastIDQuery = "SELECT MAX(ID) AS lastID FROM compras";
        $result = $conn->query($lastIDQuery);

        if ($result && $row = $result->fetch_assoc()) {
            $lastID = $row['lastID'];
            $newID = $lastID + 1;
        } else {
            // Default to 1 if no records exist
            $newID = 0;
        }

        $stmt->bind_param("iiiis", $newID, $userID, $IDObra, $cantidad, $datos);

        if ($stmt->execute()) {
            echo "Order placed successfully for IDObra: $IDObra <br>";

            // After successfully inserting into compras, delete from carrito
            $deleteCarritoQuery = "DELETE FROM carrito WHERE IDUsuario = $userID AND IDObra = $IDObra";
            if ($conn->query($deleteCarritoQuery) === TRUE) {
                echo "Deleted from carrito successfully. <br>";
            } else {
                echo "Error deleting from carrito: " . $conn->error . "<br>";
            }

            // Set vendida attribute in obrasdearte to true
            $updateObrasdearteQuery = "UPDATE obrasdearte SET vendida = true WHERE ID = $IDObra";
            if ($conn->query($updateObrasdearteQuery) === TRUE) {
                echo "Updated obrasdearte successfully. <br>";
            } else {
                echo "Error updating obrasdearte: " . $conn->error . "<br>";
            }
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo "Invalid request method!";
}
?>