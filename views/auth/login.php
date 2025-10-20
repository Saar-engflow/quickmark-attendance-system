<?php
session_start();
include "../../includes/db_connect.php";

// Sanitize input helper
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];

    // Fetch user_id (not primary key), firstName, password, role
    $stmt = $conn->prepare("SELECT user_id, firstName, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $firstName, $hashed_password, $role);

    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            // Set correct sessions
            $_SESSION['user_id'] = $user_id;      // <- user_id column, for lecturer ID
            $_SESSION['firstName'] = $firstName;
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: /QuickMark/views/admin/dashboard.php");
            } elseif ($role === 'lecturer') {
                header("Location: /QuickMark/views/lecturers/dashboard.php");
            } else {
                header("Location: /QuickMark/views/students/dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Invalid credentials.";
    }
    $stmt->close();
}
?>




<?php include '../../includes/header.php' ; ?>
    <h1 class = "mt" >Login below</h1>
        <div class = "form-group ">
     <form action = "login.php" method = "POST" class = "form mt-r">
           
             
                <div class = "input-group">
                <label for = "email">Email:</label>
                <input type = "text" name = "email" class = "input-bar" placeholder = "Enter your email" required>
                </div>

                <div class = "input-group">
            <label for = "password">Password:</label>
                <input type = "text" name = "password" class = "input-bar" placeholder = "Enter your password" required>
                </div>
                 <div class = "button-container">
            <button type = "submit" class = "button" name = "login" >Login</button>
           
        </div>
              
</form>

    <div class = "below-btm mt-r">
       
        <div class = "button-container">
    <a href = "roles.php" class = "button">Register</a>
        </div>
    </div>
   
        
</div>


 <!-- <script>
document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); // stop form submission until validation passes

    let email = document.querySelector("input[name='email']").value.trim();
    let password = document.querySelector("input[name='password']").value;

    // Email validation
    if (email === "") {
        alert("Please enter your email.");
        return false;
    }

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Password validation
    if (password === "") {
        alert("Please enter your password.");
        return false;
    }

    // All checks passed    ,good then u submit kayli
    this.submit();
});
</script>  -->


<?php include '../../includes/footer.php' ; ?>