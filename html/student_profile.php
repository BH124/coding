<!-- this is student_profile.php for student -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include_once "db_connection.php";

// Check if the student_id is provided in the URL
if (!isset($_GET['student_id'])) {
    // Redirect the user to an error page if student_id is not provided
    header("Location: error_page.php");
    exit();
}

// Fetch the student information from the database based on the provided student_id
try {
    $query = "SELECT * FROM students WHERE student_id = :student_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $_GET['student_id']);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the error to a file or database
    error_log("Error fetching student: " . $e->getMessage());
    // Redirect the user to an error page
    header("Location: error_page.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
</head>
<body>
    <h1>Student Profile</h1>
    <div>
        <p>Name: <?php echo isset($student['name']) ? $student['name'] : ""; ?></p>
        <p>Email: <?php echo isset($student['email']) ? $student['email'] : ""; ?></p>
        <p>Class: <?php echo isset($student['class']) ? $student['class'] : ""; ?></p>
        <p>Address: <?php echo isset($student['address']) ? $student['address'] : ""; ?></p>
        <p>Phone Number: <?php echo isset($student['phone_number']) ? $student['phone_number'] : ""; ?></p>
    </div>
</body>
</html>
