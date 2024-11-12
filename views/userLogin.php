<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/userLoginStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="main-container">
        <div class="left">
            <div class="top-part">
                <img src="images/logo.svg" class="logo">
                <h2> JL Mart Asian Foods</h2>
            </div>
            <h1 class="title-message"> Hey There! </h1>
            <h3 class="message"> Welcome Back <br> You are just one step away to shopping </h3>
            <p class="question"> Don't have an account?</p> <br>
            <div class="button-container">
                <button onclick="window.location.href='signup.php'" class="sign-up">Sign Up</button>
            </div>
        </div>

        <div class="right">
            <h1 class=sign-in> SIGN IN </h1>
            <p class="sign-in-message">Please log in to access your account</p>

            <form method="POST" action="../includes/login.inc.php">
                <label for="username">Email:</label><br>
                <input type="text" id="username" name="email" placeholder="Enter your email here" required><br><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit" name="submit">Sign In</button>
            </form>

            <p class="note">Prices and availability are subject to change without notice. We strive for accuracy, but errors may occur.</p>
        </div>
    </div>
</body>

</html>