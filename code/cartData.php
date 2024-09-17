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

// Start the session
session_start();

// Check if user is logged in
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    // Fetch user ID based on email
    $user_email = $_SESSION["username"];
    $user_query = "SELECT ID FROM usuarios WHERE CorreoElectronico = '$user_email'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row["ID"];

        // Query to fetch cart items for the user
        $cart_query = "SELECT obrasdearte.ID, obrasdearte.Nombre, obrasdearte.Precio, obrasdearte.Imagen, obrasdearte.Descripcion, obrasdearte.AnoDeCreacion, obrasdearte.Estilo, obrasdearte.Autor, obrasdearte.TipoDeArte
                       FROM carrito
                       JOIN obrasdearte ON carrito.IDObra = obrasdearte.ID
                       WHERE carrito.IDUsuario = $user_id";

        $cart_result = $conn->query($cart_query);

        if ($cart_result->num_rows > 0) {
            $cart_data = array();
            while ($cart_row = $cart_result->fetch_assoc()) {
                $cart_data[] = $cart_row;
            }

            // Return cart data as JSON
            header('Content-Type: application/json');
            echo json_encode($cart_data);
        } else {
            echo "No items in the cart";
        }
    } else {
        echo "User not found";
    }
} else {
    echo "User not logged in";
}

// Close the database connection
$conn->close();
?>
