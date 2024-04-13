<!-- this is edit_student_process.php -->
<?php
// Include the database connection file
include_once "db_connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST["student_id"], $_POST["username"], $_POST["email"])) {
        // Sanitize input data
        $student_id = filter_var($_POST["student_id"], FILTER_SANITIZE_NUMBER_INT);
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $class = isset($_POST["class"]) ? filter_var($_POST["class"], FILTER_SANITIZE_STRING) : null;
        $address = isset($_POST["address"]) ? filter_var($_POST["address"], FILTER_SANITIZE_STRING) : null;
        $phone_number = isset($_POST["phone_number"]) ? filter_var($_POST["phone_number"], FILTER_SANITIZE_STRING) : null;

        // Handle password update securely
        $password = isset($_POST["password"]) ? $_POST["password"] : null;
        if ($password) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Update password in the database query
            $query = "UPDATE students SET username = :username, email = :email, password = :password, class = :class, address = :address, phone_number = :phone_number WHERE student_id = :student_id";
        } else {
            // Update query without password
            $query = "UPDATE students SET username = :username, email = :email, class = :class, address = :address, phone_number = :phone_number WHERE student_id = :student_id";
        }

        // Update student record in the database
        try {
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            if ($password) {
                $stmt->bindParam(':password', $hashed_password);
            }
            $stmt->bindParam(':class', $class);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();

            // Redirect to the view_student page with a success message
            header("Location: view_student.php?id=$student_id&success=1");
            exit();
        } catch (PDOException $e) {
            // Log the error or handle it appropriately
            echo "Error: " . $e->getMessage();
            // Redirect to the edit page with an error message
            header("Location: edit_student.php?id=$student_id&error=database_error");
            exit();
        }
    } else {
        // Redirect to the edit page with an error message if required fields are not filled
        header("Location: edit_student.php?id=$student_id&error=missing_fields");
        exit();
    }
} else {
    // Redirect to the edit page if form is not submitted
    header("Location: edit_student.php?id=$student_id");
    exit();
}
?>
