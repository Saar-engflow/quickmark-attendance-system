<?php
header('Content-Type: application/json');
session_start();
include '../includes/db_connect.php';

// Get POST data
$student_id = $_POST['student_id'] ?? null;
$session_id = $_POST['session_id'] ?? null;
$lat = isset($_POST['lat']) ? floatval($_POST['lat']) : null;
$lng = isset($_POST['lng']) ? floatval($_POST['lng']) : null;
$device_fingerprint = $_POST['device_fingerprint'] ?? 'unknown';
$now = date("Y-m-d H:i:s");

// Validate required fields
if (!$student_id || !$session_id || $lat === null || $lng === null) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

// Fetch session info
$stmt = $conn->prepare("
    SELECT location_lat, location_lng, radius_meters, is_window_open 
    FROM sessions 
    WHERE session_id = ? 
    LIMIT 1
");
$stmt->bind_param("s", $session_id);
$stmt->execute();
$stmt->bind_result($sessionLat, $sessionLng, $radiusMeters, $isWindowOpen);

if (!$stmt->fetch()) {
    echo json_encode(['status' => 'error', 'message' => 'Session not found']);
    $stmt->close();
    exit;
}
$stmt->close();

// Check if window is open
if ($isWindowOpen != 1) {
    echo json_encode(['status' => 'error', 'message' => 'Session window is closed']);
    exit;
}

// Haversine formula to calculate distance
function haversine($lat1, $lon1, $lat2, $lon2){
    $R = 6371000; // meters
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $R * $c;
}

$distance = haversine($lat, $lng, $sessionLat, $sessionLng);

if ($distance > $radiusMeters) {
    echo json_encode(['status' => 'error', 'message' => 'Out of range']);
    exit;
}

// Check if already clocked in
$stmt = $conn->prepare("
    SELECT attendance_id 
    FROM attendance 
    WHERE student_user_id = ? AND session_id = ? 
    LIMIT 1
");
$stmt->bind_param("ss", $student_id, $session_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Already clocked in']);
    $stmt->close();
    exit;
}
$stmt->close();

// Insert attendance
$stmt = $conn->prepare("
    INSERT INTO attendance 
    (student_user_id, session_id, clock_in_time, status, method, device_fingerprint) 
    VALUES (?, ?, ?, 'present', 'auto', ?)
");
$stmt->bind_param("ssss", $student_id, $session_id, $now, $device_fingerprint);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Clocked in successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error: '.$stmt->error]);
}

$stmt->close();
$conn->close();
?>
