<?php
// Get email and password from form
$mail = $_POST['email'] ?? '';
$pwd = $_POST['password1'] ?? '';

// Database connection details
$servername = "sql306.infinityfree.com";
$username = "if0_40809241";
$password = "Sweety2005g";
$database = "if0_40809241_kavya";

// Create connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Use prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT password1 FROM reg1 WHERE email = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($stored_pwd);
    $stmt->fetch();

    // Compare password (supports plain text and hashed passwords)
    $valid = false;
    if (password_verify($pwd, $stored_pwd)) {
        $valid = true;
    } elseif ($pwd === $stored_pwd) {
        $valid = true;
    }

    if ($valid) {
        // ✅ List of admin emails
        $adminEmails = ["srinivasbeerum@gmail.com", "kavyasriganji8790@gmail.com"];

        if (in_array($mail, $adminEmails)) {
            // Redirect to admin dashboard
            header("Location: admin.html");
            exit();
        } else {
            // Redirect to normal user dashboard
            header("Location: dashboard.html");
            exit();
        }
    } else {
        echo "<body bgcolor='blue'><center><h1>Invalid password. Please try again.</h1></center></body>";
    }
} else {
    echo "<body bgcolor='blue'><center><h1>Email not found. Please register first.</h1></center></body>";
}

$stmt->close();
$con->close();
?>
