<?php
session_start();

include_once("./db_conf.php");




// if form is submitted and email and password are given
if (isset($_POST['submit']) && isset($_POST["email"]) && isset($_POST["password"])) {



    // get the email and password given
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check if any value is empty
    if (!empty($email) && !empty($password)) {

        // if database connected successfully
        if (!$userAuth->connectionError()) {

            // login to account
            $loginStatus = $userAuth->login($email, $password);

            // if account found and no error
            if ($loginStatus && $loginStatus !== 3 && $loginStatus !== 0) {

                // set the session variable to user details
                $_SESSION['user'] = $loginStatus;

                // redirect to home page
                header('Location: ./home.php');
            }

            // if invalid email or password
            else if ($loginStatus === 3) {

                // redirect to index page with error code 3
                header('Location: ./index.php?errorcode=3&formtype=0');
            }
            // if there's an error with the database search
            else {

                // redirect to index page with error code 0
                header('Location: ./index.php?errorcode=0&formtype=0');
            }
        }
        // if connection error with database
        else {
            // redirect to index page with error code 0
            header('Location: ./index.php?errorcode=0&formtype=0');
        }
    }
    // if email or password is empty
    else {
        header('Location: ./index.php?errorcode=1&formtype=0');
    }
}
// if get request
else {
    header('Location: ./index.php');
}