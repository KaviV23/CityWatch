<?php
//check for cookies
if (isset($_COOKIE['username'])) {
    $header_text = $_COOKIE['username'];
} else {
    $header_text="to CityWatch";
}

if (isset($_COOKIE['logged_in'])) {
    $logged_in = true;
} else {
    $logged_in = false;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome <?php echo $header_text?></title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php
        require "navigationBar.php";
        echo $navigationBar;
        ?>
        <div class = "banner-home">
            <h1>Your Voice Matters</h1>
            <h2>Live a more sustainable future. Join us now!</h2>
        </div> 
        <div class="about-us">
            <img src="images/SDG11.jpg">
            <div id="about-us-textbox">
                <h1>CityWatch:</h1>
                <h2>Sustainable Cities & Communities</h2>
                <p>It is our mission to birth a safe and sustainable environment for all generations to come to improve quality of life, through self-sustaining and resilient communities, as we believe that cities are more than places to live, they are also an environment that fosters the development of mankind. Safe and sustainable cities allow citizens to fret less over minor inconveniences and focus their efforts on bettering their communities.</p>
                <p>Therefore, we seek to achieve our goals by launching a website which provides communities with a platform to provide reports and feedback on various ideas and issues to their local authorities, such as citizens being able to report damaged infrastructure or provide companies with feedback on dealing with pollution and waste.</p>
            </div>
        </div>
        <div class="participate">
            <div class="participate-textarea">
                <h1>Participate Now</h1>
                <div class="loginregister">
                    <a href="login.php"><button>Log in</button></a> <!intentional whitespace->
                    <a href="register.php"><button>Register</button></a>
                </div>
            </div>
            <img src="images/posthub-image.png">
        </div>
        <?php
        require "bottomBar.php";
        echo $bottomBar;
        ?>
    </body>
</html>