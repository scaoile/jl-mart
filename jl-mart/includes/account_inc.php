<?php
session_start();


if (isset($_POST['submit'])) {
    include("../classes/database-connect.php");
    include("../classes/account-ctrl.php");

    $name = $_POST['name'];
    $email = $_POST['email'];
    if (!isset($_POST['password'])) {
        $password = $_POST['previous'];
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    $country = $_POST['country'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $landmark = $_POST['landmark'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $address_line3 = $_POST['address_line3'];
    $phone_number = $_POST['phone_number'];

    $account = new AccountCtrl();

    $account->updateInfo($_SESSION['userid'], $name, $email, $password, $phone_number, $address_line1, $address_line2, $address_line3, $city, $landmark, $zipcode, $country);
    header("location: ../views/accountSetting.php?message=Update Successfully");
}
