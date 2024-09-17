<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "web_db"; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Retrieve username and password from the form
    $username = $_POST["mail"];
    $password = $_POST["password"];

    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
}

?>