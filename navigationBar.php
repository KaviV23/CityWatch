<?php
//for reusability
$curentPage = $_SERVER['SCRIPT_NAME']; // identify current page

if ($curentPage == "/CityWatch/home.php") {
$navigationBar = '
<header>
    <a href="home.php"><h1>CityWatch</h1></a>
    <div id="navbar-container">
        <nav>
            <a href="home.php"><button class="active">Home</button></a>
            <a href="posthub.php"><button>Report & Feedback Hub</button></a>
            <a href="contactus.php"><button>Contact Us</button></a>
        </nav>
        <a href="profile.php" class="pfpanchor"><img src="images/pfp.png"></a>
    </div>
</header>
';
} elseif ($curentPage == "/CityWatch/posthub.php") {
$navigationBar = '
<header>
    <a href="home.php"><h1>CityWatch</h1></a>
    <div id="navbar-container">
        <nav>
            <a href="home.php"><button>Home</button></a>
            <a href="posthub.php"><button class="active">Report & Feedback Hub</button></a>
            <a href="contactus.php"><button>Contact Us</button></a>
        </nav>
        <a href="profile.php" class="pfpanchor"><img src="images/pfp.png"></a>
    </div>
</header>
';
} elseif ($curentPage == "/CityWatch/contactus.php") {
$navigationBar = '
<header>
    <a href="home.php"><h1>CityWatch</h1></a>
    <div id="navbar-container">
        <nav>
            <a href="home.php"><button>Home</button></a>
            <a href="posthub.php"><button>Report & Feedback Hub</button></a>
            <a href="contactus.php"><button class="active">Contact Us</button></a>
        </nav>
        <a href="profile.php" class="pfpanchor"><img src="images/pfp.png"></a>
    </div>
</header>
';
} else {
$navigationBar = '
<header>
    <a href="home.php"><h1>CityWatch</h1></a>
    <div id="navbar-container">
        <nav>
            <a href="home.php"><button>Home</button></a>
            <a href="posthub.php"><button>Report & Feedback Hub</button></a>
            <a href="contactus.php"><button>Contact Us</button></a>
        </nav>
        <a href="profile.php" class="pfpanchor"><img src="images/pfp.png"></a>
    </div>
</header>
';
}
if (isset($_COOKIE['username'])) {
    if ($_COOKIE['username'] == "administrator") {
        echo '<div class="adminbar">Logged in as Administrator</div>';
    }
}
?>