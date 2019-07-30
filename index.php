
<?php
    if( session_status() == 1 )
        session_start();
    // including the file that makes a connetion to database via mySql
        include("connect_to_db.php");
?>

<!-- give me top/recent post -->
<?php
    if( isset($_GET["givetoprecentposts"]) ) {
        if ( $_GET["givetoprecentposts"] == "topposttab" ) {
            $sql = "SELECT post_title,post_id,post_visit_count FROM posts WHERE post_status='public' ORDER BY post_visit_count DESC LIMIT 5";
        } else {
            $sql = "SELECT post_title,post_id,post_visit_count FROM posts WHERE post_status='public' ORDER BY post_publish_date ASC LIMIT 5";
        }
        $recentPosts = $conn->query($sql);
        while( $recentpostitem = $recentPosts->fetch_assoc() ){
            $postttititle = $recentpostitem["post_title"];
            $postid = (int)$recentpostitem["post_id"];
            echo "<div class='recentpostsitem'>
                    <a href='post.php?post=$postid'>$postttititle</a>
                </div>";
        }
        exit(0);
    }
?>
<!-- /give me top/recent post -->

<?php 

    $postPerPage = 5;
  // finding out the number of posts that are public in the database 
    $sql = "SELECT COUNT(*) FROM `posts` WHERE post_status='public'";
    $postCount = (int)$conn->query( $sql )->fetch_assoc()["COUNT(*)"];
    // echo "<script> alert('$postCount') </script>";

  // which page is it
    if ( !isset($_GET["page"]) ) {
        $page = 1;
    } else {
        $page = (int)$_GET["page"];
    }

  // fetching the  posts
    $sql = "SELECT * FROM `posts` Where `post_status`='public' ORDER BY post_publish_date ASC "; // SQL code for fetching data from the database
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
            require_once("paginator.php");
        ?>
        <!-- /paginator code -->

        <div id="sidebar">
            <div id="searchbox">
                <label> Search For Content </label>
                <form action="search.php" method="get">
                    <input type="text" name="q" id="searchtext">
                    <button style="" type="submit" id="searchaction"></button>
                </form>
            </div>
            
            <!-- User Login pane -->
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
            <!-- / User Login pane -->

            <!-- Recently uploaded Posts pane -->
            <div id="recentpost">
                <div id="recentpostheader">
                    <span onclick="switchTabTopRecentPostTab(this)" id="recentposttab" data-selected="no">Recent Posts</span>
                    <span onclick="switchTabTopRecentPostTab(this)" id="topposttab" data-selected="yes">Top Posts</span>
                </div>   
                <div id="recentpostlist">

                </div>           
            </div>            
            <!-- / Recently uploaded Posts pane -->
            
            <!-- Recent Comments -->
            <?php
                $user = $_SESSION["username"];
                if( isset($_SESSION["username"]) ){
                    echo '
                        <div id="recentcomments">                
                            <div id="recentcommentsheader">
                                Recent Comments
                            </div>
                            <div id="recentcommentslist">';
                            
                                $sql = "SELECT comment_content,comment_post_id,comment_id FROM comments where comment_post_author_username='$user' ORDER BY comment_date DESC LIMIT 5";                
                                $recentComments = $conn->query($sql);
                                while( $recentcommentitem = $recentComments->fetch_assoc() ){
                                    $commenttitle= substr($recentcommentitem["comment_content"],0,20);
                                    $postid = (int)$recentcommentitem["comment_post_id"];
                                    $commentid = $recentcommentitem["comment_id"];
                                    echo "<div class='recentcommentsitem' data-commentid='$commentid'>
                                            <a href='post.php?post=$postid&commentid=$commentid'>$commenttitle</a>
                                        </div>";
                                }
                            
                    echo "</div>    
                    </div>";
                }
            ?>
            <!-- /Recent Comments -->

        </div>
    </div>
    <!-- /Container for the Post -->


    <script src="js/index.js"></script>

<?php include_once("footer.php") ?>