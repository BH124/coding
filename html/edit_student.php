<!-- this is edit_student.php -->
<?php
session_start();
// Check if user is logged in

?>
<?php
// Include the database connection file
include_once "db_connection.php";

// Initialize variables to hold student information
$student_id = $username = $email = $class = $address = $phone_number = "";

// Check if student ID is provided in the URL
if(isset($_GET['id'])) {
    // Sanitize the student ID
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Perform a query to fetch student data based on ID
    try {
        $query = "SELECT * FROM students WHERE student_id = :student_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':student_id', $id);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        // If student is found, populate the variables with fetched data
        if($student) {
            $student_id = $student['student_id'];
            $username = $student['username'];
            $email = $student['email'];
            $class = $student['class'];
            $address = $student['address'];
            $phone_number = $student['phone_number'];
        }
    } catch(PDOException $e) {
        // Log the error or handle it appropriately
        echo "Error: " . $e->getMessage();
        // Terminate script execution or redirect to an error page
        exit();
    }
}

// Note: No redirection here if ID is not provided, allowing access to the edit page without ID
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
</head>

<body class="fix-header card-no-border fix-sidebar">
    <div id="main-wrapper">
        <!-- Topbar header -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>
                            <!-- Dark Logo icon -->
                            <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!-- Logo text -->
                        <span>
                            <!-- Dark Logo text -->
                            <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo text -->
                            <img src="../assets/images/logo-light-text.png" alt="homepage" class="light-logo" />
                        </span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"
                                href="javascript:void(0)"><i class="fa fa-bars"></i></a>
                        </li>
                        <!-- Search -->
                        <li class="nav-item hidden-xs-down search-box">
                            <a class="nav-link hidden-sm-down waves-effect waves-dark"
                                href="javascript:void(0)"><i class="fa fa-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter">
                                <a class="srh-btn"><i class="fa fa-times"></i></a>
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
                            <!-- <p>This is the index page.</p> -->
                            <a href="logout.php">Logout</a>
                        <li class="nav-item dropdown u-pro">
                            <!-- <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="../assets/images/users/1.jpg" alt="user" class="" /> 
                                <span class="hidden-md-down">Batct &nbsp;</span>
                            </a> -->
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="signin_page.php">Sign In</a></li>
                                <li><a class="dropdown-item" href="signup_page.php#">Sign Up</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- End Topbar header -->
        <!-- Left Sidebar -->
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a class="waves-effect waves-dark" href="index.php" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="pages-profile.html" aria-expanded="false"><i
                                    class="fa fa-user-circle-o"></i><span class="hide-menu">Profile</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="view_student.php" aria-expanded="false"><i
                                    class="fa fa-table"></i><span class="hide-menu">View List Student</span></a>
                        </li>
                    </ul>
                    <div class="text-center mt-4">
                        <a href="https://www.wrappixel.com/templates/adminwrap/"
                            class="btn waves-effect waves-light btn-info hidden-md-down text-white"> Upgrade to Pro</a>
                    </div>
                </nav>
            </div>
        </aside>
        <!-- End Left Sidebar -->
        <!-- Page wrapper -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Edit Student</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="edit_student_process.php" method="post">
                                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                                    <div class="form-group">
                                        <label for="student_id">Student ID</label>
                                        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
                                    </div>

                                    <!-- Remaining form fields for editing student information -->

                                    <div class="form-group">
                                        <label for="username">Name</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="<?php echo $username; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo $email; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password">
                                    </div>

                                    <div class="form-group">
                                        <label for="class">Class</label>
                                        <input type="text" class="form-control" id="class" name="class"
                                            value="<?php echo $class; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="<?php echo $address; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            value="<?php echo $phone_number; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer -->
            <footer class="footer"> © 2021 Adminwrap by <a href="https://www.wrappixel.com/">wrappixel.com</a> </footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="../assets/node_modules/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/node_modules/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
</body>

</html>
