<?php
$form = <<<END_OF_TEXT
<form method="POST" action="$_SERVER[PHP_SELF]">

<div class="fnamelname">
    <input type="text" name="first_name" size="30" maxlength="75" required="required" placeholder="First name" autocomplete="off"/>
    <input type="text" name="last_name" size="30" maxlength="75" required="required" placeholder="Last name" autocomplete="off"/>
</div>

<input type="text" name="username" size="30" maxlength="16" required="required" placeholder="Username" autocomplete="off"/>

<input type="email" name="email" size="30" maxlength="150" required="required" placeholder="Email" autocomplete="off"/>

<input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" size="30" maxlength="150" minlength="8" required="required" placeholder="Password"/>

<input type="password" name="confirm_password" id="confirm_password" size="30" maxlength="150" minlength="8" required="required" placeholder="Confirm password"/>

<div class="passRequirements">
    <b>Password Requirements:</b>
    <ul>
        <li>At least one lowercase letter</li>
        <li>At least one uppercase letter</li>
        <li>At least one digit</li>
        <li>At least eight characters in length</li>
    </ul>
</div>


<button type="submit" name="submit" value="send" onclick="return validateForm()">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>

<!JavaScript->
<script>
    var btn = document.getElementById('loginBtn');
    btn.addEventListener('click', function() {
        document.location.href = 'login.php';
    });

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
END_OF_TEXT;

//prepare timeout timer
session_start();
$_SESSION['last_activity'] = time();
$timeout_duration = 300; //5 min

if(!$_POST){
    //display form
    $result ='';
}else{
    //register attempt
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    include 'connection.php';

    //search for existing email
    $existing_user_query = "SELECT * FROM users WHERE email='$email'";
    $existing_user_result = mysqli_query($connect, $existing_user_query);
    $existing_user_row = mysqli_fetch_assoc($existing_user_result);

    if(!$existing_user_row){
        $add_user_query = "INSERT INTO users(first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $add_user_query);
    
        //prepared statements for security
        mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $username, $email, $hashed_password);
    
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        if (mysqli_stmt_execute($stmt)) {
            setcookie('username', $username, time() + (86400 * 30), "/");
            setcookie('useremail', $email, time() + (86400 * 30), "/");
            setcookie('logged_in', true, time() + (86400 * 30), "/");
    
            //redirect user
            header("Location: home.php");
    
            $form=''; //hide form
            $result = "User registered successfully";
    
            exit();
        } else {
            $result = "Failed to register user: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }else{
        $result = "This account already exists<p>";
    }
}

//$add_user_query = "INSERT INTO users(first_name, last_name, email, password) VALUES ('first name', 'last name', 'email', 'password')";
//$add_user_request = mysqli_query($connect, $add_user_query) or die(mysqli_error($connect));
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register an account</title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>
    <body class="loginpage">
        <div class="container">
            <h1>CityWatch</h1>
            <img src="images/pfp.png">
            <?php echo $form;?>
            <br>
            <div id="loginerror">
            <p><?php echo $result;?></p>
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