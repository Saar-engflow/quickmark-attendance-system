<?php include 'includes/header.php' ; ?>
    
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

    <a href="#home">Home</a>
    <a href="#doc">Documentation</a>
  
   
    
   
  </nav>
</header>
  
<!-- home page -->
<section id = "home">
  <div class = "hero-container margin-top">
    <div class = "upperContent">
      <!-- <div class = ""></div> -->
    <div class = "text-container">
           <h1 class = "bold-title marg  fade-in">QuickMark.</h1>
    <p class = "plain-text slide-fade-in">Student Attendance Made Simple.</p>
    </div>

    
     <div class = "logo-container fade-in"></div>
   
</div>
  <div class = "button-container fade-in">
     <button onclick = "window.location.href = 'views/auth/login.php '";>Sign In</button>
     <button 
      onclick = "window.location.href = 'views/auth/roles.php '"; >Register</button>
    </div>
</div>

    <div class = "hero-card-container fade-in marg">
     <p class = "marg"> QuickMark is the next-generation student attendance system built for simplicity, speed, and accuracy.
With just a single tap on your phone, students mark their presence — no paperwork, no waiting lines, no pretending. Lecturers open a real-time attendance window, and only those physically within the classroom range can check in. Whether you're managing hundreds in an auditorium or a few in a small room, QuickMark adapts seamlessly.</p>

 <p class = "plain-text">Just a click — and you're marked present. It's fast. It's smart. It's the future of classroom attendance.</P>
    </div>

</section>

<section class= "doc-section mt-r" id = "doc">
     <div class = "container ">
      <div class = "opp-flex">
        <h1 class = " marg"><u>Documentaion Page</u></h1>
         
<h2>
Introduction
</h2>
<p class = "mt">
Welcome to the Student Attendance System!<br> This system allows students to easily register their attendance in lectures, and lecturers to track student attendance records. With location-based attendance tracking, students can only clock in from designated areas, ensuring accurate attendance records.
</P>

<h2 class = "mt">
How to Use the System
</h2>

<h3 class = "mt">
For Students
</h3>
<p class = "mt">
1. Open the Attendance Portal: Access the attendance portal through the university's website or a designated link.<br>
2. Click to Register Attendance: Click the "Register Attendance" button to mark your presence in the lecture.<br>
3. Allow Location Services: Ensure that your device's location services are enabled to allow the system to track your location.<br>
4. Confirmation: Once your attendance is registered, you will receive a confirmation message.<br>

<h3 class = "mt"> For Lecturers</h3>
<p class = "mt">
1. Open the Lecturer Portal: Access the lecturer portal through the university's website or a designated link.<br>
2. Create an Attendance Session: Create a new attendance session by selecting the lecture, date, and designated location.<br>
3. View Attendance Records: View the attendance records for each student, including dates and locations.<br>
4. Export Records (Optional): Export attendance records for further analysis or record-keeping.<br>
</P>

</div>
     </div>
    
</section>



  

<?php include 'includes/footer.php' ; ?>