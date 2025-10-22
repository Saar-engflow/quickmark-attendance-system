 <?php
header('Content-Type: application/json');
include '../includes/db_connect.php';

// Get student_id and coordinates from POST
$student_id = $_POST['user_id'] ?? null;
$student_lat = isset($_POST['lat']) ? floatval($_POST['lat']) : 0;
$student_lng = isset($_POST['lng']) ? floatval($_POST['lng']) : 0;



if (!$student_id) {
    echo json_encode(['status' => 'error', 'message' => 'Student ID required']);
    exit;
}

$conn->query("
    UPDATE sessions
    SET is_window_open = 0, window_closed_at = NOW()
    WHERE is_window_open = 1
      AND (
          session_date < CURDATE()
          OR (session_date = CURDATE() AND end_time IS NOT NULL AND TIME(NOW()) > end_time)
)
");

// Fetch open sessions (server-side distance)
$query = "
    SELECT 
        s.session_id, 
        c.course_name, 
        s.location_lat, 
        s.location_lng, 
        s.radius_meters, 
        s.is_window_open, 
        s.start_time, 
        s.end_time,
        (6371000 * acos(
            cos(radians(?)) * cos(radians(s.location_lat)) *
            cos(radians(s.location_lng) - radians(?)) +
            sin(radians(?)) * sin(radians(s.location_lat))
        )) AS distance_meters
    FROM sessions s
    JOIN courses c ON s.course_id = c.course_id
    WHERE s.is_window_open = 1
      AND s.session_date = CURDATE()
      AND (
          (s.end_time IS NULL AND TIME(NOW()) BETWEEN s.start_time AND ADDTIME(s.start_time, '01:00:00'))
          OR (s.end_time IS NOT NULL AND TIME(NOW()) BETWEEN s.start_time AND s.end_time)
      )
      AND TIME(NOW()) >= s.start_time
";


$stmt = $conn->prepare($query);
$stmt->bind_param("ddd", $student_lat, $student_lng, $student_lat);
$stmt->execute();
$result = $stmt->get_result();

$sessions = [];
while ($row = $result->fetch_assoc()) {
    $sessions[] = $row;
}

// Include debug info
$response = [];
if (count($sessions) > 0) {
    foreach ($sessions as $s) {
        $response[] = [
            'session_id' => $s['session_id'],
            'course_name' => $s['course_name'],
            'lat' => $s['location_lat'],
            'lng' => $s['location_lng'],
            'radius_m' => $s['radius_meters'],
            'is_window_open' => $s['is_window_open'],
            'start_time' => $s['start_time'],
            'end_time' => $s['end_time'],
            'distance_m' => $s['distance_meters']
        ];
    }
    echo json_encode(['status' => 'success', 'sessions' => $response]);
} else {
    echo json_encode([
        'status' => 'none',
        'message' => 'No active sessions detected',
        'debug' => [
            'student_lat' => $student_lat,
            'student_lng' => $student_lng
        ]
    ]);
}

$stmt->close();
$conn->close();
?> 
