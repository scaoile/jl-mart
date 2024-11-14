<link rel="stylesheet" href="css/nav.css ">

<div class="nav">
    <div class="logo">
        <div class="image-l">
            <img src="images/main-logo.svg" alt="Logo">
        </div>
        <div class="logo-text">
            <h2>JLMart</h2>
            <h3>Asian Foods</h3>
        </div>
    </div>
    <div class="left-nav">
        <img src="images/home-icon.svg"> <a href="homepage.php">Homepage</a>
        <img src="images/products-icon.svg"><a href="products.php">Products</a>
    </div>
    <?php

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
        echo "
            <div class='right-nav'>
                <img src='images/account-icon.svg'><a href='signup.php'>Sign Up</a>
                <div class='cart'><img src='images/cart-icon.svg'><a href='signup.php?message=Sign up and Log in to access Cart & Orders'><span class='cart-text'>Cart & Orders</span></a></div>
            </div>
        ";
    } else {
        echo "
            <div class='right-nav'>
                <img src='images/account-icon.svg'><a href='accountSetting.php'>Account</a>
                <div class='cart'><img src='images/cart-icon.svg'><a href='cart.php'><span class='cart-text'>Cart & Orders</span></a></div>
            </div>
        ";
    }
    ?>

</div>

<script src="js/message.js"></script>