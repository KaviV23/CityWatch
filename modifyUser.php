<?php
    if (isset($_POST)) {
        require "connection.php";
        if ($_POST['modType'] == "details") {
            $currentUsername = $_COOKIE['username'];

            $newFname = $_POST['first_name'];
            $newLname = $_POST['last_name'];
            $newUsername = $_POST['username'];
            $newEmail = $_POST['email'];

            $updateQuery = "UPDATE `users` SET `username` = '".$newUsername."', `first_name` = '".$newFname."', `last_name` = '".$newLname."', `email` = '".$newEmail."' WHERE `users`.`username` = '".$currentUsername."'";
            if(mysqli_query($connect, $updateQuery)) {
                echo "success";

                // update cookies
                setcookie('username', $newUsername, time() + (86400 * 30), "/");
                setcookie('useremail', $newEmail, time() + (86400 * 30), "/");
                setcookie('logged_in', true, time() + (86400 * 30), "/");

                // redirect
                header("Location: profile.php");
                
            } else {
                echo mysqli_error($connect);
            }
        }
        if ($_POST['modType'] == "password") {
            $newPass = $_POST["password"];
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE `users` SET `password` = '$hashedPass' WHERE `users`.`email` = '".$_COOKIE['useremail']."';";
            if(mysqli_query($connect, $updateQuery)) {
                echo "success";
            } else {
                echo mysqli_error($connect);
            }

            //redirect
            header("Location: profile.php");
        }
    }
?>