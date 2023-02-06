<?php
session_start();

include_once("./db_conf.php");




// if form is submitted and name, email, password and confirm password are given
if (isset($_POST['submit']) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST['name']) && isset($_POST['confirmpassword'])) {

    // get the email and password given
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passConfirm = $_POST['confirmpassword'];

    // check if any value is empty
    if (!empty($name) && !empty($email) && !empty($password) && !empty($passConfirm)) {

        // if database connected successfully
        if (!$userAuth->connectionError()) {

            // if name doesn't meet the requirements
            if (!preg_match('/^([a-zA-Z]{3,10}(\s[a-zA-Z]{3,10}){0,2})$/', $name)) {
                header('Location: ./index.php?errorcode=6&formtype=1');
                exit();
            }

            // if email doesn't meet the requirements
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: ./index.php?errorcode=4&formtype=1');
                exit();
            }


            /*
                Password must be 8-20 characters and contain at least one uppercase alphabet, digit and special
                character [ !, #, $, ^, * ]
            */
            if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$/', $password)) {
                header('Location: ./index.php?errorcode=5&formtype=1');
                exit();
            }

            // if password and confirm password don't match
            if ($password !== $passConfirm) {
                header('Location: ./index.php?errorcode=7&formtype=1');
                exit();
            }

            // create account
            $signupStatus = $userAuth->signup($name, $email, $password);

            // if account created and no error
            if ($signupStatus && $signupStatus !== 2) {

                // set the session variable to user details
                $_SESSION['user'] = $signupStatus;

                // redirect to home page
                header('Location: ./home.php');
            }
            // if email address already in use
            else if ($signupStatus === 2) {
                header('Location: ./index.php?errorcode=2&formtype=1');
            }
            // if error happen with insert
            else {
                header('Location: ./index.php?errorcode=0&formtype=1');
            }
        }

        // if connection error with database
        else {
            // redirect to index page with error code 0
            header('Location: ./index.php?errorcode=0&formtype=1');
        }
    }
    // if user didn't fill all fields
    else {
        header('Location: ./index.php?errorcode=1&formtype=1');
    }
}

// if get request
else {
    header('Location: ./index.php?errorcode=1&formtype=1');
}