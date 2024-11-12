<?php

session_start();

include("../classes/database-connect.php");
include("../classes/order-ctrl.php");

$orderCtrl = new OrderCtrl();

$orders = $orderCtrl->getAllOrders();

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $status = $_POST['status'];

    $orderCtrl->updateOrderStatus($orderId, $status);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminDashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Admin Dash</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav-admin.php'; ?>

        <h1 class="title">
            Edit Homepage
        </h1>
        <div class="banner">
            <div class="left">
                <form method="post" action="../includes/update_homepage.inc.php?action=updateMain" enctype="multipart/form-data">
                    <div class="banner-text">
                        <input type="text" id="sale-title" name="sale-title" value="Enter Title Here" required>
                        <input type="text" id="description" name="description" value="Enter Description Here" required>
                        <button type="submit" class="banner-btn">Save and Upload </button>
                    </div>
                    <div class="banner-img">
                        <input type="file" id="banner-img" name="banner-img" required>
                    </div>
                </form>
            </div>

            <div class="right">
                <div class="top-right">
                    <form method="post" action="../includes/update_homepage.inc.php?action=updateDiscount">
                        <label for="discount">Enjoy up to:</label>
                        <input type="number" id="discount" name="discount" value="30" min="0" max="100" required>
                        <span>% OFF Product Discount</span>
                        <button type="submit" class="save">Save</button>
                    </form>
                </div>
                <div class="down-right">
                    <div class="down-right-text">
                        <p>
                            We'd love to hear your thoughts! <a> Click me to Rate!</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="category">
            <h1> Explore popular products </h1>
            <img src="images/category-homepage.svg">
        </div>

        <div class="category-container">
            <div class="category-card">
                <form method="post" action="../includes/update_homepage.inc.php?action=updateLeftCard" enctype="multipart/form-data">
                    <label for="category-image" class="upload-label">Upload Image</label>
                    <input type="file" id="category-image" name="category-image" required style="display: none;">
                    <input type="text" id="category1" name="category1" value="Enter Title Here" required>
                    <button type="submit" class="upload">Save</button>
                </form>
            </div>

            <div class="category-card2">
                <form method="post" action="../includes/update_homepage.inc.php?action=updateMiddleCard" enctype="multipart/form-data">
                    <label for="category-image2" class="upload-label">Upload Image</label>
                    <input type="file" id="category-image2" name="category-image2" required style="display: none;">
                    <input type="text" id="category2" name="category2" value="Enter Title Here" required>
                    <button type="submit" class="upload">Save</button>
                </form>
            </div>

            <div class="category-card">
                <form method="post" action="../includes/update_homepage.inc.php?action=updateRightCard" enctype="multipart/form-data">
                    <label for="category-image3" class="upload-label">Upload Image</label>
                    <input type="file" id="category-image3" name="category-image3" required style="display: none;">
                    <input type="text" id="category3" name="category3" value="Enter Title Here" required>
                    <button type="submit" class="upload">Save</button>
                </form>
            </div>
        </div>

        <div class="orders">
            <h1 class="title">
                Orders
            </h1>
        </div>

        <div class="card-container">

            <?php
            foreach ($orders as $order) {
                echo "
                <form class='card' method='post' action='adminDashboard.php?id={$order['order_id']}'>
                    <div class='card-header'>
                        <label for='status' class='status-label'>Status:</label>
                        <select id='status' name='status' class='status-select' onchange='this.form.submit()'>
                            <option value='1'" . ($order['status_name'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                            <option value='2'" . ($order['status_name'] == 'Processing' ? ' selected' : '') . ">Processing</option>
                            <option value='3'" . ($order['status_name'] == 'Shipped' ? ' selected' : '') . ">Shipped</option>
                            <option value='4'" . ($order['status_name'] == 'Delivered' ? ' selected' : '') . ">Delivered</option>
                            <option value='5'" . ($order['status_name'] == 'Cancelled' ? ' selected' : '') . ">Cancelled</option>
                        </select>
                    </div>
                    <div class='card-body'>
                        <p><strong>Customer Name:</strong> {$order['customer_name']}</p>
                        <p><strong>Email:</strong> {$order['customer_email']}</p>
                        <p><strong>Contact Number:</strong> {$order['customer_number']}</p>
                        <p><strong>Order Date:</strong> {$order['order_date']}</p>
                        <p><strong>Total Price:</strong> PHP {$order['total_price']}</p>
                        <p><strong>Items with Quantity:</strong></p>
                        <ul>";

                // Loop through the order items and display them
                $items = $orderCtrl->getOrderItems($order['order_id']);

                foreach ($items as $item) {
                    echo "<li>{$item['product_name']} - Quantity: {$item['quantity']}</li>";
                }

                echo "
                        </ul>
                        <p><strong>Status:</strong> {$order['status_name']}</p>
                        <p><strong>Shipping Address:</strong> {$order['shipping_address']}</p>
                    </div>
                    <div class='card-footer'>
                        <button type='button' class='proof-btn' data-proof='images/{$order['proof']}'>View Proof</button>
                    </div>
                </form>";
            }
            ?>
        </div>

    </div>

    <script>
        document.querySelectorAll('.upload-label').forEach(label => {
            const input = label.nextElementSibling;
            label.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                input.click();
            });
            input.addEventListener('change', () => {
                if (input.files.length > 0) {
                    let fileName = input.files[0].name;
                    if (fileName.length > 10) {
                        fileName = fileName.substring(0, 15) + '...';
                    }
                    label.textContent = fileName;
                }
            });
        });

        document.querySelectorAll('.proof-btn').forEach(button => {
            button.addEventListener('click', function() {
                const proofImage = this.dataset.proof;
                window.open(proofImage, '_blank');
            });
        });
    </script>
</body>

</html>