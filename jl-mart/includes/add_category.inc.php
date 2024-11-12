<?php

include '../classes/database-connect.php';
include '../classes/inventory-ctrl.php';

$inventory = new InventoryCtrl();

if (isset($_POST['category_name'])) {
    $inventory->addCategory($_POST['category_name']);
}
