<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("location: ../adminLogin.php");
    exit();
}

include "../classes/database-connect.php";
include "../classes/inventory-ctrl.php";
include "../classes/imagehandler-ctrl.php";

$inventory = new InventoryCtrl();

$id = $_GET["id"];

$product = $inventory->getProductById($id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminInventory-edit.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <title>Inventory</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav-admin.php'; ?>

        <div id="edit-content">
            <div class="topper">
                <h2>Edit Products</h2>
                <button id="back">
                    < Turn back </button>
            </div>
            <form action="../includes/edit_product.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div>
                        <label for="name">Product Name:</label><br>
                        <input type="text" id="name" name="product_name" value="<?php echo $product['name'] ?>">
                    </div>

                    <div>
                        <label for="price">Price:</label><br>
                        <input type="number" id="price" name="product_price" value="<?php echo $product['price'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label for="description">Description:</label><br>
                        <textarea id="description" name="product_description"><?php echo $product['description'] ?></textarea>
                    </div>
                    <div>
                        <label for="stock">Enter Stock:</label><br>
                        <input type="number" id="stock" name="product_quantity" value="<?php echo $product['inventory'] ?>">
                    </div>
                </div>

                <div class="row">


                    <div class="section">
                        <label for="categorySelect">Product Category:</label><br><br>
                        <select id="categorySelect" name="product_category">
                            <?php
                            $categories = $inventory->getCategories();
                            foreach ($categories as $category) {
                                $selected = ($product['category_id'] == $category['id']) ? 'selected' : '';
                                echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="section">
                        <label for="image" class="custom-file-upload">Choose File</label>
                        <input type="file" id="image" name="image" style="display: none;" onchange="updateFileName()">
                        <input type="hidden" name="Img" value="<?php echo $product['image']; ?>">
                        <br><br>
                        <img class="media" src='../views/images/<?php echo $product['image']; ?>'>
                    </div>
                </div>

                <div class="row">


                    <div>
                        <button type="submit" class="submit-edit">Edit Product</button>
                    </div>
                </div>
        </div>

    </div>

</body>

</html>