<?php
if(!$_POST){
    header("Location: postHub.php");
}else{
    require "connection.php";
    //retrieve by post id
    $postID = $_POST["submit"];
    $q = "SELECT * FROM posts WHERE id = $postID";
    $postResult = mysqli_query($connect, $q);
    $postContent = mysqli_fetch_assoc($postResult);

    //retrieve comments
    $q = "SELECT * FROM comments WHERE post_id = $postID";
    $commentResult = mysqli_query($connect, $q);

    //retrieve comment count
    $commentCount = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(*) FROM comments WHERE post_id = $postID"))[0];


    // allow delete privelledges for post
    $postUsername = mysqli_fetch_assoc(mysqli_query($connect, "SELECT username FROM users WHERE id = ".$postContent['user_id']))['username']; // get username
    if (isset($_COOKIE['username'])) {
        if ($_COOKIE['username'] == $postUsername || $_COOKIE['username'] == "administrator") { // if user is post owner/administrator
            $hasPrivileges = true; // has privileges
        } else {
            $hasPrivileges = false; // hide
        }
    } else {
        $hasPrivileges = false; // hide
    }
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>CityWatch</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body class="expandedPost">
        <?php
        require "navigationBar.php";
        echo $navigationBar;

        ?>
        <div class="expandedpost">
            <h1><?php echo $postContent['title']; ?></h1>
            <p><?php echo $postContent['description']; ?></p>
            <?php // show delete button (only for post owner or admin)
                if ($hasPrivileges) {
                    echo '<form action="delete.php" method="post"><input type="hidden" name="postID" value="'.$postID.'"><label id="post-username">Posted by '.$postUsername.'</label><button type="submit" name="deletePost" class="delete-btn">Delete</button></form>';
                } else {
                    echo '<p id="post-username">Posted by '.$postUsername.'</p>';
                }
            ?>
            <img src="<?php echo $postContent['image']; ?>">
            <div class="status">
                <p><?php echo $postContent['rating']; ?></p>
                <form action='ratePost.php' method='post'><input type='hidden' name='postID' value='<?php echo $postID; ?>'><button type='submit' name='submit' value='Upvote'><img src='images/upvote.svg'></button></form>
                <form action='ratePost.php' method='post'><input type='hidden' name='postID' value='<?php echo $postID; ?>'><button type='submit' name='submit' value='Downvote'><img src='images/downvote.svg'></button></form>
                <!-- change colour of status if resolving or resolved -->
                <?php if($postContent['status'] == 'Resolving') { 
                    $changeStatColor = "style='background-color: orange;'";
                } elseif ($postContent['status'] == 'Resolved') {
                    $changeStatColor = "style='background-color: green;'";
                } ?> 
                <p <?php if(isset($changeStatColor)){echo $changeStatColor;} ?>><a href="" onclick="toggleMenu()"><?php echo $postContent['status']; ?></a></p>
            </div>
            <div id="status-sel">
                <p>Set Status</p>
                <ul>
                    <li><form action="changeStatus.php" method="post"><input type="hidden" name="postID" value="<?php echo $postID; ?>"><button type="submit" name="status" value="Pending">Pending</button></form></li>
                    <li><form action="changeStatus.php" method="post"><input type="hidden" name="postID" value="<?php echo $postID; ?>"><button type="submit" name="status" value="Resolving">Resolving</button></form></li>
                    <li><form action="changeStatus.php" method="post"><input type="hidden" name="postID" value="<?php echo $postID; ?>"><button type="submit" name="status" value="Resolved">Resolved</button></form></li>
                </ul>
            </div>
        </div>
        <?php 
        if (isset($_COOKIE['username'])) { // show status setter (only administrator)
            if($_COOKIE['username'] == "administrator") { // enable script only when administrator
                echo "
                <script>
                    function toggleMenu() {
                        let statusSel = document.getElementById('status-sel');
                        if (statusSel.style.right == '' || statusSel.style.right == '0px') {
                            statusSel.style.right = '-110px'; // Show the div
                            setTimeout(()=> {statusSel.style.zIndex = '0';}, 300); // z-index
                        } else {
                            statusSel.style.right = 0; // Show the div
                            statusSel.style.zIndex = '-1'; // z-index
                        }
                        // Prevent the default anchor link behavior
                        event.preventDefault();
                        // Stop the event propagation to prevent the page scroll reset
                        event.stopPropagation();
                    }
                </script>
                ";
            } else {
                echo "
                <script>
                    function toggleMenu() {
                        // Prevent the default anchor link behavior
                        event.preventDefault();
                        // Stop the event propagation to prevent the page scroll reset
                        event.stopPropagation();
                    }
                </script>
                ";
            }
        } else {
            echo "
            <script>
                function toggleMenu() {
                    // Prevent the default anchor link behavior
                    event.preventDefault();
                    // Stop the event propagation to prevent the page scroll reset
                    event.stopPropagation();
                }
            </script>
                ";
        }
        ?>
        <div class="comments">
            <h2><?php echo $commentCount; ?> Comments</h2>
            <form method="POST" action="addComment.php">
                <input type="hidden" name="postID" <?php echo 'value="'.$postID.'"';?>/><!submit the post ID to addComment.php->
                <input type="text" name="comment" size="30" maxlength="255" required="required" placeholder="Leave a comment..." autocomplete="off"/>
                <button type="submit" id="submit" name="submit">Send</button>
             </form>
             <?php
            //$comment = mysqli_fetch_assoc($commentResult);
            if(mysqli_num_rows($commentResult) > 0) {
                while($row = mysqli_fetch_assoc($commentResult)) {
                    //retrieve user name
                        $userID = $row["user_id"];
                        $q = 'SELECT username FROM users WHERE id='.$userID;
                        $usernameResult = mysqli_query($connect, $q);
                        if($usernameResult){
                            $fetchName = mysqli_fetch_assoc($usernameResult);
                            if ($fetchName == null){
                                $commentUsername = "Anonymous";
                            } else {
                                $commentUsername = $fetchName['username'];
                            }
                        }else{
                            $commentUsername = "Anonymous";
                        }
                    //end of retrieving user name
                    if (isset($_COOKIE['username'])) { // if logged in
                        if ($_COOKIE['username'] == $commentUsername || $_COOKIE['username'] == "administrator") { // if admin / comment owner
                            echo
                            "<div>
                                <h3>".$commentUsername."</h3>".
                                "<p>".$row['text']."</p>".
                                "<div class='interactions'>    
                                    <form action='rateComment.php' method='post'><input type='hidden' name='postID' value='$postID'><input type='hidden' name='commentID' value=".$row['id']."><button type='submit' name='submit' value='Upvote' class='vote'><img src='images/upvote.svg'></button></form>
                                    <form action='rateComment.php' method='post'><input type='hidden' name='postID' value='$postID'><input type='hidden' name='commentID' value=".$row['id']."><button type='submit' name='submit' value='Downvote' class='vote'><img src='images/downvote.svg'></button></form>
                                    <p>".$row['rating']."</p>
                                    <form action='delete.php' method='post'><input type='hidden' name='postID' value='".$postID."'><input type='hidden' name='commentID' value=".$row['id']."><button type='submit' name='deleteComment' class='delete-btn'>Delete</button></form>
                                </div>
                            </div>"
                            ;
                        } else { // not comment owner / admin
                            echo
                            "<div>
                                <h3>".$commentUsername."</h3>".
                                "<p>".$row['text']."</p>".
                                "<div class='interactions'>
                                    <form action='rateComment.php' method='post'><input type='hidden' name='postID' value='$postID'><input type='hidden' name='commentID' value=".$row['id']."><button type='submit' name='submit' value='Upvote' class='vote'><img src='images/upvote.svg'></button></form>
                                    <form action='rateComment.php' method='post'><input type='hidden' name='postID' value='$postID'><input type='hidden' name='commentID' value=".$row['id']."><button type='submit' name='submit' value='Downvote' class='vote'><img src='images/downvote.svg'></button></form>
                                <p>".$row['rating']."</p></div>
                            </div>"
                            ;
                        }
                    } else { // not logged in
                        echo
                            "<div>
                                <h3>".$commentUsername."</h3>".
                                "<p>".$row['text']."</p>".
                                "<div class='interactions'>
                                    <form action='rateComment.php' method='post'><input type='hidden' name='postID' value='$postID'><input type='hidden' name='commentID' value=".$row['id']."><button type='submit' name='submit' value='Upvote' class='vote'><img src='images/upvote.svg'></button></form>
                                    <form action='rateComment.php' method='post'><input type='hidden' name='postID' value='$postID'><input type='hidden' name='commentID' value=".$row['id']."><button type='submit' name='submit' value='Downvote' class='vote'><img src='images/downvote.svg'></button></form>
                                <p>".$row['rating']."</p></div>
                            </div>"
                            ;
                    }
                }
            } else {
                echo "<p id='no-comments-msg'>Be the first to comment</p>";
            }
            ?>
        </div>
        <?php
        require "bottomBar.php";
        echo $bottomBar;
        ?>
    </body>
</html>