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
  <div class = "move">
  <div class = lecturer>
    
   <div class = "left-section">
      
  <div class = "location-container">
    <div class = "location">
      <label for = "Location">Select Location:</label>
    <select name = "Location" id = "Location">
      <option value = "none">None</option>
      <option value = "kb-classes">KB-Classes</option>
      <option value = "computer-lab">Computer-Lab</option>
      <option value = "f-classes">F-classes</option>
      <option value = "auditorium">Auditorium</option>
    </select>
    </div>
  </div>

  <div class = "info-containerX">
    <div class = "lecturer-user-profile flex-r">
      <div class = "lecturer-profile-pic">

      </div>
      <div class = "lecturer-profile-infor flex-c">
         <p><strong><?php echo htmlspecialchars($lecturer_firstName);?></strong></p>
         <p>Lecturer</p>
      </div>
    </div>

    <div class = "lecturer-window-info flex-c">
    <div class = "flex-r lecturer-window-infoX">
    <p><strong>Lecturer ID:</strong></p>
    <p class = "ml"><?php echo htmlspecialchars($lecturer_id);?></p>
    </div>

    <div class = "flex-r lecturer-window-infoX">
     <p><strong>Location:</strong></p>
     <p class = "ml">KB-Classes</p>
    </div>

    </div>

     </div>
 
  <button class = "app-button mt">Open  window</button>
    </div>


    <div class =  "right-section">
        <div class = "location-container">
          <p>Students clocked in:</p>
        </div>
        <div class = "clock-in-container flex-c">
          <p>No student has clocked in...</p>
        </div>
</div>
</div>
  </div>

   


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