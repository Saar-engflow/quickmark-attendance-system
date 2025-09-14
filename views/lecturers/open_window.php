<?php
session_start();
include '../../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$lecturer_id = $_SESSION['user_id'];
$course_code   =  trim($_POST['course_code'] ?? null);
$lat         =   floatval($_POST['lat'] ?? null);
$lng         =  floatval($_POST['lng'] ?? null);
$radius      =  intval($_POST['radius'] ?? 50); 
$now         = date("Y-m-d H:i:s");

if (!$course_code || !$lat || !$lng) {
    die("Missing required fields");
}
// 1️⃣ Check if course exists and belongs to logged-in lecturer
$course_check = $conn->prepare("SELECT course_id FROM courses WHERE course_code = ? AND lecturer_user_id = ?");
$course_check->bind_param("ss", $course_code, $lecturer_id);
$course_check->execute();
$course_check->store_result();
$course_check->bind_result($course_id_from_db);
$course_check->fetch();

if ($course_check->num_rows == 0) {
    die("Error: Course does not exist or you don't own it.");
}

// use the actual course_id from DB for insertion
$course_id = $course_id_from_db;

$stmt = $conn->prepare("
    INSERT INTO sessions 
    (session_id, course_id, session_date, start_time, end_time, location_lat, location_lng, radius_meters, is_window_open, window_opened_at, created_by_user_id) 
    VALUES (UUID(), ?, CURDATE(), CURTIME(), NULL, ?, ?, ?, 1, ?, ?)
");
$stmt->bind_param("sddsss", $course_id, $lat, $lng, $radius, $now, $lecturer_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: " . $stmt->error;
}
