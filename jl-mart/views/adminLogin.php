<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminLoginStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Admin Login</title>
</head>

<body>
    <div class="main-container">
        <div class="left">
            <div class="top-part">
                <img src="images/logo.svg" class="logo">
                <h2>JL Mart Asian Foods</h2>
            </div>
            <h1 class="title-message">Welcome Back!</h1>
            <h3 class="message">Hello Admin! Manage your platform settings and users here.</h3>
        </div>

        <div class="right">
            <h1 class="sign-in">Sign in to Account</h1>
            <p class="sign-in-message">Please log in to access your <span><b>account</b></span></p>
            <form method="POST" action="../includes/login.inc.php?role=manager">
                <label for="email">Email:</label><br>
                <input type="text" id="username" name="email" placeholder="Enter your email here" required><br><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit" name="submit">Sign In</button>
            </form>
            <p class="note">Admin sign-up to manage the platform and user settings.</p>
        </div>
    </div>

</body>

</html>