<?php
if (isset($_POST)) {
    require "connection.php";
    $postID = $_POST['postID'];
    $voting = $_POST['submit'];

    $query = "SELECT rating FROM posts WHERE id=$postID";

    if(mysqli_query($connect, $query)) {
        $qResult = mysqli_query($connect, $query);
        $rating = mysqli_fetch_assoc($qResult)['rating'];
        
        if($voting == "Upvote"){
            $rating++;
            $query = "UPDATE `posts` SET `rating` = '$rating' WHERE `posts`.`id` = $postID;";
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
            $query = "UPDATE `posts` SET `rating` = '$rating' WHERE `posts`.`id` = $postID;";
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