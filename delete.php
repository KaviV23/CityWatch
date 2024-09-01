<?php
require "connection.php";

if(isset($_POST['deletePost'])) {
    // get post id
    $postID = $_POST['postID'];
    
    // retrieve comments
    $commentResult = mysqli_query($connect, "SELECT * FROM comments WHERE post_id = $postID");

    // check & delete comments
    if(mysqli_num_rows($commentResult) > 0) { // if comments found
        while($row = mysqli_fetch_assoc($commentResult)) { // delete each comment
            mysqli_query($connect, "DELETE FROM comments WHERE id = ".$row['id']);
        }
    }
    
    // find and delete post's image
    $imageLoc = mysqli_fetch_row(mysqli_query($connect, "SELECT image FROM posts WHERE id = ".$postID))[0];
    unlink($imageLoc);

    // delete post
    mysqli_query($connect, "DELETE FROM posts WHERE id = ".$postID); // delete post

    // redirect user
    header("Location: posthub.php");
}
if(isset($_POST['deleteComment'])) {
    // get post id
    $postID = $_POST['postID'];

    // get comment id 
    $commentID = $_POST['commentID'];

    // delete comment
    mysqli_query($connect, "DELETE FROM comments WHERE id = ".$commentID);

    // redirect form
    echo "
    <form id='redirect-posthub' action='expandedPost.php' method='post'>
    <button style='display: none;' type='submit' name='submit' value='".$postID."'></button>
    </form>";
    echo "<script>document.getElementById('redirect-posthub').submit.click();</script>";
}
if(isset($_POST['deleteUser'])) {
    $username = $_COOKIE['username'];
    $userID = mysqli_fetch_row(mysqli_query($connect, "SELECT id FROM users WHERE username = '".$username."'"))[0];
    
    // edit username in posts and comments to say deleteduser
    // comments
    $commentsResult = mysqli_query($connect, "SELECT * FROM comments WHERE user_id = ".$userID); // comments list
    if (mysqli_num_rows($commentsResult)> 0) { // if there are comments
        mysqli_query($connect, "UPDATE comments SET user_id = 0 WHERE user_id = ".$userID);
    }

    // post
    $postResult = mysqli_query($connect, "SELECT * FROM posts WHERE user_id = ".$userID); // posts list
    if (mysqli_num_rows($commentsResult)> 0) { // if there are posts
        mysqli_query($connect, "UPDATE posts SET user_id = 0 WHERE user_id = ".$userID);
    }

    // delete user
    mysqli_query($connect, "DELETE FROM users WHERE id = ".$userID);

    // reset cookies
    setcookie('username', "", time() - 3600, "/");
    setcookie('useremail', "", time() - 3600, "/");
    setcookie('logged_in', "", time() - 3600, "/");

    // redirect
    header("Location: home.php");
}
?>