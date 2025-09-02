<?php
// view.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM student_records WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: view.php?deleted=1");
        exit;
    }
}

// Fetch all records into an array
$rows = [];
$sql  = "SELECT * FROM student_records ORDER BY id DESC";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $result->free();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }
        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin-top: 20px;
            width: 80%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px 15px;
            text-align: center;
        }
        h2 {
            margin-bottom: 10px;
        }
        a {
            margin-top: 15px;
            text-decoration: none;
            color: blue;
        }
        .msg {
            margin-top: 10px;
            padding: 8px;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Registered Students</h2>

    <?php
    if (isset($_GET['added'])) {
        echo '<div class="msg">✅ Student added successfully!</div>';
    } elseif (isset($_GET['deleted'])) {
        echo '<div class="msg" style="color:darkred">✅ Student deleted successfully!</div>';
    }
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Matric Number</th>
            <th>Action</th>
        </tr>

        <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?php echo (int)$row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['matric_number'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="view.php?delete=<?php echo (int)$row['id']; ?>" onclick="return confirm('Delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No students found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="index.php">Register New Student</a>

    <?php $conn->close(); ?>
</body>
</html>
