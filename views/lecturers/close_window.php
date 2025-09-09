<?php
session_start();
include '../../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$lecturer_id = $_SESSION['user_id'];
$now         = date("Y-m-d H:i:s");

// Close the latest open session
$stmt = $conn->prepare("
    UPDATE sessions
    SET is_window_open = 0,
        window_closed_at = ?
    WHERE created_by_user_id = ?
      AND is_window_open = 1
    ORDER BY window_opened_at DESC
    LIMIT 1
");
$stmt->bind_param("ss", $now, $lecturer_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "no open session found";
    }
} else {
    echo "error: " . $stmt->error;
}
