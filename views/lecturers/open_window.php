<?php
session_start();
include '../../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$lecturer_id = $_SESSION['user_id'];
$course_id   = $_POST['course_id'] ?? null;
$lat         = $_POST['lat'] ?? null;
$lng         = $_POST['lng'] ?? null;
$radius      = $_POST['radius'] ?? 50; 
$now         = date("Y-m-d H:i:s");

if (!$course_id || !$lat || !$lng) {
    die("Missing required fields");
}

$stmt = $conn->prepare("
    INSERT INTO sessions 
    (session_id, course_id, session_date, start_time, end_time, location_lat, location_lng, radius_meters, is_window_open, window_opened_at, created_by_user_id) 
    VALUES (UUID(), ?, CURDATE(), CURTIME(), NULL, ?, ?, ?, 1, ?, ?)
");
$stmt->bind_param("sddiss", $course_id, $lat, $lng, $radius, $now, $lecturer_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: " . $stmt->error;
}
