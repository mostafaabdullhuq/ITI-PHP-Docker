<?php

session_start();

// if user already logged in, redirect to home page
if (isset($_SESSION["user"])) {
    header("Location: ./home.php");
}
// if user not logged in, destroy the session and clear the PHPSESSID cookie
else {
    session_destroy();
    setcookie("PHPSESSID", "", time() - 1000);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="./style.css" />
    <script defer src="./script.js"></script>
    <title>Home</title>
</head>

<body>
    <div class="container auth-container">
        <form id="login" method="POST" class="active" action="login.php">
            <input type="hidden" name="formtype" value="0" />
            <input type="text" name="email" placeholder="Email Address" />
            <div class="password-switcher-container">
                <div class="password-switcher">
                    <i title="Show Password" class="fa-solid fa-eye"></i>
                </div>
                <input type="password" name="password" placeholder="Password" />
            </div>
            <input type="submit" name="submit" value="login" />
            <p>Don't have an account? <a href="#" data-form="signup">Create New</a></p>
        </form>
        <form id="signup" method="POST" action="signup.php">
            <input type="hidden" name="formtype" value="1" />
            <input type="text" name="name" placeholder="Full Name" />
            <input type="text" name="email" placeholder="Email Address" />
            <div class="password-switcher-container">
                <div class="password-switcher">
                    <i title="Show Password" class="fa-solid fa-eye"></i>
                </div>
                <input id="pass" type="password" name="password" placeholder="Password" />
            </div>
            <label for="pass"> Password must be 8-20 characters and contain at least one uppercase letter, one lowercase
                letter, one number and one special character. </label>
            <div class="password-switcher-container">
                <input type="password" name="confirmpassword" placeholder="Confirm Password" />
            </div>
            <input type="submit" name="submit" value="signup" />
            <p>Already have an account? <a href="#" data-form="login">Login</a></p>
        </form>
    </div>
</body>

</html>