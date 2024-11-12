<?php
session_start();

include "../classes/database-connect.php";
include "../classes/cart-ctrl.php";
include "../classes/order-ctrl.php";

$orderCtrl = new OrderCtrl();
$cartCtrl = new CartCtrl();

$customer_id = $_SESSION['userid'];

$cartCtrl->createCart($customer_id);
$cart_details = $cartCtrl->getCartDetails($customer_id);

$orders = $orderCtrl->getAllOrdersOfCustomer($customer_id);

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Products</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav.php'; ?>
        <div class="topper">
            <h1> My Cart </h1>
            <button onclick="window.location.href='products.php'" class="btn">
                < Continue Shopping</button>
        </div>

        <form action="checkout.php" method="post">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>PRODUCT</th>
                        <th>PRICE</th>
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cart_details as $cart_item) {
                        echo "
                        <tr>
                            <td>
                                <input type='checkbox' name='select[]' value='{$cart_item['product_id']}'>
                                <input type='hidden' name='product_id[]' value='{$cart_item['product_id']}'>
                            </td>
                            <td>
                                <div class='product'>
                                    <div class='left-product'>
                                        <img src='images/{$cart_item['image']}' alt='Samyang'>
                                    </div>
                                    <div class='right-product'>
                                        <h3>{$cart_item['name']}</h3>
                                        <p>{$cart_item['category']}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <b>PHP{$cart_item['price']}</b>
                                <input type='hidden' name='price[]' value='{$cart_item['price']}'>
                            </td>
                            <td class='addcart'>
                                <div class='quantity-wrapper'>
                                    <button class='minus-btn' type='button' onclick='updateQuantity(this, -1)'>-</button>
                                    <input type='number' name='quantity[]' class='quantity' value='{$cart_item['quantity']}' min='1' data-price='{$cart_item['price']}' oninput='updateRowTotal(this, {$cart_item['price']})' onchange='updateRowTotal(this, {$cart_item['price']})'>
                                    <button class='plus-btn' type='button' onclick='updateQuantity(this, 1)'>+</button>
                                </div>
                            </td>
                            <td><b class='row-total'>PHP" . number_format($cart_item['quantity'] * $cart_item['price'], 2) . "</b></td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
            <div class="checkout">
                <button type="submit" name="submit" class="checkout-btn">Proceed to Checkout</button>
            </div>
        </form>


        <div class="orders">
            <h1 class="title">
                Orders
            </h1>
        </div>

        <div class="card-container">
            <?php
            foreach ($orders as $order) {
                echo "
                <div class='card'>
                    <div class='card-header'>
                        <label for='status' class='status-label'>Status:</label>
                        {$order['status_name']}
                    </div>
                    <div class='card-body'>
                        <p><strong>Customer Name:</strong> {$order['customer_name']}</p>
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
                        <p><strong>Shipping Address:</strong> {$order['shipping_address']}</p>
                    </div>
                    <div class='card-footer'>
                        <button type='button' class='proof-btn' data-proof='images/{$order['proof']}'>View Proof</button>
                    </div>
                </div>";
            }
            ?>
        </div>


    </div>
    <?php include 'footer.php'; ?>

    <script>
        function updateQuantity(button, change) {
            var quantityInput = button.parentElement.querySelector('.quantity');
            var currentQuantity = parseInt(quantityInput.value);
            var newQuantity = currentQuantity + change;
            if (newQuantity >= 1) {
                quantityInput.value = newQuantity;
                updateRowTotal(quantityInput, parseFloat(quantityInput.getAttribute('data-price')));
            }
        }

        // Function to update the row total based on quantity and price
        function updateRowTotal(quantityInput, price) {
            const quantity = parseInt(quantityInput.value);
            const rowTotalElement = quantityInput.closest('tr').querySelector('.row-total');
            const rowTotal = quantity * price;

            rowTotalElement.innerText = `PHP${rowTotal.toFixed(2)}`;
        }

        document.querySelectorAll('.proof-btn').forEach(button => {
            button.addEventListener('click', function() {
                const proofImage = this.dataset.proof;
                window.open(proofImage, '_blank');
            });
        });
    </script>
</body>

</html>