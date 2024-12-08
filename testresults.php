<?php
require_once 'functions.php'; // Підключаємо функції для роботи з базою даних

// Підключення до бази даних
$pdo = new PDO('mysql:host=localhost;dbname=your_database_name', 'username', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Додавання нового результату
if (isset($_POST['add_result'])) {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $score = $_POST['score'];
    insertTestResult($pdo, $student_id, $course_id, $score);
}

// Оновлення результату
if (isset($_POST['edit_result'])) {
    $result_id = $_POST['result_id'];
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $score = $_POST['score'];
    updateTestResult($pdo, $result_id, $student_id, $course_id, $score);
}

// Видалення результату
if (isset($_GET['delete'])) {
    $result_id = $_GET['delete'];
    deleteTestResult($pdo, $result_id);
}

// Отримуємо список всіх результатів
$results = getAllTestResults($pdo);

// Отримуємо всі студентів і курси для вибору в формах
$students = getAllStudents($pdo);
$courses = getAllCourses($pdo);

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
</head>
<body>

<h2>Add New Test Result</h2>
<form method="post" action="testresults.php">
    <label for="student_id">Student:</label><br>
    <select name="student_id" required>
        <?php
        foreach ($students as $student) {
            echo "<option value='{$student['student_id']}'>{$student['name']}</option>";
        }
        ?>
    </select><br>

    <label for="course_id">Course:</label><br>
    <select name="course_id" required>
        <?php
        foreach ($courses as $course) {
            echo "<option value='{$course['course_id']}'>{$course['title']}</option>";
        }
        ?>
    </select><br>

    <label for="score">Score:</label><br>
    <input type="number" name="score" required><br>

    <button type="submit" name="add_result">Add Result</button>
</form>

<h2>Edit Test Result</h2>
<?php if (isset($result)): ?>
    <form method="post" action="testresults.php?edit=<?php echo $result['result_id']; ?>">
        <input type="hidden" name="result_id" value="<?php echo $result['result_id']; ?>">
        
        <label for="student_id">Student:</label><br>
        <select name="student_id" required>
            <?php
            foreach ($students as $student) {
                $selected = ($student['student_id'] == $result['student_id']) ? 'selected' : '';
                echo "<option value='{$student['student_id']}' {$selected}>{$student['name']}</option>";
            }
            ?>
        </select><br>

        <label for="course_id">Course:</label><br>
        <select name="course_id" required>
            <?php
            foreach ($courses as $course) {
                $selected = ($course['course_id'] == $result['course_id']) ? 'selected' : '';
                echo "<option value='{$course['course_id']}' {$selected}>{$course['title']}</option>";
            }
            ?>
        </select><br>

        <label for="score">Score:</label><br>
        <input type="number" name="score" value="<?php echo $result['score']; ?>" required><br>

        <button type="submit" name="edit_result">Update Result</button>
    </form>
<?php endif; ?>

<h2>Test Results List</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Student</th>
        <th>Course</th>
        <th>Score</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($results as $result) {
        $student = getStudentById($pdo, $result['student_id']);
        $course = getCourseById($pdo, $result['course_id']);
        echo "<tr>
            <td>{$result['result_id']}</td>
            <td>{$student['name']}</td>
            <td>{$course['title']}</td>
            <td>{$result['score']}</td>
            <td>
                <a href='testresults.php?edit={$result['result_id']}'>Edit</a> | 
                <a href='testresults.php?delete={$result['result_id']}'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
