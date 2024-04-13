<!-- this is delete_student.php -->
<?php
// Include the database connection file
include_once "db_connection.php";

// Check if student ID is provided in the URL
if(isset($_GET['id'])) {
    // Sanitize the student ID
    $student_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Perform a query to delete the student from the database
    try {
        $query = "DELETE FROM students WHERE student_id = :student_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        // Redirect to view_student.php after successful deletion
        header("Location: view_student.php");
        exit();
    } catch(PDOException $e) {
        // Log the error or handle it appropriately
        echo "Error: " . $e->getMessage();
        // Redirect to an error page
        // header("Location: error.php");
        // exit();
    }
} else {
    // Redirect to an error page if student ID is not provided
    // header("Location: error.php");
    // exit();
}
?>
