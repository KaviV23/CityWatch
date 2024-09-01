<?php
$feedbackResult = '';
if(!$_POST){
    //do nothing
}else{
    include 'connection.php';
    //post feedback
    $username = $_POST['first_name'] .' '.$_POST['last_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $q = "INSERT INTO `feedback` (`id`, `username`, `email`, `message`) VALUES (NULL, '$username', '$email', '$message');";
    if(mysqli_query($connect, $q)) {
        $feedbackResult = 'Your feedback has been received.';
    } else {
        $feedbackResult = 'An error has occured when posting your feedback';
        //echo mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Contact Us</title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php
        require "navigationBar.php";
        echo $navigationBar;
        ?>        
        <div class = "banner-contact">
            <h1>Contact Us</h1>
        </div> 
        <div class="wrapper-contact">
            <div>
                <h1>Contact info</h1>
                <p><b>Facebook:</b> CityWatch Malaysia</p>
                <p><b>Instagram:</b> citywatch.ig</p>
                <p><b>LinkedIn:</b> CityWatch</p>
                <p>Kaviraj Vijayanthiran<br>22086151@imail.sunway.edu.my</p>
                <p>Sean Tan Ming Sern<br>21050133@imail.sunway.edu.my</p>
            </div>
            <div id="feedback-form">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <h1>Feedback Form</h1>
                    <input type="text" name="first_name" size="30" maxlength="150" required="required" placeholder="First name" autocomplete="off"/> <!intentional whitespace->
                    <input type="text" name="last_name" size="30" maxlength="150" required="required" placeholder="Last name" autocomplete="off"/>
                    <br><br>
                    <input type="text" name="email" size="30" maxlength="150" required="required" placeholder="Email" autocomplete="off"/>
                    <br><br>
                    <textarea id="message" name="message"></textarea>
                    <br>
                    <button type="submit" name="submit" value="submit">Submit</button>
                </form>
            </div>
        </div> 
        
        <?php
        require "bottomBar.php";
        echo $bottomBar;
        ?>
    </body>
</html>