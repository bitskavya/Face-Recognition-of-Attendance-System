<?php
// Database connection
$servername = "sql306.infinityfree.com";
$username = "if0_40809241";
$password = "Sweety2005g";
$database = "if0_40809241_kavya";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted (email is required field)
if (isset($_POST['email']) && !empty($_POST['email'])) {

    $firstname = $_POST['firstName'] ?? '';
    $lastname = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $department = $_POST['department'] ?? '';
    $batch = $_POST['batch'] ?? '';

    // Prepare update statement
    $stmt = $conn->prepare("UPDATE reg1 SET firstname=?, lastname=?, phone=?, department=?, batch=? WHERE email=?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $firstname, $lastname, $phone, $department, $batch, $email);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('✅ Profile changes saved successfully!'); window.location.href = 'settings.html';</script>";
        } else {
            echo "No matching record found with this email to update.";
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Email is required to update profile.";
}

$conn->close();
?>
