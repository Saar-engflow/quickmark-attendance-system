<?php 
session_start(); 
include '../../includes/db_connect.php'; 

$lecturer_firstName=
$_SESSION['firstName'] ?? 'lecturer';
$lecturer_id = $_SESSION['user_id'] ?? 'N/A';
?>

<?php include '../../includes/header.php' ; ?>

<?php
// Count courses for logged-in lecturer
$course_count = 0;
$sql = "SELECT COUNT(*) AS total FROM courses WHERE lecturer_user_id = '$lecturer_id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $course_count = $row['total'];
}

// Get last attendance marked time for this lecturer
$last_attendance = null;
$sql_last = "SELECT MAX(a.clock_in_time) AS last_marked
             FROM attendance a
             INNER JOIN sessions s ON a.session_id = s.session_id
             INNER JOIN courses c ON s.course_id = c.course_id
             WHERE c.lecturer_user_id = '$lecturer_id'";
$res_last = mysqli_query($conn, $sql_last);
if ($res_last) {
    $row_last = mysqli_fetch_assoc($res_last);
    $last_attendance = $row_last['last_marked'] ?? null;
}


?>

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
  <div class = "flex-c move m-top2 ">
 
<h1>hey  <?php echo htmlspecialchars($lecturer_firstName) ?> ;]</h1>

<!-- top-deck cards -->
<div class = "dashboard-card">
 <!--Courses conducted  -->
 <div class = " flex-c l-card-container">
    <h4>Courses Conducted:</h4>
    <!-- coURSES num -->
    <p class = "count-num mt"><?php echo $course_count; ?></p>
    <div 
    onclick = "window.location.href = 'courses.php'"
    class = " flex-c add-course"><p>open</p></div>
 </div>

  <!-- attendance percentage -->
  <!-- <div class = " flex-c l-card-container">
    <h4>Attendance Percentage</h4>
    <p class = "count-num mt">0%</p>
    <div
      onclick = "window.location.href = 'reports.php'"
    class = " flex-c add-course"><p>open</p></div>
  </div> -->
    
 <!-- Recent Activity -->
<div class="flex-c l-card-container">
    <h4>Lets see who isn't attending!</h4>
    <div class="flex-c">
        <p class="m-top2">Last attendance marked at:</p>
        <p>
            <?php 
                if ($last_attendance) {
                    echo date("d/m/Y - H:i", strtotime($last_attendance)) . " hrs";
                } else {
                    echo "No attendance yet";
                }
            ?>
        </p>
    </div>
    <div 
        onclick="window.location.href='mark_attendance.php'" 
        class="flex-c add-course mt mt">
        <p>Mark Attendance</p>
    </div>
</div>
 
</div>
<!-- bottom-deck cards -->
<div class = "dashboard-card">
 <!-- Least attending students -->
 <!-- <div class = " flex-c l-card-container">
   <h4>least attending</h4>
   <p>Students:</p>
      <p class = "count-num mt">0</p>
    <div 
      onclick = "window.location.href = 'reports.php'"
    class = " flex-c add-course"><p>open</p></div> -->
 </div>
 <!-- total number of students -->
  <!-- <div class = " flex-c l-card-container">
    <h4>Total </h4>
   <p>Students:</p>
      <p class = "count-num mt">0</p>
    <div
      onclick = "window.location.href = 'reports.php'"
    class = " flex-c add-course"><p>open</p></div>
  </div> -->

   <!-- <div class = " flex-c l-card-container">
    <h4>Admin</h4>
   <p>Notifications:</p>
      <p class = "count-num mt">0</p>
    <div class = " flex-c add-course"><p>open</p></div>
   </div> -->
 
</div>



 <!-- sidebar -->
  
 <div class ="side-bar-mobile">
  <div 
   onclick = "window.location.href = 'dashboard.php'"
  class = "optn flex-c"> Dashboard</div>
  <div 
  onclick = "window.location.href = 'mark_attendance.php'"
  class = "optn flex-c">Mark</div>
  <div 
  onclick = "window.location.href = 'view_attendance.php'"
  class = "optn flex-c">View</div>
   <!-- <div 
   onclick = "window.location.href = 'reports.php'"
   class = "optn flex-c">Reports</div>  -->
</div> 

 <div class ="side-bar-desktop">
  <div 
   onclick = "window.location.href = 'dashboard.php'"
  class = "optn flex-c"> Dashboard</div>
  <div 
  onclick = "window.location.href = 'mark_attendance.php'"
  class = "optn flex-c">Mark Attendance</div>
  <div 
  onclick = "window.location.href = 'view_attendance.php'"
  class = "optn flex-c">View Attendance</div>
   <!-- <div 
   onclick = "window.location.href = 'reports.php'"
   class = "optn flex-c">Reports</div> 
</div>  -->
</div>
</section>

<?php include '../../includes/footer.php' ; ?>