<?php
// Include the database connection file
include('db_config.php'); // Modify with your database connection file

// Admin details (replace these with actual data or inputs from a form)
$username = "admin"; // Replace with the desired admin username
$password = "admin123"; // Replace with the desired admin password
$contact_number = "1234567890"; // Replace with the admin's contact number
$email = "admin@example.com"; // Replace with the admin's email

// Check if the username is already taken
$sql_check = "SELECT id FROM admins WHERE username = ? OR email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $username, $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "Username or email already taken, please choose a different one.";
    exit;
}

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL query to insert the new admin
$sql = "INSERT INTO admins (username, password, contact_number, email) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql); // Prepare the statement
$stmt->bind_param("ssss", $username, $hashed_password, $contact_number, $email); // Bind parameters (s - string)
$stmt->execute(); // Execute the query

// Check if the admin was added successfully
if ($stmt->affected_rows > 0) {
    echo "Admin created successfully.";
} else {
    echo "Error creating admin.";
}
?>
