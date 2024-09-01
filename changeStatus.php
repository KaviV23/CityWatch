<?php
if (isset($_POST)) {
    require "connection.php";
    $postID = $_POST['postID'];
    $status = $_POST['status'];

    $query = "UPDATE `posts` SET `status` = '".$status."' WHERE `posts`.`id` = ".$postID;

    if(mysqli_query($connect, $query)) {
        // redirect
        echo "<form id='redirect-posthub' action='expandedPost.php' method='post'>
        <button style='display: none;' type='submit' name='submit' value='".$postID."'></button>
        </form>";
        echo "<script>document.getElementById('redirect-posthub').submit.click();</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>