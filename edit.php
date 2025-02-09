<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    die("Employee ID not provided.");
}

$employee_id = $_GET['id'];

// Fetch employee details
$query = "SELECT * FROM employees WHERE employee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    die("Employee not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $join_date = $_POST['join_date'];

    $updateQuery = "UPDATE employees SET username=?, email=?, department=?, position=?, salary=?, join_date=? WHERE employee_id=?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssssssi", $username, $email, $department, $position, $salary, $join_date, $employee_id);
    
    if ($updateStmt->execute()) {
        echo "<script>alert('Employee updated successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating employee.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Edit Employee</h1>
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </header>

        <main class="content">
            <form method="POST">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $employee['username']; ?>" required>

                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $employee['email']; ?>" required>

                <label>Department:</label>
                <input type="text" name="department" value="<?php echo $employee['department']; ?>" required>

                <label>Position:</label>
                <input type="text" name="position" value="<?php echo $employee['position']; ?>" required>

                <label>Salary:</label>
                <input type="number" name="salary" value="<?php echo $employee['salary']; ?>" required>

                <label>Join Date:</label>
                <input type="date" name="join_date" value="<?php echo $employee['join_date']; ?>" required>

                <button type="submit">Update Employee</button>
            </form>
        </main>
    </div>
</body>
</html>
