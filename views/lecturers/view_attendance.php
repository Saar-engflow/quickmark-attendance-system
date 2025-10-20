<?php 
session_start(); 
include '../../includes/db_connect.php'; 

$lecturer_firstName = $_SESSION['firstName'] ?? 'lecturer';
$lecturer_id = $_SESSION['user_id'] ?? null;

// Stop if no lecturer logged in
if (!$lecturer_id) {
    die("Error: No lecturer logged in.");
}

// Fetch all sessions created by this lecturer
$sql = "SELECT s.session_id, s.session_date, c.course_name
        FROM sessions s
        JOIN courses c ON s.course_id = c.course_id
        WHERE s.created_by_user_id = '$lecturer_id'
        ORDER BY s.session_date DESC";

$sessionsResult = $conn->query($sql);

$sessions = [];
$total_sessions = 0;
$total_present = 0;
$best_session = null;
$lowest_session = null;

if ($sessionsResult) {
    while ($row = $sessionsResult->fetch_assoc()) {
        $session_id = $row['session_id'];

        // Count present and absent
        $countSql = "SELECT 
            SUM(status='present') AS present_count,
            SUM(status='absent') AS absent_count
            FROM attendance
            WHERE session_id = '$session_id'";
        $countResult = $conn->query($countSql);
        $counts = $countResult->fetch_assoc();

        $row['present_count'] = $counts['present_count'] ?? 0;
        $row['absent_count'] = $counts['absent_count'] ?? 0;

        $sessions[] = $row;

        // For summary stats
        $total_sessions++;
        $total_present += $row['present_count'];

        $attendance_rate = ($row['present_count'] + $row['absent_count'] > 0)
            ? ($row['present_count'] / ($row['present_count'] + $row['absent_count'])) * 100
            : 0;

        if (!$best_session || $attendance_rate > $best_session['rate']) {
            $best_session = ['date' => $row['session_date'], 'rate' => $attendance_rate];
        }
        if (!$lowest_session || $attendance_rate < $lowest_session['rate']) {
            $lowest_session = ['date' => $row['session_date'], 'rate' => $attendance_rate];
        }
    }
}

// Calculate average attendance
$avg_attendance = ($total_sessions > 0) ? round($total_present / ($total_sessions ?: 1) * 100, 2) : 0;
?>

<?php include '../../includes/header.php'; ?>

<!-- mobile navigation -->
<header class="navbar">
  <div class="logo">
    <img src="/QuickMark/assets/images/QuickMark.png" alt="QuickMark Logo" />
    <span>QuickMark</span>
  </div>

  <div class="hamburger" id="hamburger">
    <div></div>
    <div></div>
    <div></div>
  </div>

  <nav class="nav-links" id="nav-links">
    <a href="../auth/logout.php">Logout</a>
  </nav>
</header>

<!-- desktop Navigation -->
<header class="navbar-D">
  <div class="logo">
    <img src="/QuickMark/assets/images/QuickMark.png" alt="QuickMark Logo" />
    <span>QuickMark</span>
  </div>

  <nav class="navLinks">
    <a href="../auth/logout.php">Logout</a>
  </nav>
</header>

<section>
  <div class="desktop-mt">
    <h1>View Attendance</h1>
    <div class ="flex-r">
      <button class = "app-button ">  <p>Total sessions: <?= $total_sessions ?></p></button>
     <button class = "app-button ml "> <p>Average attendance rate: <?= $avg_attendance ?>%</p></button>
       <button class = "app-button ml ">   <p>Best Session: <?= $best_session['date'] ?? '00/00/00' ?> (<?= round($best_session['rate'] ?? 0) ?>% present)</p></button>
      <button class = "app-button ml "> <p>Lowest Session: <?= $lowest_session['date'] ?? '00/00/00' ?> (<?= round($lowest_session['rate'] ?? 0) ?>% present)</p></button>
      
    </div>

    <!-- Sessions Table -->
    <table class="sessions-table mt">
      <thead>
        <tr>
          <th>Date</th>
          <th>Course / Topic</th>
          <th>Present</th>
          <th>Absent</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($sessions as $row): ?>
          <tr>
            <td><?= $row['session_date'] ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?></td>
            <td><?= $row['present_count'] ?></td>
            <td><?= $row['absent_count'] ?></td>
            <td>
              <button onclick="viewDetails('<?= $row['session_id'] ?>')">View Details</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="side-bar-mobile">
    <div onclick="window.location.href = 'dashboard.php'" class="optn flex-c">Dashboard</div>
    <div onclick="window.location.href = 'mark_attendance.php'" class="optn flex-c">Mark</div>
    <div onclick="window.location.href = 'view_attendance.php'" class="optn flex-c">View</div>
    <!-- <div onclick="window.location.href = 'reports.php'" class="optn flex-c">Reports</div> -->
  </div>

  <div class="side-bar-desktop">
    <div onclick="window.location.href = 'dashboard.php'" class="optn flex-c">Dashboard</div>
    <div onclick="window.location.href = 'mark_attendance.php'" class="optn flex-c">Mark Attendance</div>
    <div onclick="window.location.href = 'view_attendance.php'" class="optn flex-c">View Attendance</div>
    <!-- <div onclick="window.location.href = 'reports.php'" class="optn flex-c">Reports</div> -->
  </div>
</section>

<?php include '../../includes/footer.php';?>
