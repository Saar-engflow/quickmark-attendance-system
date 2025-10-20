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
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password){
        die ("Passwords do not match!");
    }
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
    <div class = "form-group ">
     <form action = "register.php" method = "POST" class = "form marg-top">
        <input type="hidden" name="role"  value = "<?php echo htmlspecialchars($role); ?>">
           <div class = "input-group">
              <label for = "firstName" >First Name:</label>
            <input type = "text" name = "firstName"  id = "firstName" class = "input-bar" placeholder = "Enter your first name" required>
           </div>
           
              <div class = "input-group">
               <label for = "lastName">Last Name:</label>
            <input type = "text" name = "lastName" id = "lastName" class = "input-bar" placeholder = "Enter your last name" required>
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
                <input type = "text" name = "email" id ="email" class = "input-bar" placeholder = "Enter your email" required>
                </div>

                <div class = "input-group">
            <label for = "password">Password:</label>
                <input type = "password" id = "password" name = "password" class = "input-bar" placeholder = "Enter your password" required>
                </div>
               

          <div class = "input-group">
            <label for = "confirm_password"> Confirm Password:</label>
                <input type = "password" id = "confirm_password" name = "confirm_password" class = "input-bar" placeholder = "Confirm your password" required>
                </div>
             
               <div class = "button-container">
            <button type = "submit" class = "button mt" name="signup">Register</button>
           
        </div>
</form>

    <div class = "below-btm">
       
        <div class = "button-container">
    <a href = "login.php" class = "button">Login</a>
        </div>
    </div>
   
        
</div>
   <script>
document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); // stop form submission until validated
    
    let firstName = document.getElementById("firstName").value.trim();
    let lastName = document.getElementById("lastName").value.trim();
    let email = document.getElementById("email").value.trim();
    let institute = document.querySelector("input[name='institute']").value.trim();
    let userid = document.querySelector("input[name='userid']").value.trim();
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    // Name validation: letters only, at least 3 characters
    let namePattern = /^[A-Za-z]{3,}$/;
    if (!namePattern.test(firstName)) {
        alert("First name must be at least 3 letters and contain only letters.");
        return false;
    }
    if (!namePattern.test(lastName)) {
        alert("Last name must be at least 3 letters and contain only letters.");
        return false;
    }

    // Email validation
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Institute validation
    if (institute.length < 2) {
        alert("Please enter your institute name.");
        return false;
    }

    // User ID validation
    if (userid.length < 2) {
        alert("Please enter your user ID.");
        return false;
    }

    // Password validation: min 6 chars, at least 1 uppercase, 1 lowercase, 1 number
    // let passwordPattern = /^(?=.[a-z])(?=.[A-Z])(?=.*\d).{4,}$/;
    // if (!passwordPattern.test(password)) {
    //     alert("Password must be at least 6 characters long and include uppercase, lowercase, and a number.");
    //     return false;
    // }

    // Confirm password
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    // All checks passed
    this.submit();
});
</script>



<?php include '../../includes/footer.php' ; ?>
