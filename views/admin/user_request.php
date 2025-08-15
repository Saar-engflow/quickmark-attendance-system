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
  <div class= "user_request-container flex-c" >
    <div class = "ur-header flex-c">
     <h1>User Requests</h1>
    </div>

    <div class = "ur-container flex-c">
 <!-- <p>no requests</p> -->

  <!-- request bar  -->
   <div class= "req-bar flex-c">
    <div class = "req-bar-ls flex-c">
     <p>ID: 2023061534</p>
     <p>FullName: Robins Banda</p>
     <p>Role: Student</p>
     <p>Requested at: ../../..</p>
    </div>
     <div class ="req-bar-rs ">
      <button>approve</button>
      <button>deny</button>
     </div>
   </div>
    <!-- end of req bar -->
  




    </div>
    <div class= "ur-btns">
       <button
    onclick = ' window.location.href= "dashboard.php"';
    class = "mt">back</button>
    <button class = "mt">Aprove all</button>
    </div>
  </div>
 


</section>

<?php include '../../includes/footer.php' ; ?>