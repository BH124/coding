<!-- this is add_student_process.php -->
<?php
// add_student_process.php
include_once('db_connection.php');

// Check if connection is established successfully
if ($conn) {
    // Validate and sanitize user input (not shown here for brevity)
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $class = $_POST['class'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    // Your SQL query goes here
    // For example, to insert data into a table named 'students'
    $sql = "INSERT INTO students (username, email, password, class, address, phone_number)
            VALUES (:username, :email, :password, :class, :address, :phone_number)";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone_number', $phone_number);
    
    // Execute the query
    try {
        $stmt->execute();
        // Redirect to view_student.php after successful insertion
        header("location: view_student.php");
        exit();
    } catch (PDOException $e) {
        // Log the error or handle it appropriately
        echo "Error: " . $e->getMessage();
        // Terminate script execution or redirect to an error page
        exit();
    }
} else {
    echo "Failed to connect to database";
}
?>
