<?php include '../../includes/header.php' ; ?>
    <h1 class = " mt " >Register below</h1>
    <div class = "form-group">
     <form action = "register.php" method = "POST" class = "form">
           <div class = "input-group">
              <label for = "firstName">First Name:</label>
            <input type = "text" name = "firstName" class = "input-bar" placeholder = "Enter your first name" required>
           </div>
           
              <div class = "input-group">
               <label for = "lastName">Last Name:</label>
            <input type = "text" name = "lastName" class = "input-bar" placeholder = "Enter your last name" required>
              </div>
            
                <div class = "input-group">
                <label for = "institute">Institute:</label>
                <input type = "text" name = "Institute" class = "input-bar" placeholder = "Enter your Institute" required>
                </div>
                            
                <div class = "input-group">
                <label for = "studentID">Student ID:</label>
                <input type = "text" name = "studentID" class = "input-bar" placeholder = "Enter your student ID" required>
                </div>
             
                <div class = "input-group">
                <label for = "email">Email:</label>
                <input type = "text" name = "email" class = "input-bar" placeholder = "Enter your email" required>
                </div>

                <div class = "input-group">
            <label for = "password">Password:</label>
                <input type = "text" name = "password" class = "input-bar" placeholder = "Enter your password" required>
                </div>
              
</form>

    <div class = "below-btm">
        <div class = "button-container">
            <button type = "submit" class = "button">Register</button>
           
        </div>
        <div class = "button-container">
    <a href = "login.php" class = "button">Login</a>
        </div>
    </div>
   
        
</div>
        
<?php include '../../includes/footer.php' ; ?>