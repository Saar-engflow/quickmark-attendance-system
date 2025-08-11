<?php include '../../includes/header.php' ; ?>
  <div class = "container">
    <div class = "heading-container marg-top">
    <h1 class = "bold-title">Enter your Role in the system</h1>
</div>
  <div class = "role-container">
    <button 
      onclick = "window.location.href = 'register.php? role=student '"; >Student</button>
       <button 
      onclick = "window.location.href = 'register.php? role=lecturer '"; >Lecturer</button>
       <button 
      onclick = "window.location.href = 'register.php? role=admin '"; >Admin</button>
      <button 
      onclick = "window.location.href = '../../index.php '"; >Back</button>

</div>
</div>
<?php include '../../includes/footer.php' ; ?>