<?php include '../../includes/header.php' ; ?>
    <h1 class = "mt" >Login below</h1>
        <div class = "form-group ">
     <form action = "register.php" method = "POST" class = "form mt-r">
           
             
                <div class = "input-group">
                <label for = "email">Email:</label>
                <input type = "text" name = "email" class = "input-bar" placeholder = "Enter your email" required>
                </div>

                <div class = "input-group">
            <label for = "password">Password:</label>
                <input type = "text" name = "password" class = "input-bar" placeholder = "Enter your password" required>
                </div>
              
</form>

    <div class = "below-btm mt-r">
        <div class = "button-container">
            <button type = "submit" class = "button">Login</button>
           
        </div>
        <div class = "button-container">
    <a href = "register.php" class = "button">Register</a>
        </div>
    </div>
   
        
</div>

<?php include '../../includes/footer.php' ; ?>