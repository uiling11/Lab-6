<?php

// Функції для роботи з таблицею Students
function getAllStudents($pdo) {
    $stmt = $pdo->query("SELECT * FROM Students");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertStudent($pdo, $name, $email, $phone) {
    $stmt = $pdo->prepare("INSERT INTO Students (name, email, phone) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $phone]);
}

function updateStudent($pdo, $student_id, $name, $email, $phone) {
    $stmt = $pdo->prepare("UPDATE Students SET name = ?, email = ?, phone = ? WHERE student_id = ?");
    $stmt->execute([$name, $email, $phone, $student_id]);
}

function deleteStudent($pdo, $student_id) {
    $stmt = $pdo->prepare("DELETE FROM Students WHERE student_id = ?");
    $stmt->execute([$student_id]);
}

// Функції для роботи з таблицею Instructors
function getAllInstructors($pdo) {
    $stmt = $pdo->query("SELECT * FROM Instructors");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertInstructor($pdo, $name, $specialization) {
    $stmt = $pdo->prepare("INSERT INTO Instructors (name, specialization) VALUES (?, ?)");
    $stmt->execute([$name, $specialization]);
}

function updateInstructor($pdo, $instructor_id, $name, $specialization) {
    $stmt = $pdo->prepare("UPDATE Instructors SET name = ?, specialization = ? WHERE instructor_id = ?");
    $stmt->execute([$name, $specialization, $instructor_id]);
}

function deleteInstructor($pdo, $instructor_id) {
    $stmt = $pdo->prepare("DELETE FROM Instructors WHERE instructor_id = ?");
    $stmt->execute([$instructor_id]);
}

// Функції для роботи з таблицею Courses
function getAllCourses($pdo) {
    $stmt = $pdo->query("SELECT * FROM Courses");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertCourse($pdo, $title, $category, $duration) {
    $stmt = $pdo->prepare("INSERT INTO Courses (title, category, duration) VALUES (?, ?, ?)");
    $stmt->execute([$title, $category, $duration]);
}

function updateCourse($pdo, $course_id, $title, $category, $duration) {
    $stmt = $pdo->prepare("UPDATE Courses SET title = ?, category = ?, duration = ? WHERE course_id = ?");
    $stmt->execute([$title, $category, $duration, $course_id]);
}

function deleteCourse($pdo, $course_id) {
    $stmt = $pdo->prepare("DELETE FROM Courses WHERE course_id = ?");
    $stmt->execute([$course_id]);
}

// Функції для роботи з таблицею Schedules
function getAllSchedules($pdo) {
    $stmt = $pdo->query("SELECT * FROM Schedules");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertSchedule($pdo, $course_id, $instructor_id, $start_date, $location) {
    $stmt = $pdo->prepare("INSERT INTO Schedules (course_id, instructor_id, start_date, location) VALUES (?, ?, ?, ?)");
    $stmt->execute([$course_id, $instructor_id, $start_date, $location]);
}

function updateSchedule($pdo, $schedule_id, $course_id, $instructor_id, $start_date, $location) {
    $stmt = $pdo->prepare("UPDATE Schedules SET course_id = ?, instructor_id = ?, start_date = ?, location = ? WHERE schedule_id = ?");
    $stmt->execute([$course_id, $instructor_id, $start_date, $location, $schedule_id]);
}

function deleteSchedule($pdo, $schedule_id) {
    $stmt = $pdo->prepare("DELETE FROM Schedules WHERE schedule_id = ?");
    $stmt->execute([$schedule_id]);
}

// Функції для роботи з таблицею TestResults
function getAllTestResults($pdo) {
    $stmt = $pdo->query("SELECT * FROM TestResults");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertTestResult($pdo, $student_id, $course_id, $score) {
    $stmt = $pdo->prepare("INSERT INTO TestResults (student_id, course_id, score) VALUES (?, ?, ?)");
    $stmt->execute([$student_id, $course_id, $score]);
}

function updateTestResult($pdo, $result_id, $student_id, $course_id, $score) {
    $stmt = $pdo->prepare("UPDATE TestResults SET student_id = ?, course_id = ?, score = ? WHERE result_id = ?");
    $stmt->execute([$student_id, $course_id, $score, $result_id]);
}

function deleteTestResult($pdo, $result_id) {
    $stmt = $pdo->prepare("DELETE FROM TestResults WHERE result_id = ?");
    $stmt->execute([$result_id]);
}
?>
