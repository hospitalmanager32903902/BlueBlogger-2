<?php 
    // including the file that makes a connetiong to database via mysqli
    include("connect_to_db.php");

    // fetching the five foremost posts
    $sql = "SELECT * FROM `posts` Where `post_status`='public' LIMIT 5"; // SQL code for fetching data from the database
    $posts = $conn->query( $sql ); // fetched the data
    
?>


<?php include("header.php"); ?>
    <!-- Container for the Post'S AND Sidebar -->
    <div id="container">
        <div id="postContainer">

            <?php
                while( $post = $posts->fetch_assoc() ){
                    //echo "ok it comes here";
                    $post_thumbnail = $post['post_thumbnail'];
                    $post_id = $post['post_id'];
                    $post_excerpt = $post['post_content'];
                    $post_title = $post['post_title'];
                    echo 
                        '<div class="post" >
                            <img src="img/post_image/'.$post_thumbnail.'" alt="Thumbnail Picture">
                            <span class="post_title">'.$post_title.'</span>
                            <div class="excerpt">
                                '.substr($post_excerpt,0,150).'                            
                            </div>
                            
                            <a href="post.php?post='.$post_id.'" data-link-type="readmore">Read More...</a>
                        </div>';
                }
            ?>


        </div>    
        <div id="sidebar">
            Soon, In Here Sidebar Going to be placed
        </div>
    </div>
    <!-- /Container for the Post -->
    <script src="js/index.js"></script>
</body>
</html>