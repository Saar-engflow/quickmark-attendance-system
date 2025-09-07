<?php 
session_start(); 
include '../../includes/db_connect.php'; 

$lecturer_firstName=
$_SESSION['firstName'] ?? 'lecturer';
$lecturer_id = $_SESSION['user_id'] ?? 'N/A';
?>

<?php include '../../includes/header.php' ; ?>

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
 <h1>Reports</h1>
  
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
   <div 
   onclick = "window.location.href = 'reports.php'"
   class = "optn flex-c">Reports</div>
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
   <div 
   onclick = "window.location.href = 'reports.php'"
   class = "optn flex-c">Reports</div> 
</div> 
</section>

<?php include '../../includes/footer.php' ; ?>