<?php 
session_start(); 
$firstName = $_SESSION['firstName'] ?? 'Admin';
?>

<?php include '../../includes/header.php' ; ?>
<?php include '../../includes/db_connect.php' ; ?>

<?php
include '../../includes/db_connect.php';


// Approve a single user
if (isset($_GET['approve_user_id'])) {
    $userId = $_GET['approve_user_id'];

    // Fetch user from user_requests
    $stmt = $conn->prepare("SELECT * FROM user_requests WHERE user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        // Insert into users table
        $stmt2 = $conn->prepare("INSERT INTO users (user_id, firstName, lastName, email, password, institute, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param(
            "sssssss",
            $user['user_id'],
            $user['firstName'],
            $user['lastName'],
            $user['email'],
            $user['password'],
            $user['institute'],
            $user['role']
        );
        $stmt2->execute();
        $stmt2->close();

        // Delete from user_requests
        $stmt3 = $conn->prepare("DELETE FROM user_requests WHERE user_id = ?");
        $stmt3->bind_param("s", $userId);
        $stmt3->execute();
        $stmt3->close();
    }
    header("Location: user_request.php");
    exit();
}

// Approve all users
if (isset($_GET['approve_all'])) {
    $result = $conn->query("SELECT * FROM user_requests");
    while ($user = $result->fetch_assoc()) {
        $stmt2 = $conn->prepare("INSERT INTO users (user_id, firstName, lastName, email, password, institute, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param(
            "sssssss",
            $user['user_id'],
            $user['firstName'],
            $user['lastName'],
            $user['email'],
            $user['password'],
            $user['institute'],
            $user['role']
        );
        $stmt2->execute();
        $stmt2->close();
    }
    // Delete all requests
    $conn->query("DELETE FROM user_requests");
    header("Location: user_request.php");
    exit();
}
?>

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
    
    <div class="ur-container flex-c">
<?php
$result = $conn->query("SELECT * FROM user_requests ORDER BY requested_at ASC");

if ($result->num_rows === 0) {
    echo "<p>No requests</p>";
} else {
    while ($user = $result->fetch_assoc()) {
   echo '<div class="req-bar flex-c">';
     echo '    <div class="req-bar-ls flex-c">';
        echo '        <p>ID: ' . htmlspecialchars($user['user_id']) . '</p>';
        echo '        <p>Full Name: ' . htmlspecialchars($user['firstName'] . " " . $user['lastName']) . '</p>';
        echo '        <p>Role: ' . htmlspecialchars($user['role']) . '</p>';
        echo '        <p>Requested at: ' . htmlspecialchars($user['requested_at']) . '</p>';
        echo '    </div>';
        echo '    <div class="req-bar-rs">';
        echo '        <button onclick="window.location.href=\'user_request.php?approve_user_id=' . $user['user_id'] . '\'">Approve</button>';
        echo '    </div>';
        echo '</div>';
    }}
       
      





?>
</div>

    <div class= "ur-btns">
       <button
    onclick = ' window.location.href= "dashboard.php"';
    class = "mt">back</button>
<!-- 
    <button
    
     onclick="window.location.href='user_request.php?approve_all=1'">
     Approve all</button> -->
    </div>
  </div>




</section>

<?php include '../../includes/footer.php' ; ?>