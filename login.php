<?php
$form = <<<END_OF_TEXT
<form method="POST" action="$_SERVER[PHP_SELF]">
    <input type="email" name="email" size="30" maxlength="150" required="required" placeholder="Email" autocomplete="off"/>

    <input type="password" name="password" id="password" size="30" maxlength="150" minlength="8" required="required" placeholder="Password"/>

    <button type="submit" name="submit" value="send">Log in</button>
</form>

<p>Don't have an account? <a href="register.php">Create one now!</a></p>

END_OF_TEXT;

//prepare timeout timer
session_start();
$_SESSION['last_activity'] = time();
$timeout_duration = 60; //1 min

if(!$_POST){
    //display form
    $result ='';
}else{
    //login attempt
    $email = $_POST['email'];
    $password = $_POST['password'];

    include 'connection.php';

    // Retrieve hashed password from the database based on the entered email
    $get_user_query = 'SELECT username, password FROM users WHERE email=?';
    $stmt = mysqli_prepare($connect, $get_user_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_name, $hashed_password);

    if (mysqli_stmt_fetch($stmt)) {            
        if (password_verify($password, $hashed_password)) {
            setcookie('username', $user_name, time() + (86400 * 30), "/");
            setcookie('useremail', $email, time() + (86400 * 30), "/");
            setcookie('logged_in', true, time() + (86400 * 30), "/");

            //redirect user
            header("Location: home.php");

            $form=''; //hide form
            $result = "Login successful";

            exit();
        } else {                
            $result = "Incorrect password";
        }
    } else {
        $result = "This account does not exist.";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>
    <body class="loginpage">
        <div class="container">
            <h1>CityWatch</h1>
            <img src="images/pfp.png">
            <?php echo $form;?>
            <br>
            <div id="loginerror">
            <?php echo "<p>".$result."</p>";?>
            </div>
        </div>

        <script>
            // Set the timeout duration in milliseconds
            var timeoutDuration = <?php echo $timeout_duration * 1000; ?>;

            function redirectOnTimeout() {
                alert('You have been inactive for too long. You will now be redirected.');
                clearInterval(inactivityInterval);
                window.location.href = 'home.php';
            }

            // Set up an interval to check for inactivity
            var inactivityInterval = setInterval(function() {
                if (Date.now() - <?php echo $_SESSION['last_activity']; ?> * 1000 > timeoutDuration) {
                    redirectOnTimeout();
                }
            }, 1000); // Check every second

            // Reset the last activity time when there is user interaction
            document.addEventListener('mousemove', function() {
                <?php $_SESSION['last_activity'] = time(); ?>;
            });
        </script>
    </body>
</html>