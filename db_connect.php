<?php
$servername = "sql306.infinityfree.com";
$username = "if0_40809241";
$password = "Sweety2005g";
$database = "if0_40809241_kavya";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
