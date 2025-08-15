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
         <p><strong>Username</strong></p>
         <p>Lecturer</p>
      </div>
    </div>

    <div class = "lecturer-window-info flex-c">
    <div class = "flex-r lecturer-window-infoX">
    <p><strong>Lecturer ID:</strong></p>
    <p class = "ml">10111</p>
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
   


  

</section>
<?php include '../../includes/footer.php' ; ?>