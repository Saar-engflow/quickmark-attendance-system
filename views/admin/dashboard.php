<?php 
session_start(); 
$firstName = $_SESSION['firstName'] ?? 'Admin';
?>

<?php include '../../includes/header.php' ; ?>
<?php include '../../includes/db_connect.php' ; ?>
<!-- mobile navigation -->
   <header class="navbar">
  <div class="logo">
    <img src="/QuickMark/assets/images/QuickMark.png" alt="QuickMark Logo" />
    <span>QuickMark</span>
  </div>

 

  <nav class="nav-links" id="nav-links">
  
    <a href="#home">Home</a>
    <a href="#doc">Documentation</a>
  
    
   
  </nav>
</header>

<!-- desktop Navigation -->
    <header class="navbar-D">
  <div class="logo">
    <img src="/QuickMark/assets/images/QuickMark.png" alt="QuickMark Logo" />
    <span>QuickMark</span>
  </div>

 

  <nav class="navLinks">
  </nav>
</header>
<section>
  <div  class = admin-container>
    <div class = "header-sec flex-c">
    <h1>hey  <?php echo htmlspecialchars($firstName) ?> ;]</h1>
    <?php
    //fetch the total number of users
    $result = $conn->query("SELECT COUNT(*)  as totalUsers FROM users");
    $row = $result->fetch_assoc();
    $totalUsers = $row['totalUsers'];
    ?>
  <p>there are currently <span class = "tnum" ><?php echo $totalUsers; ?></span> number of QuickMark users</p>
    </div>

    <div class = "counts-container flex-c">
      <?php
// Count students
$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
$studentCount = $result->fetch_assoc()['count'];

// Count lecturers
$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'lecturer'");
$lecturerCount = $result->fetch_assoc()['count'];

// Count admins
$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
$adminCount = $result->fetch_assoc()['count'];
?>
      
         <div class = "count flex-c">
          <div class ="count-title">
 <h4 class = "">Students</h4>
          </div>
           <p class="count-num"><?php  echo $studentCount; ?></p>
         </div>

                  <div class = "count flex-c">
          <div class ="count-title">
 <h4 class = "">Lecturers</h4>
          </div>
           <p class="count-num"><?php  echo $lecturerCount; ?></p>
         </div>

                  <div class = "count flex-c">
          <div class ="count-title">
 <h4 class = "">Admins</h4>
          </div>
           <p class="count-num"><?php  echo $adminCount; ?></p>
         </div>
    </div>

     <div class = "counts-container flex-c">

      <div class = "user-m flex-c">
        <div class= "user-m-header flex-c">
         <h4>User Requests</h4>
        </div>

       <div class="user-m-cont flex-c">
    <p>
        <?php
        $reqResult = $conn->query("SELECT COUNT(*) AS requestCount FROM user_requests");
        $requestCount = $reqResult->fetch_assoc()['requestCount'];
        echo $requestCount . " request" . ($requestCount != 1 ? "s" : "");
        ?>
    </p>
</div>
        
        <div class = "user-m-footer flex-c">
          <button
          onclick = ' window.location.href = "user_request.php"';
          >open</button>
        </div>
        </div>

      <div class = "user-m flex-c">
        <div class= "user-m-header flex-c">
     <h4>User Management</h4>
        </div>
        <div class ="user-m-cont flex-c">
         <p class="count-num"><?php echo $totalUsers; ?></p>
        </div>
        <div class = "user-m-footer flex-c">
          <button>open</button>
        </div>
        </div>

      <div class = "user-m flex-c">
        <div class= "user-m-header flex-c">
      <h4>System logs</h4>
        </div>
        <div class ="user-m-cont flex-c">
         <p>nothing yet</p>
        </div>
     <div class = "user-m-footer flex-c">
          <button>open</button>
        </div>
    </div>
     
</div>
  </div>
  
</section>
<?php include '../../includes/footer.php' ; ?>