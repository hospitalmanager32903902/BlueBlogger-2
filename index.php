<?php
    if( session_status() == 1 )
        session_start();
?>
<?php 
  // including the file that makes a connetion to database via mySql
    include("connect_to_db.php");

    $postPerPage = 5;
  // finding out the number of posts that are public in the database 
    $sql = "SELECT COUNT(post_id) FROM `posts` ";
    $postCount = (int)$conn->query( $sql )->fetch_assoc()["COUNT(post_id)"];
    // echo "<script> alert('$postCount') </script>";

  // which page is it
    if ( !isset($_GET["page"]) ) {
        $page = 1;
    } else {
        $page = (int)$_GET["page"];
    }

  // fetching the  posts
    $sql = "SELECT * FROM `posts` Where `post_status`='public' "; // SQL code for fetching data from the database
    $posts = $conn->query( $sql ); // fetched the data
  
    
?>



<?php include("header.php"); ?>
    <!-- Container for the Post'S AND Sidebar -->
    <div id="container">
        <?php
            if ( isset($_SESSION["username"]) ){
                echo '<a id="homepage-createnewpost" href="createnewpost.php"><span>+</span> Create New Post</a>';
            }
        ?>
        <div id="postContainer">

            <?php

                $from = ( ($page-1)  * $postPerPage);
                $to = $from + $postPerPage;
                $tmp_i = 0;
                while( $post = $posts->fetch_assoc() ){
                    if ( $tmp_i >= $from && $tmp_i < $to  ) { 
                        //echo "ok it comes here";
                        $post_thumbnail = $post['post_thumbnail'];
                        $post_id = $post['post_id'];
                        $post_excerpt = $post['post_excerpt'];
                        if ( strlen($post_excerpt) < 1 ) {
                            $post_excerpt = substr($post['post_content'],0,100);                        
                        } else {
                            $post_excerpt = substr($post_excerpt,0,180);
                        }
                        $post_title = $post['post_title'];
                        $post_publish_date = $post['post_publish_date'];
                        $post_comment_count = $post['post_comment_count'];
                        $post_author_username = $post['post_author_username'];
                        $post_visit_count = $post['post_visit_count'];

                        $sql = "SELECT `user_fullname`,`user_username` FROM `users` Where `user_username`='$post_author_username' LIMIT 1"; // SQL code for fetching data from the database
                        $author = $conn->query( $sql ); // fetched the data
                        $author_name = $author->fetch_assoc()["user_fullname"];
                        echo 
                            '
                                <div class="post" >
                                    <img src="img/post_image/'.$post_thumbnail.'" alt="Thumbnail Picture">
                                    <a href="post.php?post='.$post_id.'"><span class="post_title">'.$post_title.'</span></a>
                                    <div class="excerpt">
                                        '.$post_excerpt.'...     
                                        <a href="post.php?post='.$post_id.'" title="Click to Read Full Post"> Read More...</a>                       
                                    </div>
                                    <div id="post-bottom">
                                        <span class="post-author">Post Author :   <a href="user.php?username='.$post_author_username.'">'.$author_name.'</a> </span>|   
                                        <span class="post-published">Published : '.$post_publish_date.'  </span>|   
                                        <span class="post-comments">Comments : '.$post_comment_count.'</span> |
                                        <span class="post-visits">Views : '.$post_visit_count.'</span>
                                    </div>                                
                                </div>';
                    }
                    $tmp_i++;
                }
            ?>

            
        </div> 
        <!-- paginator code -->
        <?php 
        if ( $postCount > $postPerPage ) {
            $pageNeeded = ($postCount % $postPerPage) > 0 ? 1 : 0;
            $pageNeeded += (int)($postCount / $postPerPage);
            $tmp = "";
            for ($i=1; $i <= $pageNeeded; $i++) {                 
                if( $page == $i) {
                    $active = "active";
                } else {
                    $active = "";
                }
                $tmp .= "<a href='index.php?page=$i'>
                    <div class='pagelinks $active'>$i</div>
                </a>";
            }
            if ( $pageNeeded == $page ) {
                $nextPage = $page;
            } else {
                $nextPage = $page + 1;
            } 
            if ( $page == 1 ) {                
                $prevPage = 1;
            } else {
                $prevPage = $page - 1;
            }
            echo 
                "<div id='paginator'>
                    <a href='index.php?page=$prevPage'>
                        <div class='pagelinks'> < </div>
                    </a>
                    $tmp
                    <a href='index.php?page=$nextPage'>
                        <div class='pagelinks'> > </div>
                    </a>
                </div>"; 
        }
        ?>
        <!-- paginator code -->

        <div id="sidebar">
            <div id="searchbox">
                <label> Search For Content </label>
                <form action="search.php" method="get">
                    <input type="text" name="q" id="searchtext">
                    <button style="" type="submit" id="searchaction"></button>
                </form>
            </div>
            <div id="userpane">
                <?php                 
                    if(!isset($_SESSION["username"])){
                        echo 
                            '<label for="username">User Name:</label>
                            <input type="text" name="username" id="userpane-username">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="userpane-password">
                            <button onclick="homepage_sidelogin(this.parentElement)" id="userpane-loginbutton">Login</button>';
                    } else {
                        echo 
                            '<div id="userpane-userdetail" onclick=window.location="profile.php">
                                <img src="img/profilepic/'.$user["user_profile_picture_link"].'" width="100px" height="100px" >
                                <span id="userpane-userdetail-name">'.$user["user_fullname"].'</span>
                                <div id="userpane-userdetail-age">'.$user["user_age"].'</div>
                                <div id="userpane-userdetail-gender">'.$user["user_gender"].'</div>
                                <div id="userpane-userdetail-profession">'.$user["user_profession"].'</div>
                            </div>';
                    }
                ?>

            </div>
            <div id="recentpost">
                
            </div>
        </div>
    </div>
    <!-- /Container for the Post -->
    <script src="js/index.js"></script>
    <script src="js/bblibrary.js"></script>
</body>
</html>