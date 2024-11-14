<?php
session_start();

include("../classes/database-connect.php");
include("../classes/inventory-ctrl.php");

$inventory = new InventoryCtrl();

if (isset($_POST['search'])) {
    $products = $inventory->searchProducts($_POST['search']);
} else {
    if (isset($_GET["category_id"]) && $_GET["category_id"] != 'all') {
        $products = $inventory->getProductsByCategoryAndTotalSold($_GET["category_id"]);
    } else {
        $products = $inventory->getProductsAndTotalSold();
    }
}
$categories = $inventory->getCategories();



?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/products.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Products</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav.php'; ?>

        <div class="banner">
            <div class="banner1">
                <p>.</p>
            </div>

            <div class="banner2">
                <p>.</p>
            </div>
        </div>

    </div>

    <div class="products-container">
        <div class="topper">
            <h1> Total Products: <span>20 Products</span> </h1>
            <img src="images/cart-products.svg" alt="line">
        </div>

        <div class="suggestions">
            <div class="suggestions-right">
                <form action="" method="get">
                    <select id="dropdown" name="category_id" onchange="this.form.submit()">
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
                </form>
            </div>

            <div class="suggestions-left">
                <form method='post' action="" class="wrapper">
                    <input type="text" id="search" name="search" placeholder="Find Something Yummy">
                    <button type="submit" name="submit" id="searchBtn">Search</button>
                </form>
            </div>
        </div>

        <div class="product-container">

            <?php

            foreach ($products as $product) {
                echo "
                    
                    <div class='product-card'>
                        <div class='img-product'>
                            <img src='images/{$product['product_image']}'>
                        </div>
                        <div class='info-product'>
                            <div class='row1'>
                                <h1>Php {$product['product_price']}</h1>
                                <h3>| Sold {$product['total_quantity_sold']}</h3>
                            </div>
                            <div class='row2'>
                                <h2>{$product['product_name']}</h2>
                            </div>
                            <div class='row3'>
                                <div class='inner-col'><a href='products-indiv.php?product_id={$product['product_id']}' class='btn'>View Product</a></div>
                                ";
                if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
                    echo "<form method='post' action='userLogin.php?message=Please log in to add to cart'>";
                } else {
                    echo "<form method='post' action='../includes/add_to_cart.inc.php?id={$product['product_id']}'>";
                }

                echo "
                                    <input type='hidden' name='quantity' id='quantity' value='1'>
                                    <button type='submit' name='submit' class='btn2'><img src='images/cart-card.svg' alt='Add to Cart'></button>
                                </form> 
                            </div>
                        </div>
                    </div>";
            }

            ?>

        </div>

    </div>



    <?php include 'footer.php'; ?>

    <script>
        document.getElementById('searchBtn').addEventListener('click', function() {
            var query = document.getElementById('search').value;
        });
    </script>
</body>

</html>