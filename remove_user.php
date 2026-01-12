<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = trim($_POST['userId'] ?? '');

    if (empty($userInput)) {
        echo "<script>alert('Please enter a User ID or Email.'); window.history.back();</script>";
        exit;
    }

    if (ctype_digit($userInput)) {
        $userId = intval($userInput);
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
    } else {
        $email = $userInput;
        $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
    }

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('User removed successfully.'); window.location.href='manage_users.html';</script>";
        } else {
            echo "<script>alert('No user found with that ID or email.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error removing user: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
