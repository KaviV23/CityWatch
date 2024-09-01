<?php
//redirect here to submit comment, then redirect back to expanded post
if($_POST){
    require "connection.php";

    $postID = $_POST['postID'];
    $content = $_POST['comment'];

    //extract user id through email cookie
    $username = $_COOKIE['username'];
    $q = "SELECT id FROM users WHERE username = '$username'";
    $idResult = mysqli_query($connect, $q);
    if($idResult){
        $userID = mysqli_fetch_assoc($idResult)["id"];
    }else{
        //add popup here
        echo "Error fetching user ID";
    }

    $q = "INSERT INTO `comments` (`id`, `post_id`, `text`, `user_id`, `rating`) VALUES (NULL, '$postID', '$content', '$userID', '0');";
    // echo $q; // FOR DEBUGGING
    $submitResult = mysqli_query($connect, $q);
    if($submitResult){
        $message = "Comment successfully posted";
    }else{
        $message = "Failed to post comment";
    }
    error_log(print_r($message, TRUE));
    //redirect here
    echo "<form id='redirect-posthub' action='expandedPost.php' method='post'>
    <button style='display: none;' type='submit' name='submit' value='".$postID."'></button>
    </form>";
    echo "<script>document.getElementById('redirect-posthub').submit.click();</script>";
    exit();
}else{
    header("Location: postHub.php");
    exit();
}

?>