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
    <link rel="stylesheet" href="">
    <!-- Add Bootstrap CSS -->
     <!-- FontAwesome CDN for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container-fluid">
        <header class="row bg-primary text-white p-4">
            <div class="col">
                <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
                <div class="h5">Employee Management</div>
            </div>
            <div class="col text-right">
                <a href="login.html" class="btn btn-outline-light">Logout</a>
            </div>
        </header>

        <div class="row">
            <nav class="col-md-2 bg-light sidebar p-3">
    <h4>Admin Dashboard</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <button class="btn btn-link" onclick="showTab('dashboard-overview')">
                <i class="fas fa-tachometer-alt"></i> Overview
            </button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link" onclick="showTab('manage-employees')">
                <i class="fas fa-users"></i> Manage Employees
            </button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link" onclick="showTab('manage-tasks')">
                <i class="fas fa-tasks"></i> Tasks
            </button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link" onclick="showTab('manage-leaves')">
                <i class="fas fa-calendar-check"></i> Leave Requests
            </button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link" onclick="showTab('manage-attendance')">
                <i class="fas fa-clock"></i> Attendance
            </button>
        </li>
        <li class="nav-item">
            <button class="btn btn-link" onclick="showTab('manage-profile')">
                <i class="fas fa-user"></i> Profile
            </button>
        </li>
    </ul>
</nav>


            <main class="col-md-10 p-3">
                <!-- Dashboard Overview -->
                <div id="dashboard-overview" class="tab-content">
                    <h2>Dashboard Overview</h2>
                    <div class="row">
                        <?php foreach ($counts as $key => $count) { ?>
                            <div class="col-md-2">
                                <div class="card p-3">
                                    <h5 class="card-title"><?php echo ucfirst(str_replace('_', ' ', $key)); ?></h5>
                                    <p class="card-text"><?php echo $count; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Manage Employees -->
                <div id="manage-employees" class="tab-content" style="display: none;">
                    <h2>Manage Employees</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $employees->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['employee_id']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['department']; ?></td>
                                    <td><?php echo $row['position']; ?></td>
                                    <td><?php echo $row['salary']; ?></td>
                                    <td>
                                    <a href='edit.php?id=<?php echo $row['employee_id']; ?>' class="btn btn-sm btn-warning">
    <i class="fas fa-edit"></i> Edit
</a> |
<a href='delete_employee.php?id=<?php echo $row['employee_id']; ?>' onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
    <i class="fas fa-trash-alt"></i> Delete
</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Manage Tasks -->
                <div id="manage-tasks" class="tab-content" style="display: none;">
                    <h2>Manage Tasks</h2>
                    <a href="create_task.php" class="btn btn-primary mb-3">Create New Task</a>
                    <h3>Existing Tasks</h3>
                    <table class="table table-bordered">
                        <thead>
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
                        </thead>
                        <tbody>
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
                                                <a href='edit_task.php?id={$task['task_id']}' class='btn btn-sm btn-warning'>Edit</a> |
                                                <a href='delete_task.php?id={$task['task_id']}' class='btn btn-sm btn-danger'>Delete</a>
                                            </td>
                                        </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Manage Leave Requests -->
                <div id="manage-leaves" class="tab-content" style="display: none;">
                    <h2>Recent Leave Requests</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Leave Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $latestLeaves->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['employee_id']; ?></td>
                                    <td><?php echo $row['leave_type']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'Pending') { ?>
                                            <a href='process_leave.php?id=<?php echo $row['leave_request_id']; ?>&status=Approved' class="btn btn-sm btn-success">Approve</a> |
                                            <a href='process_leave.php?id=<?php echo $row['leave_request_id']; ?>&status=Rejected' class="btn btn-sm btn-danger">Reject</a>
                                        <?php } else { echo $row['status']; } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Manage Attendance -->
                <div id="manage-attendance" class="tab-content" style="display: none;">
                    <h2>Recent Attendance Records</h2>
                    <table class="table table-bordered">
                        <thead>
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
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>
                </div>

                <!-- Manage Profile -->
                <div id="manage-profile" class="tab-content" style="display: none;">
                    <h2>User Profile</h2>
                    <?php if ($profile): ?>
                        <table class="table">
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
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
