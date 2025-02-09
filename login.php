<?php
// Start the session to store login info
session_start();

// Include the database connection file
include('db_config.php'); // Modify with your database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from POST
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Prepare SQL query to get the admin data by username
    $sql = "SELECT id, username, password FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql); // Prepare the statement
    $stmt->bind_param("s", $username); // Bind parameters (s - string)
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Get the result

    if ($result->num_rows == 1) {
        // Fetch the admin record
        $admin = $result->fetch_assoc();

        // Compare the plain-text password with the hashed password using password_verify
        if (password_verify($password, $admin['password'])) {
            // Password is correct, set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];

            // Redirect to the dashboard or any page after successful login
            header('Location: dashboard.php'); // Redirect to the dashboard
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No admin found with that username.";
    }
}
?>
<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include('db_config.php'); // Ensure your db_config.php has the correct connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from POST
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // First, check if the username exists in the employees table
    $sql = "SELECT employee_id, username, password FROM employees WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // If the username exists in employees, verify the password
        $employee = $result->fetch_assoc();
        if (password_verify($password, $employee['password'])) {
            // Correct password, start session for employee
            $_SESSION['employee_id'] = $employee['employee_id'];
            $_SESSION['username'] = $employee['username'];

            // Redirect to employee dashboard
            header('Location: employee_dashboard.php');
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        // If username not found in employees, check the admins table
        $sql = "SELECT id, username, password FROM admins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // If the username exists in admins, verify the password
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                // Correct password, start session for admin
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];

                // Redirect to admin dashboard
                header('Location: admin_dashboard.php');
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            // No user found with the given username
            echo "No user found with that username.";
        }
    }
}
?>