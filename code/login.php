<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "web_db"; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $user_mail = $_POST["username"];
    $user_password = $_POST["password"];

    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_password = md5($user_password);
    $sql = "SELECT * FROM usuarios WHERE CorreoElectronico = '$user_mail' AND Contrasena = '$user_password'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        $_SESSION["username"] = $user_mail;
        if ($row["Admin"] == 1) {
            $_SESSION["admin"] = 1;
        }
        else {
            $_SESSION["admin"] = 0;
        }
        print_r( $result );
        header("Location: index.php");
        exit();
    }
    else {
        echo '<script type="text/javascript">alert("Invalid username or password. Please try again.");</script>';
        header("Location: login.html");
    }
    $conn->close();
}
?>
