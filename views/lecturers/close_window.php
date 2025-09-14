<?php
session_start();
include '../../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$lecturer_id = $_SESSION['user_id'];
$now = date("Y-m-d H:i:s");

// Make sure the column exists: window_closed_at or end_time
$column_name = "end_time"; // or "window_closed_at" if that's what you have

$stmt = $conn->prepare("
    UPDATE sessions
    SET is_window_open = 0,
        $column_name = ?
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
