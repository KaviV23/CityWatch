<?php
// redirect user if not signed in
if(!$_COOKIE['username']) {
    header("Location: login.php");
}

//prepare timeout timer
session_start();
$_SESSION['last_activity'] = time();
$timeout_duration = 300; //5 min

//send form back to itself to confirm post is created before linking to the post
if($_POST){
    require "connection.php";

    $title = $_POST['title'];
    $description = $_POST['description'];
    $useridQuery = "SELECT id FROM users WHERE username = '".$_COOKIE['username']."'";
    $useridQueryResult = mysqli_query($connect, $useridQuery);
    $userid = mysqli_fetch_array($useridQueryResult)['id'];

    $file = $_FILES['postImage']; // file information (associative array)

    // seperated file info
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileType = $file['type'];
    $fileNameExploded = explode('.', $fileName); // seperates file name & extension
    $fileExt = strtolower(end($fileNameExploded));

    $allowedExts = array("jpg", "jpeg", "png"); // allowed file extensions

    // image uploading sequence
    if (in_array($fileExt, $allowedExts)) { // check filetype
        if ($fileError === 0) { // check upload error
            $fileNewName = uniqid('', true).".".$fileExt; // rename file with unique identifier
            $fileDestination = "images/uploads/".$fileNewName; // file destination
            move_uploaded_file($fileTmpName, $fileDestination); // move file to destination 

            $query = "INSERT INTO posts (image, title, description, user_id) VALUES ('" . $fileDestination .  "','" . $title . "','" . $description . "'," . $userid . ")";
            if(!mysqli_query($connect, $query)) {
                echo "DATABASE ERROR";
            } else {
                header("Location: posthub.php");
            }

        } else {
            echo "Error uploading file";
        }
    } else {
        echo "Wrong file type";
    }

    //header("Location: expandedPost.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create a post</title>
        <link href="styles.css" type="text/css" rel="stylesheet">
    </head>
    <body class="uploadPage">
        <div>
        <h1>Create a post</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <input type="text" name="title" size="30" maxlength="255" required="required" placeholder="Title" autocomplete="off"/>
            <textarea cols="31" rows="9" type="text" name="description" size="30" maxlength="255" required="required" placeholder="Description" autocomplete="off"></textarea>
            <label for="postImage">Upload image:</label>
            <input type="file" id="postImage" required name="postImage">
            <div>
                <a href="posthub.php" style="text-decoration: none;"><back>Back</back></a>
                <button type="submit" id="submit" name="submit">Post</button>
            </div>
        </form>
        </div>

        <script>
            // Set the timeout duration in milliseconds
            var timeoutDuration = <?php echo $timeout_duration * 1000; ?>;

            function redirectOnTimeout() {
                alert('You have been inactive for too long. You will now be redirected.');
                clearInterval(inactivityInterval);
                window.location.href = 'posthub.php';
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