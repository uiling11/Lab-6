<?php
include 'db.php';
include 'functions.php';

// Додавання інструктора
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_instructor'])) {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    insertInstructor($pdo, $name, $specialization);
    header("Location: instructors.php");
    exit();
}

// Редагування інструктора
if (isset($_GET['edit'])) {
    $instructor_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM Instructors WHERE instructor_id = ?");
    $stmt->execute([$instructor_id]);
    $instructor = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_instructor'])) {
        $name = $_POST['name'];
        $specialization = $_POST['specialization'];
        updateInstructor($pdo, $instructor_id, $name, $specialization);
        header("Location: instructors.php");
        exit();
    }
}

// Видалення інструктора
if (isset($_GET['delete'])) {
    $instructor_id = $_GET['delete'];
    deleteInstructor($pdo, $instructor_id);
    header("Location: instructors.php");
    exit();
}
?>

<h2>Add New Instructor</h2>
<form method="post" action="instructors.php">
    <label for="name">Name:</label><br>
    <input type="text" name="name" required><br>
    <label for="specialization">Specialization:</label><br>
    <input type="text" name="specialization" required><br>
    <button type="submit" name="add_instructor">Add Instructor</button>
</form>

<h2>Edit Instructor</h2>
<?php if (isset($instructor)): ?>
    <form method="post" action="instructors.php?edit=<?php echo $instructor['instructor_id']; ?>">
        <label for="name">Name:</label><br>
        <input type="text" name="name" value="<?php echo $instructor['name']; ?>" required><br>
        <label for="specialization">Specialization:</label><br>
        <input type="text" name="specialization" value="<?php echo $instructor['specialization']; ?>" required><br>
        <button type="submit" name="edit_instructor">Update Instructor</button>
    </form>
<?php endif; ?>

<h2>Instructors List</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>Specialization</th><th>Actions</th></tr>
    <?php
    $instructors = getAllInstructors($pdo);
    foreach ($instructors as $instructor) {
        echo "<tr>
            <td>{$instructor['instructor_id']}</td>
            <td>{$instructor['name']}</td>
            <td>{$instructor['specialization']}</td>
            <td>
                <a href='instructors.php?edit={$instructor['instructor_id']}'>Edit</a> | 
                <a href='instructors.php?delete={$instructor['instructor_id']}'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>
