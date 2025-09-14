<?php 
session_start(); 
include '../../includes/db_connect.php'; 

$lecturer_firstName = $_SESSION['firstName'] ?? 'lecturer';
$lecturer_id = $_SESSION['user_id'] ?? 'N/A';

// Handle Add Course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $lecturer_user_id = mysqli_real_escape_string($conn, $lecturer_id);

    $sql = "INSERT INTO courses (course_id, course_code, course_name, lecturer_user_id, created_at) 
            VALUES (UUID(), '$course_code', '$course_name', '$lecturer_user_id', NOW())";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['flash'] = "Course added successfully!";
    } else {
        $_SESSION['flash'] = "Error adding course.";
    }
    header("Location: courses.php");
    exit;
}

// Handle Delete Course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_course'])) {
    $course_id = mysqli_real_escape_string($conn, $_POST['selected_course_id']);
    $sql = "DELETE FROM courses WHERE course_id = '$course_id' AND lecturer_user_id = '$lecturer_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['flash'] = "Course deleted successfully!";
    } else {
        $_SESSION['flash'] = "Error deleting course.";
    }
    header("Location: courses.php");
    exit;
}

// Fetch Courses
$courses = [];
$sql = "SELECT * FROM courses WHERE lecturer_user_id = '$lecturer_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }
}
?>

<?php include '../../includes/header.php'; ?>

<!-- mobile navigation -->
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
    <a href="../auth/logout.php">Logout</a>
    <button onclick="window.location.href='dashboard.php'" class="app-button mt">back</button>
  </nav>
</header>

<!-- desktop Navigation -->
<header class="navbar-D">
  <div class="logo">
    <img src="/QuickMark/assets/images/QuickMark.png" alt="QuickMark Logo" />
    <span>QuickMark</span>
  </div>
  <nav class="navLinks">
    <a href="../auth/logout.php">Logout</a>
  </nav>
</header>

<section>
  <div>
    <div class="desktop-mt2">
      <h1>courses</h1>
      <div class="courses-container" id="coursesContainer">
        <?php if (empty($courses)) : ?>
          <p>Add courses+</p>
        <?php else : ?>
          <?php foreach ($courses as $course): ?>
            <div class="cse-card mt course-card" data-id="<?php echo $course['course_id']; ?>">
              <p><?php echo htmlspecialchars($course['course_code']); ?></p>
              <p class="ml"><?php echo htmlspecialchars($course['course_name']); ?></p>
              <p class="ml">[ <?php echo $course['created_at']; ?> ]</p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <button class="app-button mt" id="openModalBtn">add</button>
      <form method="POST" style="display:inline;">
        <input type="hidden" name="selected_course_id" id="selectedCourseId">
        <button type="submit" name="delete_course" class="app-button mt ml">delete</button>
      </form>
      <button onclick="window.location.href='dashboard.php'" class="app-button mt ml desktop-btnn">back</button>
    </div>
  </div>
</section>

<!-- Add Course Modal -->
<div id="courseModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <h2>Add Course</h2>
    <form method="POST">
      <input type="hidden" name="add_course" value="1">
      <label>Course Code:</label>
      <input type="text" name="course_code" required><br>
      <label>Course Name:</label>
      <input type="text" name="course_name" required><br>
      <button type="submit" class="app-button mt">Save</button>
    </form>
  </div>
</div>

<?php include '../../includes/footer.php'; ?>




<script>
const modal = document.getElementById("courseModal");
const openModalBtn = document.getElementById("openModalBtn");
const closeModal = document.getElementById("closeModal");
const courseCards = document.querySelectorAll(".course-card");
const selectedCourseIdInput = document.getElementById("selectedCourseId");

openModalBtn.onclick = () => { modal.style.display = "block"; }
closeModal.onclick = () => { modal.style.display = "none"; }
window.onclick = (event) => { if (event.target == modal) modal.style.display = "none"; }

courseCards.forEach(card => {
  card.addEventListener("click", () => {
    courseCards.forEach(c => c.classList.remove("selected"));
    card.classList.add("selected");
    selectedCourseIdInput.value = card.dataset.id;
  });
});

// Flash message alert
<?php if (isset($_SESSION['flash'])): ?>
  alert("<?php echo $_SESSION['flash']; ?>");
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
</script>
