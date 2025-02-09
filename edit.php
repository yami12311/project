

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="edit.css">
       <!-- Bootstrap CSS -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Edit Employee</h1>
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </header>

        <main class="content">
    <form method="POST">
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user icon"></i> Username:</label>
            <input type="text" name="username" class="form-control" value="<?php echo $employee['username']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-envelope icon"></i> Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo $employee['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-building icon"></i> Department:</label>
            <input type="text" name="department" class="form-control" value="<?php echo $employee['department']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-briefcase icon"></i> Position:</label>
            <input type="text" name="position" class="form-control" value="<?php echo $employee['position']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-dollar-sign icon"></i> Salary:</label>
            <input type="number" name="salary" class="form-control" value="<?php echo $employee['salary']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fas fa-calendar icon"></i> Join Date:</label>
            <input type="date" name="join_date" class="form-control" value="<?php echo $employee['join_date']; ?>" required>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Employee</button>
    </form>
</main>

    </div>
</body>
</html>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
