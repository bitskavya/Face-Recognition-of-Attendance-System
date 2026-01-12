<?php
include 'db_connect.php'; // Make sure this file has your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple server-side validation
    if (!$name || !$email || !$role || !$password) {
        echo "<script>alert('❌ Please fill in all fields.'); window.history.back();</script>";
        exit;
    }

    // Check if email already exists
    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        echo "<script>alert('⚠️ Email already exists.'); window.history.back();</script>";
        $stmtCheck->close();
        $conn->close();
        exit;
    }
    $stmtCheck->close();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $role, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('✅ New user added successfully.'); window.location.href='manage_users.html';</script>";
    } else {
        echo "<script>alert('❌ Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('❌ Invalid request method.'); window.history.back();</script>";
}
?>
