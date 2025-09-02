<?php
// process.php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Grab and trim form values using the correct keys from index.php
$fullname   = trim($_POST['fullname']   ?? '');
$email      = trim($_POST['email']      ?? '');
$department = trim($_POST['department'] ?? '');
$matric_no  = trim($_POST['matric_no']  ?? '');

$errors = [];

// Basic validations
if ($fullname === '' || $email === '' || $department === '' || $matric_no === '') {
    $errors[] = 'All fields are required.';
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}

if (!empty($errors)) {
    // Simple error output (you can redirect back with session flash if you prefer)
    echo implode('<br>', $errors);
    echo '<br><a href="index.php">Go back</a>';
    exit;
}

// === DB CONFIG (adjust for your setup) ===
$host = 'localhost';
$db   = 'student_db';       // <- change if your DB name is different
$user = 'root';             // XAMPP default
$pass = '';                 // XAMPP default empty password
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Insert using prepared statement
    $sql = "INSERT INTO student_records (full_name, email, department, matric_number)
            VALUES (:full_name, :email, :department, :matric_number)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':full_name'     => $fullname,
        ':email'         => $email,
        ':department'    => $department,
        ':matric_number' => $matric_no,
    ]);

    // Redirect to view page on success
    header('Location: view.php?added=1');
    exit;

} catch (PDOException $e) {
    // Handle duplicates gracefully if you added UNIQUE constraints
    if ($e->getCode() === '23000') {
        echo 'Email or Matric Number already exists.';
    } else {
        echo 'Database error: ' . htmlspecialchars($e->getMessage());
    }
    echo '<br><a href="index.php">Go back</a>';
    exit;
    
}

