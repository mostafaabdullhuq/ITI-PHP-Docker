<?php
session_start();


// if user submit logout form, destroy the session, clear the PHPSESSID cookie and redirect him to the index page
if (isset($_POST["submit"]) && $_POST["submit"] === "logout") {
    session_destroy();
    setcookie("PHPSESSID", "", time() - 1000);
    header('Location: ./index.php?formtype=0');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="welcome-container">
            <p class="welcome">
                <?php
                // if user logged in
                if (isset($_SESSION['user'])) {
                    // print welcome message
                    echo 'Welcome, ' . '<span>' . $_SESSION['user']['full_name'] . '</span>';
                }
                // if no user found in session, redirect to index page
                else {
                    session_destroy();
                    setcookie("PHPSESSID", "", time() - 10);
                    header('Location: ./index.php?formtype=0');
                }
                ?>
            </p>
            <form method="POST" action="<?php $_SERVER["PHP_SELF"] ?>">
                <input type="submit" name="submit" value="logout">
            </form>
        </div>
    </div>
</body>

</html>