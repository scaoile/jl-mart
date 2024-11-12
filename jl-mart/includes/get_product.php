<?php

include "database-connect.php";
include "inventory-ctrl.php";

$inventory = new InventoryCtrl();

if (isset($_GET["id"])) {
    $product = $inventory->getProductById($_GET["id"]);
    echo json_encode($product);
}
