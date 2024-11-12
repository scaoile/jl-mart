<?php
include "../classes/database-connect.php";
include "../classes/inventory-ctrl.php";
include "../classes/imagehandler-ctrl.php";

$inventory = new InventoryCtrl();

$id = $_GET["id"];

if (isset($_POST["product_name"])) {

    if (!empty($_FILES['image']['name'])) {
        $Image = $_FILES["image"];

        $imageName = imageHandler($Image, "../views/adminInventory.php");
    } else {
        $imageName['newName'] = $_POST['Img'];
    }

    $product_name = $_POST["product_name"];
    $product_description = $_POST["product_description"];
    $product_price = $_POST["product_price"];
    $category = $_POST["product_category"];
    $product_quantity = $_POST["product_quantity"];

    $inventory->editProduct($id, $imageName['newName'], $product_name, $product_description, $product_price, $category, $product_quantity);
}

header("location: ../views/adminInventory.php?error=none");
