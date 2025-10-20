<?php
session_start();
$firstName = $_SESSION['firstName'] ?? 'Admin';
include '../../includes/header.php';
include '../../includes/db_connect.php';
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

<section >
  <div class="system-logs-container top">
    <h1>System Logs</h1>

    <!-- Search & Filter -->
    <input type="text" id="searchInput" placeholder="Search logs..." class="search-box">

    <div class="table-container">
      <table id="logsTable">
        <thead>
          <tr>
            <th>Log ID</th>
            <th>User ID</th>
            <th>Action</th>
            <th>Description</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM logs ORDER BY created_at DESC");
        while ($log = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($log['log_id']) . '</td>';
            echo '<td>' . htmlspecialchars($log['user_id'] ?? '-') . '</td>';
            echo '<td>' . htmlspecialchars($log['action']) . '</td>';
            echo '<td>' . htmlspecialchars($log['description'] ?? '-') . '</td>';
            echo '<td>' . htmlspecialchars($log['created_at']) . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
      </table>
    </div>

    <div class="btn-container">
      <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>

<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin:0;
  padding:0;
}
.system-logs-container {
  max-width: 1100px;
  margin: 2rem auto;
  padding: 1rem;
  background-color: #fff;
  border-radius: 10px;
}
h1 {
  text-align: center;
  color: rgba(0,54,45,1);
  margin-bottom: 1rem;
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
.btn-container {
  text-align: center;
  margin-top: 1rem;
}
.btn-container button {
  background-color: rgba(0,54,45,1);
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 5px;
  cursor: pointer;
}
.btn-container button:hover {
  opacity: 0.8;
}

.top{
  margin-top: 200px;
}

/* Responsive */
@media(max-width:768px){
  th, td {
    font-size: 0.9rem;
  }
}
</style>

<script>
const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("keyup", () => {
  const filter = searchInput.value.toLowerCase();
  const rows = document.querySelectorAll("#logsTable tbody tr");
  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});
</script>
