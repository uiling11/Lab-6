<?php
include 'db.php';
include 'functions.php';

// Додавання розкладу
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_schedule'])) {
    $course_id = $_POST['course_id'];
    $instructor_id = $_POST['instructor_id'];
    $start_date = $_POST['start_date'];
    $location = $_POST['location'];
    insertSchedule($pdo, $course_id, $instructor_id, $start_date, $location);
    header("Location: schedules.php");
    exit();
}

// Редагування розкладу
if (isset($_GET['edit'])) {
    $schedule_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM Schedules WHERE schedule_id = ?");
    $stmt->execute([$schedule_id]);
    $schedule = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_schedule'])) {
        $course_id = $_POST['course_id'];
        $instructor_id = $_POST['instructor_id'];
        $start_date = $_POST['start_date'];
        $location = $_POST['location'];
        updateSchedule($pdo, $schedule_id, $course_id, $instructor_id, $start_date, $location);
        header("Location: schedules.php");
        exit();
    }
}

// Видалення розкладу
if (isset($_GET['delete'])) {
    $schedule_id = $_GET['delete'];
    deleteSchedule($pdo, $schedule_id);
    header("Location: schedules.php");
    exit();
}
?>

<h2>Add New Schedule</h2>
<form method="post" action="schedules.php">
    <label for="course_id">Course:</label><br>
    <select name="course_id" required>
        <?php
        $courses = getAllCourses($pdo);
        foreach ($courses as $course) {
            echo "<option value='{$course['course_id']}'>{$course['title']}</option>";
        }
        ?>
    </select><br>
    <label for="instructor_id">Instructor:</label><br>
    <select name="instructor_id" required>
        <?php
        $instructors = getAllInstructors($pdo);
        foreach ($instructors as $instructor) {
            echo "<option value='{$instructor['instructor_id']}'>{$instructor['name']}</option>";
        }
        ?>
    </select><br>
    <label for="start_date">Start Date:</label><br>
    <input type="date" name="start_date" required><br>
    <label for="location">Location:</label><br>
    <input type="text" name="location" required><br>
    <button type="submit" name="add_schedule">Add Schedule</button>
</form>

<h2>Edit Schedule</h2>
<?php if (isset($schedule)): ?>
    <form method="post" action="schedules.php?edit=<?php echo $schedule['schedule_id']; ?>">
        <label for="course_id">Course:</label><br>
        <select name="course_id" required>
            <?php
            $courses = getAllCourses($pdo);
            foreach ($courses as $course) {
                $selected = $course['course_id'] == $schedule['course_id'] ? 'selected' : '';
                echo "<option value='{$course['course_id']}' $selected>{$course['title']}</option>";
            }
            ?>
        </select><br>
        <label for="instructor_id">Instructor:</label><br>
        <select name="instructor_id" required>
            <?php
            $instructors = getAllInstructors($pdo);
            foreach ($instructors as $instructor) {
                $selected = $instructor['instructor_id'] == $schedule['instructor_id'] ? 'selected' : '';
                echo "<option value='{$instructor['instructor_id']}' $selected>{$instructor['name']}</option>";
            }
            ?>
        </select><br>
        <label for="start_date">Start Date:</label><br>
        <input type="date" name="start_date" value="<?php echo $schedule['start_date']; ?>" required><br>
        <label for="location">Location:</label><br>
        <input type="text" name="location" value="<?php echo $schedule['location']; ?>" required><br>
        <button type="submit" name="edit_schedule">Update Schedule</button>
    </form>
<?php endif; ?>

<h2>Schedules List</h2>
<table>
    <tr><th>ID</th><th>Course</th><th>Instructor</th><th>Start Date</th><th>Location</th><th>Actions</th></tr>
    <?php
    $schedules = getAllSchedules($pdo);
    foreach ($schedules as $schedule) {
        echo "<tr>
            <td>{$schedule['schedule_id']}</td>
            <td>{$schedule['title']}</td>
            <td>{$schedule['name']}</td>
            <td>{$schedule['start_date']}</td>
            <td>{$schedule['location']}</td>
            <td>
                <a href='schedules.php?edit={$schedule['schedule_id']}'>Edit</a> | 
                <a href='schedules.php?delete={$schedule['schedule_id']}'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>
