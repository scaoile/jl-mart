<?php
session_start();

include("../classes/database-connect.php");
include("../classes/account-ctrl.php");

$account = new AccountCtrl();

if (isset($_SESSION['userid'])) {
    $user = $account->getInfo($_SESSION['userid']);
} else {
    header("location: ../views/userLogin.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/accountSetting.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Account Settings</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav.php'; ?>

        <div class="banner">
            <img src="images/acc-setting-logo.svg">
            <h1>Account Settings </h1>
        </div>

        <div class="edit-profile">
            <button class="edit"> Edit Profile </button>
            <h2><a href="#personal-address">Personal Address</a></h2>
            <h2><a href="#contact-number">Contact Number</a></h2>
        </div>

        <div class="setting-form">
            <div class="left">
                <img src="images/acc-icon-setting.svg">
            </div>

            <div class="right">
                <form method="POST" action="../includes/account_inc.php">
                    <div class="first-row">
                        <div>
                            <label for="username">User Name:</label><br>
                            <input type="text" id="username" name="name" value="<?php echo $user['name']; ?>" required><br><br>
                        </div>
                        <div>
                            <label for="password">New Password:</label><br>
                            <input type="password" id="password" name="password"><br><br>
                            <input type="hidden" name="previous" value="<?php echo $user['password']; ?>">
                        </div>
                    </div>

                    <div class="second-row">
                        <label for="email">Email Address:</label><br>
                        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
                    </div>

                    <h2 id="personal-address" class="title-form"> Shipping Addresses </h2>

                    <div class="first-row">
                        <div>
                            <label for="country">Country :</label><br>
                            <input type="text" id="country" name="country" value="<?php echo $user['country']; ?>" required><br><br>
                        </div>
                        <div>
                            <label for="city">City:</label><br>
                            <input type="text" id="city" name="city" value="<?php echo $user['city']; ?>" required><br><br>
                        </div>
                    </div>

                    <div class="first-row">
                        <div>
                            <label for="zipcode">Zip Code: </label><br>
                            <input type="number" id="zipcode" name="zipcode" value="<?php echo $user['postal_code']; ?>" required><br><br>
                        </div>
                        <div>
                            <label for="landmark">Landmark: </label><br>
                            <input type="text" id="landmark" name="landmark" value="<?php echo $user['landmark']; ?>" required><br><br>
                        </div>
                    </div>

                    <div class="second-row">
                        <label for="address">Complete Address 1: </label><br>
                        <input type="text" id="address" name="address_line1" value="<?php echo $user['address_line1']; ?>" required><br><br>
                    </div>

                    <div class="second-row">
                        <label for="address">Complete Address 2 (Optional): </label><br>
                        <input type="text" id="address" name="address_line2" value="<?php echo $user['address_line2']; ?>"><br><br>
                    </div>

                    <div class="second-row">
                        <label for="address">Complete Address 3 (Optional): </label><br>
                        <input type="text" id="address" name="address_line3" value="<?php echo $user['address_line3']; ?>"><br><br>
                    </div>

                    <h2 id="contact-number" class="title-form"> Contact Number </h2>

                    <div class="second-row">
                        <label for="contact">Contact Number: </label><br>
                        <input type="number" id="contact" name="phone_number" value="<?php echo $user['phone_number']; ?>" required maxlength="11" minlength="11" oninput="this.value=this.value.slice(0,this.maxLength)"><br><br>
                    </div>

                    <button type="submit" name="submit" class="submit">Save Changes</button>
                </form>
            </div>
        </div>

    </div>
    <?php include 'footer.php'; ?>


</body>

</html>