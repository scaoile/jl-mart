<?php
include "../classes/database-connect.php";
include "../classes/inventory-ctrl.php";
include "../classes/imagehandler-ctrl.php";

$inventory = new InventoryCtrl();

if (isset($_POST["product_name"])) {
    $image = $_FILES["image"];
    $product_name = $_POST["product_name"];
    $product_description = $_POST["product_description"];
    $product_price = $_POST["product_price"];
    $category = $_POST["product_category"];
    $product_quantity = $_POST["product_quantity"];

    $imageName = imageHandler($image, "../views/inventory.php");

    $inventory->addProduct($imageName['newName'], $product_name, $product_description, $product_price, $category, $product_quantity);

    header("location: ../views/adminInventory.php?error=none");
}
