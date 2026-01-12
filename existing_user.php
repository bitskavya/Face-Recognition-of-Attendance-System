<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userIdRaw = trim($_POST['userId'] ?? '');
    
    if (!ctype_digit($userIdRaw)) {
        echo "<script>alert('User ID must be a number.'); window.history.back();</script>";
        exit;
    }
    $userId = intval($userIdRaw);
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($userId && $name && $email && $role) {
        $stmtCheck = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmtCheck->bind_param("si", $email, $userId);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            echo "<script>alert('Email already used by another user.'); window.history.back();</script>";
            $stmtCheck->close();
            $conn->close();
            exit;
        }
        $stmtCheck->close();

        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $name, $email, $role, $hashedPassword, $userId);
        } else {
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $email, $role, $userId);
        }

        if ($stmt->execute()) {
            echo "<script>alert('User details updated successfully.'); window.location.href='manage_users.html';</script>";
        } else {
            echo "<script>alert('Error updating user: " . addslashes($stmt->error) . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
