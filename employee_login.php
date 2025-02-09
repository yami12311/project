<?php
// Start the session
session_start();

// Include the database connection file
include('db_config.php'); // Modify with your database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from POST data
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Prepare SQL query to get the employee by username
    $sql = "SELECT id, username, password FROM employees WHERE username = ?";
    $stmt = $conn->prepare($sql); // Prepare the statement
    $stmt->bind_param("s", $username); // Bind parameters (s - string)
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Get the result

    if ($result->num_rows == 1) {
        // Fetch the employee record
        $employee = $result->fetch_assoc();

        // Compare the entered password with the hashed password using password_verify
        if (password_verify($password, $employee['password'])) {
            // Password is correct, set session variables
            $_SESSION['employee_id'] = $employee['id'];
            $_SESSION['username'] = $employee['username'];

            // Redirect to the employee dashboard
            header('Location: employee_sdashboard.php'); // Redirect to the dashboard
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No employee found with that username.";
    }
}
?>
