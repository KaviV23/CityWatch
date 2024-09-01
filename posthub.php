<?php
require "connection.php";

$q="";              //sorting query
$filterStatus="";   //filter status
$sortOrder="";      //latest, oldest etc

if(!$_POST){
    $q = "SELECT * FROM posts ORDER BY date DESC"; //default sorting
    $result = mysqli_query($connect, $q);
}else if($_POST){
    //sorting filter applied

    //filter by status
    if (isset($_POST['status']) && is_array($_POST['status'])) {
        $filterStatus = " WHERE status IN ('" . implode("','", $_POST['status']) . "')";
    }

    //check sorting
    if($_POST['sort']=="latest"){
        //latest date
        $sortOrder=" ORDER BY date DESC";
    }else if($_POST['sort']=="oldest"){
        //oldest date
        $sortOrder=" ORDER BY date ASC";
    }else if($_POST['sort']=="popular"){
        //by rating/popularity
        $sortOrder=" ORDER BY rating DESC";
    }

    $q = "SELECT * FROM posts".$filterStatus.$sortOrder;
    $result = mysqli_query($connect, $q);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CityWatch</title>
        <link href="styles.css" rel="stylesheet" type="text/css">
    </head>

    <body id="posthub-body">
        <?php
        require "navigationBar.php";
        echo $navigationBar;
        ?>
        <div id="posthub-container">
            <div id="filter-box">
                <!filter window->
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <p>Filter</p>
                    <input type="checkbox" name="status[]" value="Pending"><label>Pending</label><br/>
                    <input type="checkbox" name="status[]" value="Resolving"><label>Resolving</label><br/>
                    <input type="checkbox" name="status[]" value="Resolved"><label>Resolved</label><br/>

                    <p>Sort</p>
                    <select name="sort" id="sort">
                        <option value="latest">Sort by latest</option>
                        <option value="oldest">Sort by oldest</option>
                        <option value="popular">Sort by rating</option>
                    </select>
                    <br><br>
                    <button id="sortbtn" type="submit" name="submit" value="submit">Sort</button>
                </form>
                <a href="createPost.php"><button id="createpostbtn">+ Create Post</button></a>
            </div>

            <!post list->
            <div id="posts-box">
            <?php
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // get comments num
                    $commentsNum = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(*) FROM comments WHERE post_id = ".$row['id']))[0];
                    $html = "
                    <div class='post-container'>
                        <img src='".$row['image']."'>
                        <div class='post-info'>
                            <h2>" . $row['title'] . "</h2>
                            <p>" . $row['description'] . "</p>
                            <div>
                                <form method='POST' action='expandedPost.php'>
                                    <button id='expandbtn' type='submit' name='submit' value='".$row['id']."'>Expand Post &rarr;</button>
                                    <p id='votescomments'>".$row['rating']." Votes &centerdot; ".$commentsNum." Comments</p>
                                    <span><p>Status: ".$row['status']."</p></span>
                                </form>
                            </div>
                        </div>
                    </div>
                    ";

                    echo $html;
                }
            } else {
                echo "0 Results";
            }
            ?>
            </div> 
        </div>
        <?php
        require "bottomBar.php";
        echo $bottomBar;
        ?>
    </body>
</html>