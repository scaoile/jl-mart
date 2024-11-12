<?php

if (isset($_POST["submit"])) {

    echo "User Signed Up";

    // Grabs Data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Run Controller Class
    include("../classes/database-connect.php");
    include("../classes/signup-ctrl.php");

    $signup = new SignupCtrl($name, $email, $phone, $address, $password, $confirm_password);


    // Handles errors and User Signup
    $signup->signupUser();


    // Goes back to Signup Form
    header("location: ../views/signup.php?message=Success");
}
