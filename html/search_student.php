<!-- this is search_student.php -->
<?php
// Include the database connection file
include_once "db_connection.php";

// Initialize $students variable
$students = [];

// Define a default search query
$searchQuery = "";

// Check if a search query is submitted
if (isset($_GET['search'])) {
    // Sanitize the search query
    $searchQuery = htmlspecialchars($_GET['search']);
    
    // Perform a query to fetch student data based on the search query
    try {
        $query = "SELECT * FROM students WHERE username LIKE :search OR email LIKE :search OR class LIKE :search OR address LIKE :search OR phone_number LIKE :search";
        $stmt = $conn->prepare($query);
        $searchParam = '%' . $searchQuery . '%';
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        // Log the error to a file or database
        error_log("Error fetching students: " . $e->getMessage());
        // Redirect the user to an error page
        header("Location: error_page.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Students</title>
</head>
<body>
    <form action="view_student.php" method="GET">
        <input type="text" username="search" id="searchInput" placeholder="Search students..." value="<?php echo $searchQuery; ?>">
        <button type="submit">Search</button>
    </form>
</body>
</html>
