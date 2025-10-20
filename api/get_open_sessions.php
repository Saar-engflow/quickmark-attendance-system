<?php
session_start();
include '../../includes/db_connect.php';

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$student_id = $_SESSION['student_id'];

// Auto-close expired sessions (cleanup)
$autoCloseQuery = "
    UPDATE sessions
    SET is_window_open = 0, window_closed_at = NOW()
    WHERE (session_date < CURDATE())
       OR (end_time IS NOT NULL AND NOW() > end_time)
       OR (is_window_open = 1 AND TIME(NOW()) > end_time)
";
$conn->query($autoCloseQuery);

// Fetch currently open sessions (time-aware)
$query = "
    SELECT 
        s.session_id, 
        c.course_name, 
        s.location_lat, 
        s.location_lng, 
        s.radius_meters, 
        s.is_window_open, 
        s.start_time, 
        s.end_time
    FROM sessions s
    JOIN courses c ON s.course_id = c.course_id
    WHERE s.is_window_open = 1
      AND s.session_date = CURDATE()
      AND (
          (s.end_time IS NULL AND TIME(NOW()) >= s.start_time)
          OR (s.end_time IS NOT NULL AND TIME(NOW()) BETWEEN s.start_time AND s.end_time)
      )
";

$result = $conn->query($query);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Database query failed: ' . $conn->error]);
    exit;
}

$sessions = [];
while ($row = $result->fetch_assoc()) {
    $sessions[] = $row;
}

// Respond with open sessions (if any)
if (count($sessions) > 0) {
    echo json_encode(['status' => 'success', 'sessions' => $sessions]);
} else {
    echo json_encode(['status' => 'none', 'message' => 'No active sessions right now']);
}

$conn->close();
?>
