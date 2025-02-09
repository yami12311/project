<?php
session_start();
include('db_config.php');  // Include your database configuration file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        die("Please fill all the fields.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password for secure storage
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if username already exists
    $check_query = "SELECT * FROM employees WHERE username = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        die("Username already exists. Please choose a different username.");
    }

    // Insert new employee data into the database
    $insert_query = "INSERT INTO employees (username, email, password) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($insert_stmt->execute()) {
        // Redirect to login page or display success message
        echo "Registration successful. You can now <a href='login.html'>login</a>.";
    } else {
        die("Error: " . $insert_stmt->error);
    }
}
?>
