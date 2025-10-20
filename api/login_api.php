<?php
// login_api.php
session_start();
include "../includes/db_connect.php";

// Return JSON
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Check required POST parameters
if (!isset($_POST['email'], $_POST['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    exit;
}

$email = trim($_POST['email']);
$password = $_POST['password'];
$role = 'student'; // Only allow students in this API

// Prepare statement to fetch student
$stmt = $conn->prepare("SELECT user_id, firstName, lastName, password, role FROM users WHERE email=? AND role=?");
$stmt->bind_param("ss", $email, $role);
$stmt->execute();
$stmt->bind_result($user_id, $firstName, $lastName, $hashed_password, $db_role);

if ($stmt->fetch()) {
    if (password_verify($password, $hashed_password)) {
        // Store session if needed
        $_SESSION['user_id'] = $user_id;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['role'] = $db_role;

        // Send JSON response with full name
        echo json_encode([
            'status' => 'success',
            'user_id' => $user_id,
            'fullName' => $firstName . ' ' . $lastName
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}

$stmt->close();
$conn->close();
?>
