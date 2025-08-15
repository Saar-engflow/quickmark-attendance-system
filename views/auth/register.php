<?php 
$role= $_GET['role'] ?? '';
session_start();
include "../../includes/db_connect.php";

// Sanitize input helper
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $firstName = clean_input($_POST['firstName']);
    $lastName = clean_input($_POST['lastName']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password']; // raw for hashing
    $institute = clean_input($_POST['institute']);
    $role = clean_input($_POST['role']);
    $userid = clean_input($_POST['userid']);

    $valid_roles = ['student', 'lecturer', 'admin'];
    if (!in_array($role, $valid_roles)) {
        die("Invalid role selected.");
    }

    // Check if email exists in user_request table
    $stmt = $conn->prepare("SELECT user_id FROM user_requests WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        die("Email already registered (pending approval).");
    }
    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into user_requests table
    $stmt = $conn->prepare("INSERT INTO user_requests (user_id, firstName, lastName, email, password, institute, role, requested_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", $userid, $firstName, $lastName, $email, $hashed_password, $institute, $role);

    if ($stmt->execute()) {
        echo "<script>
            alert('Thank you, the admin will approve your request shortly. Try to login after a few minutes. If you still don\\'t have access after 24 hours kindly contact ‪+260774654642‬');
            window.location.href = 'login.php';
        </script>";
        exit();
    } else {
        die("Error registering user: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>




<?php include '../../includes/header.php' ; ?>

 

    
    <h1 class = " mt " >Register below</h1>
    <div class = "form-group">
     <form action = "register.php" method = "POST" class = "form">
        <input type="hidden" name="role"  value = "<?php echo htmlspecialchars($role); ?>">
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
                <input type = "text" name = "institute" class = "input-bar" placeholder = "Enter your Institute" required>
                </div>
                            
                <div class = "input-group">
                <label for = "id"> ID:</label>
                <input type = "text" name = "userid" class = "input-bar" placeholder = "Enter your  ID" required>
                </div>
             
                <div class = "input-group">
                <label for = "email">Email:</label>
                <input type = "text" name = "email" class = "input-bar" placeholder = "Enter your email" required>
                </div>

                <div class = "input-group">
            <label for = "password">Password:</label>
                <input type = "text" name = "password" class = "input-bar" placeholder = "Enter your password" required>
                </div>
               <div class = "button-container">
            <button type = "submit" class = "button" name="signup">Register</button>
           
        </div>
</form>

    <div class = "below-btm">
       
        <div class = "button-container">
    <a href = "login.php" class = "button">Login</a>
        </div>
    </div>
   
        
</div>
        
<?php include '../../includes/footer.php' ; ?>
