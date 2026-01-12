<?php
session_start();

// Database connection info
$servername = "sql306.infinityfree.com";
$username = "if0_40809241";
$password = "Sweety2005g";
$database = "if0_40809241_kavya";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    die("Error: You must be logged in to change your password.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];

    // Get and sanitize input
    $current_password = $_POST['current'] ?? '';
    $new_password = $_POST['new'] ?? '';
    $confirm_password = $_POST['confirm'] ?? '';

    // Check new password and confirmation match
    if ($new_password !== $confirm_password) {
        die("Error: New password and confirmation do not match.");
    }

    // Fetch current hashed password from database
    $stmt = $conn->prepare("SELECT password1 FROM reg1 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    if (!$stmt->fetch()) {
        $stmt->close();
        die("Error: User not found.");
    }
    $stmt->close();

    // Verify current password
    if (!password_verify($current_password, $hashed_password)) {
        die("Error: Current password is incorrect.");
    }

    // Hash new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in database
    $stmt = $conn->prepare("UPDATE reg1 SET password1 = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_hashed_password, $email);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Password updated successfully!'); window.location.href = 'settings.html';</script>";
    } else {
        echo "Error updating password: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
