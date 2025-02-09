<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="employee_dashboard.css"> <!-- Link to your CSS -->
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Welcome to your employee dashboard.</p>

        <!-- Navigation Menu -->
        <nav>
            <ul>
                <li><a href="attendance.php">Attendance</a></li>
                <li><a href="tasks.php">Tasks</a></li>
                <li><a href="leave_request.php">Leave Request</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
