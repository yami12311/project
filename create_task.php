<?php
session_start();
include('db_config.php');

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle task creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_task'])) {
    $taskName = $_POST['task_name'];
    $employeeId = $_POST['employee_id'];
    $description = $_POST['description'];
    $assignedDate = $_POST['assigned_date'];
    $dueDate = $_POST['due_date'];
    $status = $_POST['status'];

    // Insert new task into the database
    $insertQuery = "INSERT INTO task (task_name, employee_id, description, assigned_date, due_date, status) 
                    VALUES ('$taskName', '$employeeId', '$description', '$assignedDate', '$dueDate', '$status')";

    if ($conn->query($insertQuery)) {
        echo "<script>alert('Task created successfully!');</script>";
    } else {
        echo "<script>alert('Error creating task: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="create_task.css">
</head>
<body>
    <h2>Create New Task</h2>
    <form method="POST" action="">
        <label for="task_name">Task Name:</label>
        <input type="text" name="task_name" required><br><br>

        <label for="employee_id">Assign to Employee (ID):</label>
        <select name="employee_id" required>
            <?php 
            // Fetch employees to assign task
            $employees = $conn->query("SELECT * FROM employees");
            while ($employee = $employees->fetch_assoc()) { ?>
                <option value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['username']; ?> (ID: <?php echo $employee['employee_id']; ?>)</option>
            <?php } ?>
        </select><br><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br><br>

        <label for="assigned_date">Assigned Date:</label>
        <input type="date" name="assigned_date" required><br><br>

        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" required><br><br>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select><br><br>

        <button type="submit" name="create_task">Create Task</button>
    </form>
</body>
</html>
