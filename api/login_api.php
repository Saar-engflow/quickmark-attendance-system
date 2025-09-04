<?php
// login_api.php
session_start();
include "../includes/db_connect.php";

// Return plain text
header('Content-Type: text/plain');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method";
    exit;
}

// Check required POST parameters
if (!isset($_POST['email'], $_POST['password'])) {
    echo "Missing parameters";
    exit;
}

$email = trim($_POST['email']);
$password = $_POST['password'];
$role = 'student'; // Only allow students in this API

// Prepare statement to fetch student
$stmt = $conn->prepare("SELECT user_id, firstName, password, role FROM users WHERE email=? AND role=?");
$stmt->bind_param("ss", $email, $role);
$stmt->execute();
$stmt->bind_result($user_id, $firstName, $hashed_password, $db_role);

if ($stmt->fetch()) {
    if (password_verify($password, $hashed_password)) {
        // Optionally store session for app if needed
        $_SESSION['user_id'] = $user_id;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['role'] = $db_role;

        echo "success"; // Android will read this
    } else {
        echo "Incorrect password";
    }
} else {
    echo "User not found";
}

$stmt->close();
$conn->close();
?>
