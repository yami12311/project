<?php
session_start();
include('db_config.php');

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch counts
$tables = ['admins', 'employees', 'attendance', 'leave_request', 'task', 'user_profile'];
$counts = [];
foreach ($tables as $table) {
    $query = "SELECT COUNT(*) AS count FROM $table";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $counts[$table] = $row['count'];
}

// Fetch latest data
$latestEmployees = $conn->query("SELECT username, email FROM employees ORDER BY employee_id DESC LIMIT 5");
$latestLeaves = $conn->query("SELECT leave_request_id, employee_id, leave_type, status FROM leave_request ORDER BY leave_request_id DESC LIMIT 5");
$latestTasks = $conn->query("SELECT task_id, employee_id, task_name, status FROM task ORDER BY task_id DESC LIMIT 5");
$attendanceRecords = $conn->query("SELECT employee_id, attendance_date, status FROM attendance ORDER BY attendance_id DESC LIMIT 5");
$employees = $conn->query("SELECT * FROM employees");
// Fetch the logged-in admin's profile information
$profileQuery = "SELECT profile_id, employee_id, username, password, role, last_login FROM user_profile WHERE username = '" . $_SESSION['username'] . "' LIMIT 1";
$profileResult = $conn->query($profileQuery);
$profile = $profileResult->fetch_assoc();


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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
            <div class="header-title">Employee Management</div>
            <a href="login.html" class="logout">Logout</a>
        </header>

        <nav class="sidebar">
            <button onclick="showTab('dashboard-overview')">Overview</button>
            <button onclick="showTab('manage-employees')">Manage Employees</button>
            <button onclick="showTab('manage-tasks')">Tasks</button>
            <button onclick="showTab('manage-leaves')">Leave Requests</button>
            <button onclick="showTab('manage-attendance')">Attendance</button>
            <button onclick="showTab('manage-profile')">Profile</button>
        </nav>

        <main class="content">
            <!-- Dashboard Overview -->
            <div id="dashboard-overview" class="tab-content">
                <h2>Dashboard Overview</h2>
                <div class="dashboard">
                    <?php foreach ($counts as $key => $count) { ?>
                        <div class="card"><h3><?php echo ucfirst(str_replace('_', ' ', $key)); ?></h3><p><?php echo $count; ?></p></div>
                    <?php } ?>
                </div>
            </div>

            <!-- Manage Employees -->
            <div id="manage-employees" class="tab-content" style="display: none;">
                <h2>Manage Employees</h2>
                <table>
                    <tr>
                        <th>Employee ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = $employees->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['employee_id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><?php echo $row['position']; ?></td>
                            <td><?php echo $row['salary']; ?></td>
                            <td>
                                <a href='edit.php?id=<?php echo $row['employee_id']; ?>'>Edit</a> |
                                <a href='delete_employee.php?id=<?php echo $row['employee_id']; ?>' onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

   <!-- Manage Tasks -->
<div id="manage-tasks" class="tab-content" style="display: none;">
    <h2>Manage Tasks</h2>

    <!-- Button to Redirect to Create Task Page -->
    <a href="create_task.php" class="button">Create New Task</a>
    
    <!-- Existing Tasks -->
    <h3>Existing Tasks</h3>
    <table>
        <tr>
            <th>Task ID</th>
            <th>Task Name</th>
            <th>Assigned To (ID)</th>
            <th>Description</th>
            <th>Assigned Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
            // Fetch all tasks
            $tasksResult = $conn->query("SELECT * FROM task ORDER BY task_id DESC");
            while ($task = $tasksResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$task['task_id']}</td>
                        <td>{$task['task_name']}</td>
                        <td>{$task['employee_id']}</td>
                        <td>{$task['description']}</td>
                        <td>{$task['assigned_date']}</td>
                        <td>{$task['due_date']}</td>
                        <td>{$task['status']}</td>
                        <td>
                            <a href='edit_task.php?id={$task['task_id']}'>Edit</a> |
                            <a href='delete_task.php?id={$task['task_id']}'>Delete</a>
                        </td>
                    </tr>";
            }
        ?>
    </table>
</div>

            <!-- Manage Leave Requests -->
            <div id="manage-leaves" class="tab-content" style="display: none;">
                <h2>Recent Leave Requests</h2>
                <table>
                    <tr><th>Employee ID</th><th>Leave Type</th><th>Status</th><th>Action</th></tr>
                    <?php while ($row = $latestLeaves->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['employee_id']; ?></td>
                            <td><?php echo $row['leave_type']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <a href='process_leave.php?id=<?php echo $row['leave_request_id']; ?>&status=Approved'>Approve</a> |
                                    <a href='process_leave.php?id=<?php echo $row['leave_request_id']; ?>&status=Rejected'>Reject</a>
                                <?php } else { echo $row['status']; } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>


            <div id="manage-attendance" class="tab-content" style="display: none;">
    <h2>Recent Attendance Records</h2>
    <table>
        <tr>
            <th>Attendance ID</th>
            <th>Employee ID</th>
            <th>Date</th>
            <th>Check-in Time</th>
            <th>Check-out Time</th>
            <th>Status</th>
            <th>Work Hours</th>
            <th>Remarks</th>
        </tr>
        <?php 
        // Fetch the attendance records, including all necessary columns
        $attendanceRecords = $conn->query("SELECT attendance_id, employee_id, attendance_date, check_in_time, check_out_time, status, work_hours, remarks FROM attendance ORDER BY attendance_id DESC LIMIT 100");
        
        // Check if there are any records and loop through them
        while ($row = $attendanceRecords->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['attendance_id']; ?></td>
                <td><?php echo $row['employee_id']; ?></td>
                <td><?php echo $row['attendance_date']; ?></td>
                <td><?php echo $row['check_in_time']; ?></td>
                <td><?php echo $row['check_out_time']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['work_hours']; ?></td>
                <td><?php echo $row['remarks']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<div id="manage-profile" class="tab-content" style="display: none;">
    <h2>User Profile</h2>
    <?php if ($profile): ?>
        <table>
            <tr>
                <th>Profile ID</th>
                <td><?php echo htmlspecialchars($profile['profile_id']); ?></td>
            </tr>
            <tr>
                <th>Employee ID</th>
                <td><?php echo htmlspecialchars($profile['employee_id']); ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($profile['username']); ?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td>****** (For security reasons, don't show the password directly)</td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo htmlspecialchars($profile['role']); ?></td>
            </tr>
            <tr>
                <th>Last Login</th>
                <td><?php echo htmlspecialchars($profile['last_login']); ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>No profile found.</p>
    <?php endif; ?>
</div>


        </main>
    </div>
</body>
</html>
