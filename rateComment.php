<?php
if (isset($_POST)) {
    require "connection.php";
    $postID = $_POST['postID'];
    $commentID = $_POST['commentID'];
    $voting = $_POST['submit'];

    $query = "SELECT rating FROM comments WHERE id=$commentID";

    if(mysqli_query($connect, $query)) {
        $qResult = mysqli_query($connect, $query);
        $rating = mysqli_fetch_assoc($qResult)['rating'];
        
        if($voting == "Upvote"){
            $rating++;
            $query = "UPDATE `comments` SET `rating` = '$rating' WHERE `comments`.`id` = $commentID;";
            if(mysqli_query($connect, $query)){
                //redirect
                echo "<form id='redirect-posthub' action='expandedPost.php' method='post'>
                    <button style='display: none;' type='submit' name='submit' value='".$postID."'></button>
                    </form>";
                echo "<script>document.getElementById('redirect-posthub').submit.click();</script>";
            }else{
                echo "Error: " . mysqli_error($connect);
            }
        }else{
            $rating--;
            $query = "UPDATE `comments` SET `rating` = '$rating' WHERE `comments`.`id` = $commentID;";
            if(mysqli_query($connect, $query)){
                //redirect
                echo "<form id='redirect-posthub' action='expandedPost.php' method='post'>
                    <button style='display: none;' type='submit' name='submit' value='".$postID."'></button>
                    </form>";
                echo "<script>document.getElementById('redirect-posthub').submit.click();</script>";
            }else{
                echo "Error: " . mysqli_error($connect);
            }
        }
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>