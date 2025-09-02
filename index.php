<?php
// index.php
$success = isset($_GET['success']) ? (int)$_GET['success'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
        }
        .container {
            width: 400px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
            margin: auto;
        }
        h2 {
            text-align: center;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background: #218838;
            cursor: pointer;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            text-decoration: none;
            color: #007bff;
        }
        .success {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Registration</h2>

    <?php if ($success === 1): ?>
        <div class="success">✅ Student added successfully!</div>
    <?php endif; ?>

    <form action="process.php" method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Department</label>
        <input type="text" name="department" required>

        <label>Matric Number</label>
        <input type="text" name="matric_no" required>

        <button type="submit">Register</button>
    </form>

    <div class="link">
        <a href="view.php">View Registered Students</a>
    </div>
</div>

</body>
</html>
