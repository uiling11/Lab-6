<?php
include 'db.php';
include 'functions.php';

// Додавання студента
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    insertStudent($pdo, $name, $email, $phone);
    header("Location: students.php");
}

// Редагування студента
if (isset($_GET['edit'])) {
    $student_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM Students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        updateStudent($pdo, $student_id, $name, $email, $phone);
        header("Location: students.php");
    }
}

// Видалення студента
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    deleteStudent($pdo, $student_id);
    header("Location: students.php");
}
?>

<h2>Add New Student</h2>
<form method="post" action="students.php">
    <label for="name">Name:</label><br>
    <input type="text" name="name" required><br>
    <label for="email">Email:</label><br>
    <input type="email" name="email" required><br>
    <label for="phone">Phone:</label><br>
    <input type="text" name="phone" required><br>
    <button type="submit" name="add_student">Add Student</button>
</form>

<h2>Edit Student</h2>
<?php if (isset($student)): ?>
    <form method="post" action="students.php?edit=<?php echo $student['student_id']; ?>">
        <label for="name">Name:</label><br>
        <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo $student['email']; ?>" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" name="phone" value="<?php echo $student['phone']; ?>" required><br>
        <button type="submit" name="edit_student">Update Student</button>
    </form>
<?php endif; ?>

<h2>Students List</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
    <?php
    $students = getAllStudents($pdo);
    foreach ($students as $student) {
        echo "<tr>
            <td>{$student['student_id']}</td>
            <td>{$student['name']}</td>
            <td>{$student['email']}</td>
            <td>{$student['phone']}</td>
            <td>
                <a href='students.php?edit={$student['student_id']}'>Edit</a> | 
                <a href='students.php?delete={$student['student_id']}'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>
