<?php
    if( session_status() == 1 )
        session_start();
?>
<?php 
    // including the file that makes a connetiong to database via mysqli
    include("connect_to_db.php");

    // fetching the five foremost posts
    $sql = "SELECT * FROM `posts` Where `post_status`='public' LIMIT 10"; // SQL code for fetching data from the database
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
                while( $post = $posts->fetch_assoc() ){
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
                                    <a style="color: white;background: dodgerblue;text-decoration:none;padding: 1px 4px 1px 6px;border-radius: 5px;display: inline-block;width: 109px;margin: 0px 5px;float: right;" href="post.php?post='.$post_id.'" title="Click to Read Full Post"> Read More...</a>                       
                                </div>
                                <div id="post-bottom">
                                    <span class="post-author">Post Author :   <a href="user.php?username='.$post_author_username.'">'.$author_name.'</a> </span>|   
                                    <span class="post-published">Published : '.$post_publish_date.'  </span>|   
                                    <span class="post-comments">Comments : '.$post_comment_count.'</span> 
                                </div>
                                
                            </div>';
                }
            ?>

            
        </div>    
        <div id="sidebar">
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
                                <img src="'.$user["user_profile_picture_link"].'" width="100px" height="100px" >
                                <span id="userpane-userdetail-name">'.$user["user_fullname"].'</span>
                                <div id="userpane-userdetail-age">'.$user["user_age"].'</div>
                                <div id="userpane-userdetail-gender">'.$user["user_gender"].'</div>
                                <div id="userpane-userdetail-profession">'.$user["user_profession"].'</div>
                            </div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- /Container for the Post -->
    <script src="js/index.js"></script>
    <script src="js/bblibrary.js"></script>
</body>
</html>