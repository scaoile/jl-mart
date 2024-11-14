<link rel="stylesheet" href="css/nav.css ">

<footer class="footer">
    <div class="logo-footer">
        <div class="left-side-footer">
            <div class="image-footer">
                <img src="images/main-logo.svg" alt="Logo">
            </div>
            <h3>JL Mart Asian Food</h3>
        </div>

        <div class="footer-nav">
            <a href="index.php">
                <h2>HOMEPAGE</h2>
            </a>
            <a href="product.php">
                <h2>PRODUCTS</h2>
            </a>
            <a href="cart.php">
                <h2>CART</h2>
            </a>
            <?php
            if (isset($_SESSION['role'])) {
                echo "
                    <a href='../includes/logout.inc.php'>
                        <h2>LOGOUT</h2>
                    </a>
            ";
            }
            ?>
        </div>
    </div>
    <p> Contact us: support@jlmart.com | Privacy Policy | Terms & Conditions</p>
    <hr>
    <h4> 2024 JL Mart. All Rights Reserved.</h4>
</footer>