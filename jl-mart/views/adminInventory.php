<?php
session_start();

//if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
//    header("location: ../login.php");
//    exit();
//}

include("../classes/database-connect.php");
include("../classes/inventory-ctrl.php");

$inventory = new InventoryCtrl();

if (isset($_GET["category_id"]) && $_GET["category_id"] != 'all') {
    $products = $inventory->getProductsByCategory($_GET["category_id"]);
} else {
    $products = $inventory->getProducts();
}
$categories = $inventory->getCategories();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminInventory.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <title>Inventory</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav-admin.php'; ?>

        <div class="topper">
            <div class="left">
                <img src="images/inventory-icon.svg">
                <h1>Inventory Management</h1>
            </div>

            <div class="right">
                <form action="" method="get">
                    <button type="button" class="add" onclick="openPopup('category')">Add Category +</button>
                    <select id="categorySelect" name="category_id" onchange="this.form.submit()">
                        <?php
                        if ($_GET['category_id'] != 'all') {
                            foreach ($categories as $category) {
                                $selected = (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'selected' : '';

                                echo "<option value='{$category['id']}' $selected>{$category['category_name']}</option>";
                            }
                            echo "<option value='all'>All</option>";
                        } else {
                            echo "<option value='all' selected>All</option>";
                            foreach ($categories as $category) {

                                $selected = (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'selected' : '';

                                echo "<option value='{$category['id']}' $selected>{$category['category_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <button type="button" class="add" onclick="openPopup('add')">Add Product +</button>

                </form>
            </div>
        </div>

        <div class="table">
        </div>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Operation</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Updated At</th>
                </tr>
            </thead>

            <?php

            foreach ($products as $product) {
                echo "
                        <tbody>
                            <tr>
                                <td class='action-icons'>
                                    <a href='../views/adminInventory-edit.php?id=$product[id]'>
                                        <img src='images/edit-inventory-icon.svg' alt='Edit Icon'>
                                    </a>
                                    <a href='../includes/delete_product.php?id=$product[id]'>
                                        <img src='images/delete-inventory-icon.svg' alt='Edit Icon'>
                                    </a>
                                </td>
                                <td class='name-with-icon'>
                                    <img class='media' src='images/$product[image]'>
                                </td>
                                <td>
                                    $product[name]
                                </td>
                                <td>
                                    $product[price]
                                </td>
                                <td>
                                    $product[category_name]
                                </td>
                                <td>
                                    $product[inventory]
                                </td>
                                <td>
                                    $product[updated_at]
                                </td>
                            </tr>
                        </tbody>
                    ";
            }
            ?>
        </table>

    </div>

    <div id="popup" class="popup" style="display:none;">
        <div id="popup-content" class="popup-content">
            <div id="edit-content">
                <h2>Edit Products</h2>
                <form>
                    <label for="name">Product Name:</label><br>
                    <input type="text" id="name" name="name" placeholder="Enter product name"><br>

                    <label for="price">Price:</label><br>
                    <input type="number" id="price" name="price" placeholder="Enter price"><br>

                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" placeholder="Enter product description"></textarea><br>

                    <label for="stock">Enter Stock:</label><br>
                    <input type="number" id="stock" name="stock" placeholder="Enter stock quantity"><br>

                    <label for="image" class="custom-file-upload">Choose File</label>
                    <input type="file" id="product_image" name="image" style="display: none;">

                    <button type=" submit" class="submit-edit">Edit Product</button>

                </form>
            </div>
            <div id="delete-content">
                <h2>Delete Item</h2>
                <p>Are you sure you want to delete this item?</p>
                <button type="button" onclick="confirmDelete()">Yes</button>
                <button type="button" onclick="closePopup()">No</button>
            </div>
            <div id="add-content">
                <h2>Add Product</h2>
                <form action='../includes/add_product.php' method='post' enctype='multipart/form-data'>
                    <label for="product_name">Product Name:</label><br>
                    <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required><br>

                    <label for="product_price">Price:</label><br>
                    <input type="number" id="product_price" name="product_price" placeholder="Enter price" required><br>

                    <label for="product_description">Description:</label><br>
                    <textarea id="product_description" name="product_description" placeholder="Enter product description" required></textarea><br>

                    <label for="product_quantity">Enter Stock:</label><br>
                    <input type="number" id="product_quantity" name="product_quantity" placeholder="Enter stock quantity" required><br>

                    <label for="product_category">Product Category:</label>
                    <select name="product_category">
                        <?php
                        $categories = $inventory->getCategories();
                        foreach ($categories as $category) {
                            echo '<option value="' . $category['id'] . '">' . $category['category_name'] . '</option>';
                        }
                        ?>
                    </select><br><br>

                    <label for="image" class="custom-file-upload">Choose File</label>
                    <input type="file" id="image" name="image" style="display: none;">

                    <button type="submit" name="submit" class="submit-edit">Add Product</button>

                </form>

            </div>

            <div id="category-content">
                <h2>Add Category</h2>
                <form action='../includes/add_category.inc.php' method='post' enctype='multipart/form-data'>
                    <label for="category_name">Category Name:</label><br>
                    <input type="text" id="product_name" name="category_name" placeholder="Enter category name" required><br>

                    <button type="submit" name="submit" class="submit-edit">Add Category</button>

                </form>

            </div>
        </div>
    </div>

</body>

<script>
    function openPopup(action) {
        document.getElementById('popup').style.display = 'flex';
        ['edit', 'delete', 'add', 'category'].forEach(id => {
            document.getElementById(id + '-content').style.display = (id === action) ? 'block' : 'none';
        });
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    function confirmDelete() {
        alert("Item deleted!");
        closePopup();
    }

    function updateFileName() {
        var input = document.getElementById('image');
        document.getElementById('file-name').textContent = input.files[0] ? input.files[0].name : 'No file chosen';
    }

    // Close popup when clicking outside the element
    window.onclick = function(event) {
        var popup = document.getElementById('popup');
        if (event.target == popup) {
            closePopup();
        }
    }
</script>

</html>