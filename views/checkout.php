<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("location: ../login.php");
    exit();
}

if (!isset($_POST['select'])) {
    header("location: ../views/cart.php?message=Choose atleast 1 product to checkout");
    exit();
}

$selectedPrices = [];
$selectedQuantities = [];

if (isset($_POST['submit'])) {
    $productIds = $_POST['product_id'];
    $selectedItems = $_POST['select'];
    $prices = $_POST['price'];
    $quantities = $_POST['quantity'];

    foreach ($selectedItems as $selected) {
        $index = array_search($selected, $productIds);
        $selectedPrices[] = $prices[$index];
        $selectedQuantities[] = $quantities[$index];
    }


    // Now you can use $selectedPrices and $selectedQuantities as needed
}
$products = [];

foreach ($selectedItems as $selected) {
    $index = array_search($selected, $productIds);
    $products[] = [
        'product_id' => $selected,
        'price' => $prices[$index],
        'quantity' => $quantities[$index]
    ];
}

$subTotal = 0;

foreach ($selectedPrices as $index => $price) {
    $subTotal += $price * $selectedQuantities[$index];
}

$total = $subTotal + 50;

include '../classes/database-connect.php';
include '../classes/account-ctrl.php';

$accountCtrl = new AccountCtrl();

$addresses = $accountCtrl->getAddresses($_SESSION['userid']);


?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/checkout.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Checkout</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav.php'; ?>

        <h2 class="title"> Shipping Address </h2>
        <form method="POST" action="../includes/checkout.inc.php" enctype="multipart/form-data">
            <input type="hidden" name='total' value="<?php echo $total ?>">

            <?php
            foreach ($products as $product) {
                echo "
                    <input type='hidden' name='product_id[]' value='{$product['product_id']}'>
                    <input type='hidden' name='prices[]' value='{$product['price']}'>
                    <input type='hidden' name='quantities[]' value='{$product['quantity']}'>
                    ";
            }
            ?>



            <select name="ship_address" id="dropdown">
                <?php
                foreach ($addresses as $address) {
                    echo "
                        <option value='{$address['address_line1']}'>{$address['address_line1']}</option>
                        <option value='{$address['address_line2']}'>{$address['address_line2']}</option>
                        <option value='{$address['address_line3']}'>{$address['address_line3']}</option>
                    ";
                }
                ?>
            </select>

            <h2 class="title"> Payment </h2>
            <div class="mode1">
                <div class="gcash-ins">
                    <div class="left">
                        <img class="gcash-logo" src="images/gcash-num.svg" alt="gcash-num">
                    </div>
                    <div class="right">
                        <h1>GCASH NUMBER: </h1>
                        <h2>Mico Andrado</h2>
                        <h3>+63 912 345 6789</h3>
                        <ol>
                            <li>Take a screenshot of the GCash receipt.</li>
                            <li>Click “Upload” and select the screenshot.</li>
                            <li>Confirm and upload.</li>
                            <li>Verify the receipt is clear.</li>
                            <li>Refer from the sample receipt</li>
                        </ol>
                        <label for="fileToUpload" class="custom-file-input" id="fileLabel">Upload Screenshot</label>
                        <input type="file" name="fileToUpload" id="fileToUpload" onchange="updateFileName()">
                    </div>
                </div>
            </div>


            <div class="summary">
                <h2 class="order-title">Order Summary</h2>
                <hr>
                <div class="summary-row">
                    <div class="summary-item">
                        <p>Subtotal:</p>
                        <span>PHP<?php echo $subTotal ?></span>
                    </div>
                    <div class="summary-item">
                        <p>Shipping:</p>
                        <span>PHP50.00</span>
                    </div>
                </div>
                <hr>
                <div class="summary-total">
                    <p>Total:</p>
                    <span>PHP<?php echo $total ?></span>
                </div>
            </div>
            <div class="checkout">
                <button name='submit' type="submit" class="checkout-btn">Checkout</button>
            </div>
        </form>

        <div class="popup-overlay"></div>
        <div class="popup">
            <h2>Rate and Review</h2>
            <h3> Put your ratings here </h3>
            <form method="POST" action="submitReview.php">
                <div class="rating-row">
                    <div class="satisfied">
                        <label for="satisfied" class="clickable-label">SATISFIED PRODUCT:</label>
                        <input type="radio" id="satisfied-product" name="rating" value="satisfied-product">
                    </div>
                    <div class="bad">
                        <label for="bad" class="clickable-label">BAD PRODUCT:</label>
                        <input type="radio" id="bad-product" name="rating" value="bad-product">
                    </div>
                </div>
                <div class="rating-row">
                    <div class="satisfied">
                        <label for="satisfied" class="clickable-label">SATISFIED SERVICE:</label>
                        <input type="radio" id="satisfied-service" name="rating" value="satisfied-service">
                    </div>
                    <div class="bad">
                        <label for="bad" class="clickable-label">BAD SERVICE:</label>
                        <input type="radio" id="bad-service" name="rating" value="bad-service">
                    </div>
                </div>
                <p>Put your review below:</p>
                <textarea id="review" name="review" placeholder="Enter your review here" rows="4" cols="50" required></textarea>
                <button type="submit" class="submit-review">POST</button>
            </form>
        </div>
    </div>

    </div>
    <?php include 'footer.php'; ?>

    <script>
        // document.querySelector('form').addEventListener('submit', function(event) {
        //     event.preventDefault();
        //     document.querySelector('.popup-overlay').style.display = 'block';
        //     document.querySelector('.popup').style.display = 'block';
        // });

        // function closePopup() {
        //     document.querySelector('.popup-overlay').style.display = 'none';
        //     document.querySelector('.popup').style.display = 'none';
        //     document.querySelector('form').submit();
        // }

        function updateFileName() {
            var fileInput = document.getElementById('fileToUpload');
            var fileLabel = document.getElementById('fileLabel');
            fileLabel.textContent = fileInput.files[0].name;
        }
    </script>

</body>

</html>