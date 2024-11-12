<?php

session_start();

include "../classes/database-connect.php";
include "../classes/inventory-ctrl.php";
include "../classes/imagehandler-ctrl.php";

$inventory = new InventoryCtrl();

$id = $_GET["product_id"];

$product = $inventory->getProductById($id);

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/products-indiv.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Products</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav.php'; ?>

        <div class="product-container">
            <div class="left">
                <div class="product-image">
                    <img src="images/<?php echo $product['image'] ?>">
                </div>
            </div>
            <div class="right">
                <h1><?php echo $product['name'] ?></h1>

                <h3>BY <span>JL MART ASIAN FOOD</span></h3>
                <h2>PHP <?php echo $product['price'] ?> </h2>
                <p><?php echo $product['description'] ?></p>

                <form method="post" action="../includes/add_to_cart.inc.php?id=<?php echo $id ?>" class="add-to-cart">
                    <div class="quantity-wrapper">
                        <button type='button' class="minus-btn" onclick="updateQuantity(-1)">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1">
                        <button type='button' class="plus-btn" onclick="updateQuantity(1)">+</button>
                    </div>
                    <button type="submit" name="submit" class="add">Add to Cart</button>
                </form>
            </div>
        </div>

    </div>
    <?php include 'footer.php'; ?>

    <script>
        function updateQuantity(change) {
            var quantityInput = document.getElementById('quantity');
            var currentQuantity = parseInt(quantityInput.value);
            var newQuantity = currentQuantity + change;
            if (newQuantity >= 1) {
                quantityInput.value = newQuantity;
            }
        }
    </script>
</body>

</html>