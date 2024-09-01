<?php
if (!isset($_COOKIE['logged_in'])) {
    header("Location: login.php");
} 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Username</title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
         <?php
        require "navigationBar.php";
        echo $navigationBar;

        if(array_key_exists("logout", $_POST)) {                        // delete cookies
            setcookie('username', "", time() - 3600, "/");
            setcookie('useremail', "", time() - 3600, "/");
            setcookie('logged_in', "", time() - 3600, "/");
            header("Location: home.php");
        } 
        ?>

        <?php // get user info
        require "connection.php";

        // get user info from database
        $username = $_COOKIE['username'];
        $userInfo = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE username = '".$username."'"));
        $fname = $userInfo['first_name'];
        $lname = $userInfo['last_name'];
        $useremail = $userInfo['email'];


        ?>
        <body class="profile">
            <div class="profile-flexcontainer">
                <form action="modifyUser.php" method="post">
                    <div class="section1">
                        <h1>User Information</h1>
                        <?php
                        if ($_COOKIE['username'] == "administrator") { //grey out button only for admin
                            echo '
                            <button disabled class="admin-disabled">Save Changes</button>
                            ';
                        } else { // allow editing for normal users
                            echo '
                            <button>Save Changes</button>
                            ';
                        }
                        ?>
                    </div>
                    <div class="section2">
                        <img src="images/pfp.png">
                        <h2>Personal Information</h2>
                        <?php
                        if ($_COOKIE['username'] == "administrator") { //grey out form only for admin
                            echo '
                            <input disabled class="admin-disabled" value="'.$fname.'" type="text" name="first_name" size="30" maxlength="75" required="required" placeholder="First name" autocomplete="off">
                            <input disabled class="admin-disabled" value="'.$lname.'" type="text" name="last_name" size="30" maxlength="75" required="required" placeholder="Last name" autocomplete="off">
                            <input disabled class="admin-disabled" value="'.$username.'" type="text" name="username" size="30" maxlength="16" required="required" placeholder="Username" autocomplete="off">
                            <input disabled class="admin-disabled" value="'.$useremail.'" type="email" name="email" size="30" maxlength="150" required="required" placeholder="Email" autocomplete="off">
                            <input type="hidden" name="modType" value="details">
                            ';
                        } else { // allow profile editing for regular users
                            echo '
                            <input value="'.$fname.'" type="text" name="first_name" size="30" maxlength="75" required="required" placeholder="First name" autocomplete="off">
                            <input value="'.$lname.'" type="text" name="last_name" size="30" maxlength="75" required="required" placeholder="Last name" autocomplete="off">
                            <input value="'.$username.'" type="text" name="username" size="30" maxlength="16" required="required" placeholder="Username" autocomplete="off">
                            <input value="'.$useremail.'" type="email" name="email" size="30" maxlength="150" required="required" placeholder="Email" autocomplete="off">
                            <input type="hidden" name="modType" value="details">
                            ';
                        }
                        ?>
                    </div>
                </form>
                <form action="modifyUser.php" method="post">
                    <div class="section3">
                        <h2>Change Password</h2>
                        <div class="left">
                            <input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" size="30" maxlength="150" minlength="8" required="required" placeholder="Password"/>
                            <input type="password" name="confirm_password" id="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" size="30" maxlength="150" minlength="8" required="required" placeholder="Confirm password"/>
                            <input type="hidden" name="modType" value="password">
                            <button onclick="return validateForm()">Change password</button>
                            <!JavaScript->
                                <script>
                                    function validateForm() {   //password validation
                                        var password = document.getElementById("password").value;
                                        var confirm_password = document.getElementById("confirm_password").value;

                                        if (password !== confirm_password) {
                                            alert("Passwords do not match.");
                                            return false;
                                        }
                                        return true;
                                    }
                                </script>
                            <div class="right">
                            <b>Password Requirements:</b>
                            <ul>
                                <li>At least one lowercase letter</li>
                                <li>At least one uppercase letter</li>
                                <li>At least one digit</li>
                                <li>At least eight characters in length</li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="logout">
                    <h2>Logout</h2>
                    <form method="post" action=""><input type="submit" name="logout" value="Log Out"/></form>
                </div>
                <div class="section4">
                    <h2>Delete User</h2>
                    <p><span style="color: red;">WARNING!</span><br>THIS ACTION WILL DELETE ALL USER DATA<br>THIS ACTION CANNOT BE REVERSED</p>
                    <?php 
                        if ($_COOKIE['username'] == "administrator") {
                            echo '<form action="delete.php" method="post"><input type="checkbox" required disabled><label for="checkbox">Accept</label><button disabled class="admin-disabled" name="deleteUser">DELETE ACCOUNT</button></form>';
                        } else {
                            echo '<form action="delete.php" method="post"><input type="checkbox" required><label for="checkbox">Accept</label><button name="deleteUser">DELETE ACCOUNT</button></form>';
                        }
                    ?>
                    
                </div>
            </div>
        </body>
        <?php
        require "bottomBar.php";
        echo $bottomBar;
        ?>
    </body>
</html>