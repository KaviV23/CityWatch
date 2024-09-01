<?php
//string username   user's first and last name
//string useremail  user's email
//bool logged_in    if a user is logged in
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Check cookies</title>
    </head>

    <body>
        <p>User name: <?php echo $_COOKIE['username']?></p>
        <p>User email: <?php echo $_COOKIE['useremail']?></p>
        <p>Logged in: <?php echo $_COOKIE['logged_in']?></p>
    </body>
</html>