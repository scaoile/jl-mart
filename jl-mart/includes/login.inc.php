<?php



if (isset($_POST["submit"])) {

    // Grabs Data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Run Controller Class
    include("../classes/database-connect.php");
    include("../classes/login-ctrl.php");
    include("../classes/admin-login-ctrl.php");

    if ($_GET['role'] == 'manager') {
        $login = new AdminLoginCtrl($email, $password);
    } else {
        $login = new LoginCtrl($email, $password);
    }

    // Handles errors and User Login
    $login->loginUser();

    session_start();

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'manager') {
        header("location: ../views/adminDashboard.php?message=Welcome Back Manager");
    } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'customer') {
        header("location: ../views/homepage.php?message=Log In Success");
    }
}
