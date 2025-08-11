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

    $stmt = $conn->prepare("SELECT id, firstName, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $firstName, $hashed_password, $role);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: ../../../views/admin/dashboard.php");
            } elseif ($role === 'lecturer') {
                header("Location: ../../../views/lecturers/dashboard.php");
            } else {
                header("Location: ../../../views/students/dashboard.php");
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
    <a href = "register.php" class = "button">Register</a>
        </div>
    </div>
   
        
</div>

<?php include '../../includes/footer.php' ; ?>