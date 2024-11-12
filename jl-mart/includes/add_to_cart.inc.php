<?php

session_start();

include '../classes/database-connect.php';
include '../classes/cart-ctrl.php';

$cartCtrl = new CartCtrl();

if (isset($_POST['submit'])) {
    $customer_id = $_SESSION['userid'];
    $product_id = $_GET['id'];
    $quantity = $_POST['quantity'];

    $cartCtrl->createCart($customer_id);
    $cartCtrl->addProductToCart($customer_id, $product_id, $quantity);
    header("location: ../views/products.php?message=Item Added To Cart");
    exit();
} else {
    header("location: ../views/products.php");
    exit();
}
