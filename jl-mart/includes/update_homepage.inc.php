<?php

include '../classes/database-connect.php';
include '../classes/homepage-ctrl.php';
include '../classes/imagehandler-ctrl.php';

$homepage = new HomepageCtrl();

if ($_GET['action'] == 'updateMain') {
    $title = $_POST['sale-title'];
    $description = $_POST['description'];
    $image = $_FILES['banner-img'];

    $imageName = imageHandler($image, "../views/adminDashboard.php");

    $homepage->updateMain($title, $description, $imageName['newName']);
    header("location: ../views/adminDashboard.php");
    exit();
} elseif ($_GET['action'] == 'updateDiscount') {
    $discount = $_POST['discount'];
    $homepage->updateDiscount($discount);
    header("location: ../views/adminDashboard.php");
    exit();
} elseif ($_GET['action'] == 'updateLeftCard') {
    $title = $_POST['category1'];
    $image = $_FILES['category-image'];

    $imageName = imageHandler($image, "../views/adminDashboard.php");

    $homepage->updateLeftCard($title, $imageName['newName']);
    header("location: ../views/adminDashboard.php");
    exit();
} elseif ($_GET['action'] == 'updateMiddleCard') {
    $title = $_POST['category2'];
    $image = $_FILES['category-image2'];

    $imageName = imageHandler($image, "../views/adminDashboard.php");

    $homepage->updateMiddleCard($title, $imageName['newName']);
    header("location: ../views/adminDashboard.php");
    exit();
} elseif ($_GET['action'] == 'updateRightCard') {
    $title = $_POST['category3'];
    $image = $_FILES['category-image3'];

    $imageName = imageHandler($image, "../views/adminDashboard.php");

    $homepage->updateRightCard($title, $imageName['newName']);
    header("location: ../views/adminDashboard.php");
    exit();
}
