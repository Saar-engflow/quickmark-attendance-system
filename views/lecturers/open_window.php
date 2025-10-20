<?php
session_start();
include '../../includes/db_connect.php';

$lecturer_id = $_SESSION['user_id'] ?? null;
$course_code = $_POST['course_code'] ?? null;
$lat = floatval($_POST['lat'] ?? 0);
$lng = floatval($_POST['lng'] ?? 0);
$radius = floatval($_POST['radius'] ?? 50);

if (!$lecturer_id || !$course_code) exit("error: missing parameters");

// Open a new session manually
$sql = "INSERT INTO sessions (session_id, course_id, created_by_user_id, session_date, start_time, location_lat, location_lng, radius_meters, is_window_open, created_at)
        VALUES (UUID(), ?, ?, CURDATE(), CURTIME(), ?, ?, ?, 1, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssddd", $course_code, $lecturer_id, $lat, $lng, $radius);

if ($stmt->execute()) echo "success: window opened";
else echo "error: " . $stmt->error;
