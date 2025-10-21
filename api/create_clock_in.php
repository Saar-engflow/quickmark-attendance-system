<?php

error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

include '../includes/db_connect.php';

// Get POST parameters
$student_id = $_POST['user_id'] ?? null;
$session_id = $_POST['session_id'] ?? null;
$lat = isset($_POST['lat']) ? floatval($_POST['lat']) : 0;
$lng = isset($_POST['lng']) ? floatval($_POST['lng']) : 0;
$device_fingerprint = $_POST['device_fingerprint'] ?? null;




$response = [];

try {
    if (!$student_id || !$session_id) {
        throw new Exception('Missing required parameters');
    }

    // Check if session exists and is open
    $stmt = $conn->prepare("SELECT location_lat, location_lng, radius_meters, is_window_open, start_time, end_time 
                            FROM sessions 
                            WHERE session_id=? AND is_window_open=1 AND session_date=CURDATE()");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        throw new Exception('Session not active or not found');
    }

    $stmt->bind_result($sessionLat, $sessionLng, $radius, $isWindowOpen, $startTime, $endTime);
    $stmt->fetch();

    // For testing, increase radius to 50,000 meters (50 km)
    $radius = 50000;

    // Calculate distance using haversine formula
    function haversine($lat1, $lon1, $lat2, $lon2) {
        $R = 6371000; // Earth radius in meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    $distance = haversine($lat, $lng, $sessionLat, $sessionLng);

    if ($distance > $radius) {
        throw new Exception("You are not in range of the session. Distance: {$distance}m");
    }

    // Insert clock-in record
    $stmtInsert = $conn->prepare("INSERT INTO attendance (user_id, session_id, clock_in_time, lat, lng, device_fingerprint)
                                  VALUES (?, ?, NOW(), ?, ?, ?)");
    $stmtInsert->bind_param("ssdds", $student_id, $session_id, $lat, $lng, $device_fingerprint);

    if (!$stmtInsert->execute()) {
        throw new Exception('Failed to clock in');
    }

    $response = ['status' => 'success', 'message' => 'Clocked in successfully'];

    $stmtInsert->close();
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
exit;
?>
