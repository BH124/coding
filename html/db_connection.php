<?php
// db_connection.php
$host = 'localhost';
$dbname = 'btec_student';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Log the error or handle it appropriately
    echo "Connection failed: " . $e->getMessage();
    // Terminate script execution or redirect to an error page
    exit();
}
?>
