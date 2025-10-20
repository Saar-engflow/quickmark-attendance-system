<?php
session_start();
include '../../includes/db_connect.php';

$course_code = $_POST['course_code'] ?? null;
$now = date("Y-m-d H:i:s");

if (!$course_code) exit("error: missing course code");

// Close the session manually
$sql = "UPDATE sessions 
        SET is_window_open = 0, window_closed_at = ? 
        WHERE course_id = ? AND is_window_open = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $now, $course_code);

if ($stmt->execute()) echo "success: window closed";
else echo "error: " . $stmt->error;