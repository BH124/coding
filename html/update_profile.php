<?php
session_start(); // Start the session

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: signin_page.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create database connection
    $_servername = "localhost";
    $_username = "root";
    $_password = "";
    $_dbname = "btec_student";
    $conn = new mysqli($_servername, $_username, $_password, $_dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve updated profile information from the form submission
    $name = $_POST['username'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    // Update profile in the database
    // Update profile in the database
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("UPDATE students SET username=?, email=?, class=?, address=?, phone_number=? WHERE username=?");
    $stmt->bind_param("ssssss", $name, $email, $class, $address, $phone_number, $username);

    if ($stmt->execute()) {
        // Profile updated successfully
        // echo "Profile updated successfully.";
        header("Location: edit_profile.php");
    } else {
        // Error updating profile
        echo "Error updating profile: " . $conn->error;
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}
?>
