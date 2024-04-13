<?php
// admin_dashboard.php

// Check if the user is logged in as an admin
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to the admin login page if not logged in
    header("Location: admin_login.php");
    exit();
}

// Here you can include any necessary header or navigation for your admin dashboard
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include any necessary stylesheets or scripts -->
</head>

<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <!-- Add your dashboard content here -->
    <p>This is where admins can manage their tasks, view reports, etc.</p>
    <a href="logout.php">Logout</a> <!-- Add a logout link to log out admins -->
</body>

</html>
