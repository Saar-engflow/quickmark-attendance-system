<?php
session_start();
include '../../includes/db_connect.php';

$course_code = trim($_POST['course_code'] ?? '');
$now = date("Y-m-d H:i:s");

if (!$course_code) {
    exit("error: missing course code");
}

// ⿡ Find the course_id from the course_code
$sql_course = "SELECT course_id FROM courses WHERE course_code = ? LIMIT 1";
$stmt_course = $conn->prepare($sql_course);
$stmt_course->bind_param("s", $course_code);
$stmt_course->execute();
$stmt_course->bind_result($course_id);
if (!$stmt_course->fetch()) {
    exit("error: invalid course code");
}
$stmt_course->close();

// ⿢ Close the session for this course
$sql_close = "
    UPDATE sessions
    SET is_window_open = 0, window_closed_at = ?
    WHERE course_id = ? AND is_window_open = 1
";
$stmt_close = $conn->prepare($sql_close);
$stmt_close->bind_param("ss", $now, $course_id);

if ($stmt_close->execute()) {
    if ($stmt_close->affected_rows > 0) {
        echo "success: window closed";
    } else {
        echo "info: no open session found for this course";
    }
} else {
    echo "error: " . $stmt_close->error;
}

$stmt_close->close();
$conn->close();
?>
