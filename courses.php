<?php
include 'db.php';
include 'functions.php';

// Додавання курсу
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $duration = $_POST['duration'];
    insertCourse($pdo, $title, $category, $duration);
    header("Location: courses.php");
    exit();
}

// Редагування курсу
if (isset($_GET['edit'])) {
    $course_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM Courses WHERE course_id = ?");
    $stmt->execute([$course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $duration = $_POST['duration'];
        updateCourse($pdo, $course_id, $title, $category, $duration);
        header("Location: courses.php");
        exit();
    }
}

// Видалення курсу
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    deleteCourse($pdo, $course_id);
    header("Location: courses.php");
    exit();
}
?>

<h2>Add New Course</h2>
<form method="post" action="courses.php">
    <label for="title">Course Title:</label><br>
    <input type="text" name="title" required><br>
    <label for="category">Category:</label><br>
    <input type="text" name="category" required><br>
    <label for="duration">Duration (in hours):</label><br>
    <input type="number" name="duration" required><br>
    <button type="submit" name="add_course">Add Course</button>
</form>

<h2>Edit Course</h2>
<?php if (isset($course)): ?>
    <form method="post" action="courses.php?edit=<?php echo $course['course_id']; ?>">
        <label for="title">Course Title:</label><br>
        <input type="text" name="title" value="<?php echo $course['title']; ?>" required><br>
        <label for="category">Category:</label><br>
        <input type="text" name="category" value="<?php echo $course['category']; ?>" required><br>
        <label for="duration">Duration (in hours):</label><br>
        <input type="number" name="duration" value="<?php echo $course['duration']; ?>" required><br>
        <button type="submit" name="edit_course">Update Course</button>
    </form>
<?php endif; ?>

<h2>Courses List</h2>
<table>
    <tr><th>ID</th><th>Title</th><th>Category</th><th>Duration</th><th>Actions</th></tr>
    <?php
    $courses = getAllCourses($pdo);
    foreach ($courses as $course) {
        echo "<tr>
            <td>{$course['course_id']}</td>
            <td>{$course['title']}</td>
            <td>{$course['category']}</td>
            <td>{$course['duration']}</td>
            <td>
                <a href='courses.php?edit={$course['course_id']}'>Edit</a> | 
                <a href='courses.php?delete={$course['course_id']}'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>
