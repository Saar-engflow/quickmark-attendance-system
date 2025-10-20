<?php 
session_start(); 
$firstName = $_SESSION['firstName'] ?? 'Admin';
include '../../includes/header.php';
include '../../includes/db_connect.php';
?>

<!-- PHP Actions for Editing & Deleting Users -->
<?php
// Delete user
if (isset($_GET['delete_user_id'])) {
    $userId = $_GET['delete_user_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Update user
if (isset($_POST['update_user'])) {
    $userId = $_POST['user_id'];
    $firstNameU = $_POST['firstName'];
    $lastNameU = $_POST['lastName'];
    $emailU = $_POST['email'];
    $roleU = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=?, role=? WHERE user_id=?");
    $stmt->bind_param("sssss", $firstNameU, $lastNameU, $emailU, $roleU, $userId);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}
?>

<!-- Mobile Navigation -->
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
    <a href="dashboard.php">Dashboard</a>
    <a href="../auth/logout.php">Logout</a>
  </nav>
</header>

<!-- Desktop Navigation -->
<header class="navbar-D">
  <div class="logo">
    <img src="/QuickMark/assets/images/QuickMark.png" alt="QuickMark Logo" />
    <span>QuickMark</span>
  </div>
  <nav class="navLinks">
    <a href="dashboard.php">Dashboard</a>
    <a href="../auth/logout.php">Logout</a>
  </nav>
</header>

<section>
  <div class="manage-users-container">
    <h1>Manage Users</h1>

    <!-- Search -->
    <input type="text" id="searchInput" placeholder="Search users..." class="search-box">

    <!-- Users Table -->
    <div class="table-container">
      <table id="usersTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM users ORDER BY firstName ASC");
        while ($user = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($user['user_id']) . '</td>';
            echo '<td>' . htmlspecialchars($user['firstName']) . '</td>';
            echo '<td>' . htmlspecialchars($user['lastName']) . '</td>';
            echo '<td>' . htmlspecialchars($user['email']) . '</td>';
            echo '<td>' . htmlspecialchars($user['role']) . '</td>';
            echo '<td>
                    <button class="edit-btn" data-id="'.$user['user_id'].'" data-first="'.htmlspecialchars($user['firstName']).'" data-last="'.htmlspecialchars($user['lastName']).'" data-email="'.htmlspecialchars($user['email']).'" data-role="'.htmlspecialchars($user['role']).'">Edit</button>
                    <a href="manage_users.php?delete_user_id='.$user['user_id'].'" class="delete-btn" onclick="return confirm(\'Are you sure?\')">Delete</a>
                  </td>';
            echo '</tr>';
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Edit Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Edit User</h2>
    <form method="POST" action="manage_users.php">
      <input type="hidden" name="user_id" id="modal_user_id">
      <label>First Name</label>
      <input type="text" name="firstName" id="modal_firstName" required>
      <label>Last Name</label>
      <input type="text" name="lastName" id="modal_lastName" required>
      <label>Email</label>
      <input type="email" name="email" id="modal_email" required>
      <label>Role</label>
      <select name="role" id="modal_role" required>
        <option value="student">Student</option>
        <option value="lecturer">Lecturer</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit" name="update_user">Update</button>
    </form>
  </div>
</div>

<?php include '../../includes/footer.php'; ?>


<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin:0;
  padding:0;
}
.manage-users-container {
  max-width: 1100px;
  margin: 2rem auto;
  padding: 1rem;
  background-color: #227744ff;
  border-radius: 10px;
}
h1 {
  text-align: center;
  color: rgba(0,54,45,1);
}
.search-box {
  width: 90%;
  padding: 0.5rem;
  margin-bottom: 1rem;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.table-container {
  overflow-x: auto;
}
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 0.75rem;
  border-bottom: 1px solid #ccc;
  text-align: left;
}
th {
  background-color: rgba(0,54,45,1);
  color: #fff;
}
.edit-btn, .delete-btn {
  padding: 0.3rem 0.6rem;
  margin-right: 0.3rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  color: #fff;
}
.edit-btn {
  background-color: #007bff;
}
.delete-btn {
  background-color: #dc3545;
  text-decoration: none;
}
.edit-btn:hover {
  opacity: 0.8;
}
.delete-btn:hover {
  opacity: 0.8;
}

/* Modal */
.modal {
  display: none;
  position: fixed;
  z-index: 10;
  left: 0; top: 0;
  width: 100%; height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.5);
}
.modal-content {
  background-color: #05645fff;
  margin: 10% auto;
  padding: 1.5rem;
  border-radius: 10px;
  max-width: 500px;
  position: relative;
}
.close {
  position: absolute;
  top: 10px; right: 15px;
  font-size: 1.5rem;
  cursor: pointer;
}

/* Responsive */
@media(max-width:768px){
  th, td {
    font-size: 0.9rem;
  }
  .edit-btn, .delete-btn {
    padding: 0.2rem 0.4rem;
  }
}
</style>

<!-- JS for Modal & Search -->
<script>
const modal = document.getElementById("editModal");
const closeBtn = document.querySelector(".modal .close");
const editBtns = document.querySelectorAll(".edit-btn");

editBtns.forEach(btn => {
  btn.addEventListener("click", () => {
    modal.style.display = "block";
    document.getElementById("modal_user_id").value = btn.dataset.id;
    document.getElementById("modal_firstName").value = btn.dataset.first;
    document.getElementById("modal_lastName").value = btn.dataset.last;
    document.getElementById("modal_email").value = btn.dataset.email;
    document.getElementById("modal_role").value = btn.dataset.role;
  });
});

closeBtn.onclick = () => modal.style.display = "none";
window.onclick = e => { if(e.target == modal) modal.style.display = "none"; }

// Search
const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("keyup", () => {
  const filter = searchInput.value.toLowerCase();
  const rows = document.querySelectorAll("#usersTable tbody tr");
  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});
</script>
