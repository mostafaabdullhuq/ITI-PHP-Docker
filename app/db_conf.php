<?php

/*

use SQL Code below to structure database

CREATE DATABASE IF NOT EXISTS users;

CREATE TABLE IF NOT EXISTS users_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(50) NOT NULL,
    email_address VARCHAR(100) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL
);


*/

class Auth
{
    private $mysql;
    public function __construct($host, $user, $pass, $db)
    {
        // database connection configuration
        $this->mysql = new mysqli($host, $user, $pass, $db);
    }

    // to check if database connection succeeded or not
    public function connectionError()
    {
        return $this->mysql->connect_errno;
    }

    public function __destruct()
    {
        $this->mysql->close();
    }

    public function login($email, $password)
    {

        // search for user email in database
        $sql = "
                    SELECT * FROM users_info
                    WHERE email_address = LOWER('$email');
                ";

        $result = $this->mysql->query($sql);

        // if database search done successfully
        if ($result) {

            // get the result of database search
            $row = $result->fetch_assoc();

            /*
            if email found in database, verify the hash with the given password and if it matches, return the user
            else return 3 error code
            */
            return password_verify($password, $row['pass']) ? $row : 3;
        }

        // if there's an error with the database search, return 0 error code
        else {
            return 0;
        }
    }



    public function signup($fullName, $email, $password)
    {
        // check if user already exists

        $selectSQL = "
                        SELECT *
                        FROM users_info
                        WHERE email_address = LOWER('$email');
                    ";

        $selectResult = $this->mysql->query($selectSQL);

        // if email address already in use
        if (!$selectResult || $selectResult->fetch_assoc()) {
            return 2;
        }

        // if email address not exists
        else {

            // convert password to hash
            $hashPass = password_hash($password, PASSWORD_BCRYPT);

            // insert user into database
            $insertSQL = "
                        INSERT INTO users_info(full_name, email_address, pass)
                        VALUES (
                            '$fullName',
                            '$email',
                            '$hashPass'
                        );
                    ";

            $result = $this->mysql->query($insertSQL);

            // if user inserted successfully, return true, else return false
            return $result ? $this->login($email, $password) : false;
        }
    }
}

$userAuth = new Auth('localhost', 'root', '', 'users');