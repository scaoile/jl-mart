<?php

session_start();

include("../classes/database-connect.php");
include("../classes/order-ctrl.php");
include("../classes/imagehandler-ctrl.php");

$orderCtrl = new OrderCtrl();

if (isset($_POST['submit']) && isset($_FILES['fileToUpload']['name'])) {

    $image = imageHandler($_FILES['fileToUpload'], "../views/cart.php");

    $productIds = $_POST['product_id'];
    $prices = $_POST['prices'];
    $quantities = $_POST['quantities'];

    $products = [];

    for ($index = 0; $index < count($productIds); $index++) {
        $products[] = [
            'product_id' => $productIds[$index],
            'price' => $prices[$index],
            'quantity' => $quantities[$index]
        ];
    }

    $orderCtrl->addOrder($_SESSION['userid'], $_POST['total'], $_POST['ship_address'], $image['newName'], $products);

    header("location: ../views/cart.php?message=Order Placed Successfully");
} else {
    header("location: ../views/cart.php?message=Please Upload Proof of Payment");
    exit();
}
