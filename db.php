<?php
$servername = "localhost";
$username = "root";  // За замовчуванням ім'я користувача - root
$password = "";      // За замовчуванням порожній пароль
$dbname = "lab5";  // Назва вашої бази даних

// Створення з’єднання
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з’єднання
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
