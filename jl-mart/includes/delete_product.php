<?php

include "../classes/database-connect.php";
include "../classes/inventory-ctrl.php";

$inventory = new InventoryCtrl();

$id = $_GET["id"];

$inventory->deleteProduct($id);

header("location: ../views/inventory.php?message=Delete Successfully");
