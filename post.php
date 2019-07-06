<?php    
    if( session_status() == 1 ){
        session_start();
    }
    include_once("connect_to_db.php");

    if( !isset($_GET["post"]) )
        header("Location:index.php");


    $user = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
    // fetching the content of the post
    $sql = "SELECT * FROM `posts` Where `post_id`=".$_GET["post"];
    $post = $conn->query( $sql )->fetch_assoc(); // fetched the data
    
    // checking if the post is public or not
    if( $post["post_status"] == "private" && $post["post_author_username"] != $user ) {        
        header("Location:index.php");
    }

    // fetching the comments of the post
    $sql = "SELECT * FROM `comments` Where `comment_post_id`=".$_GET["post"]; // SQL code for fetching data from the database
    $comments = $conn->query( $sql ); // fetched the data

    // fetching the post author data
    $sql = "SELECT * FROM `users` Where `user_username`='".$post["post_author_username"]."'"; // SQL code for fetching data from the database
    $author = $conn->query( $sql )->fetch_assoc(); // fetched the data
    

    $belongsTo = false;
    $post_id = $_GET["post"];
    $sql = "SELECT post_author_username FROM `posts` WHERE post_id=".$post_id;
    $post_author_username = $conn->query($sql)->fetch_assoc()["post_author_username"];
    if( $user == $post_author_username ){
        $belongsTo = true;
    }
?>

<?php

    if ( !isset($_SESSION["username"]) || $post["post_author_username"] != $_SESSION["username"] ){
        $post_visit_count = (int)$post["post_visit_count"] + 1;
        // fetching the content of the post
        $sql = "UPDATE posts SET post_visit_count=".$post_visit_count ." WHERE `post_id`=".$_GET["post"];
        $conn->query( $sql ); // fetched the data
    }
?>

<?php include_once("header.php"); ?>
    
    <div id="container">
       
        <div>   
            <div id="content" data-post-id="<?php echo $post["post_id"]; ?>" >

                <?php 
                    if($belongsTo){
                        $postid  = (int)$post["post_id"];
                        echo '
                            <div title="Edit This Post" id="editpost-tool" onclick="window.location=\'editpost.php?postid='.$postid.'\'">
                                <svg viewBox="0 0 24 24" id="ic_edit_24px" width="100%" height="100%"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>
                            </div>';
                    }
                ?>

                <img src="img/post_image/<?php echo $post["post_thumbnail"]; ?>" alt="Thumnail Image" width="100px" height="100px" />
                <h1>
                    <?php echo $post["post_title"]; ?>
                </h1>
                <hr style="border: none;border-top: 1.5px solid #03030387;margin: 10px 0px 50px 0px;">
                <div id="blog">
                    <?php echo $post["post_content"]; ?>
                </div>                                    
                <div id="blogbottompane"></div>
            </div>
            <div id="sidebar">
                <div id="userpane">
                    <div style="margin:0px;margin-bottom:10px;font-size:15px;color: #ffffff;background: dodgerblue;text-align: center;padding: 2px 0px;">Author Detail </div>
                    <?php 
                        echo 
                            '<div data-username="'.$author["user_username"].'" id="userpane-userdetail" onclick=window.location="user.php?username='.$author["user_username"].'">
                                <img src="img/profilepic/'.$author["user_profile_picture_link"].'" width="100px" height="100px" >
                                <span id="userpane-userdetail-name">'.$author["user_fullname"].'</span>
                                <div id="userpane-userdetail-age">'.$author["user_age"].'</div>
                                <div id="userpane-userdetail-gender">'.$author["user_gender"].'</div>
                                <div id="userpane-userdetail-profession">'.$author["user_profession"].'</div>
                            </div>';
                    ?>
                </div>
                <?php 
                    if ( !isset($_SESSION["username"]) ) { 
                        echo '<div id="loginpane">
                                <label for="username">User Name:</label>
                                <input type="text" name="username" id="userpane-username">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="userpane-password">
                                <button onclick="postpage_sidelogin(this.parentElement)" id="userpane-loginbutton">Login</button>
                             </div>';
                    }
                ?>
            </div>
        </div>
        <!-- code for comment section -->
        <div id="commentbox">
            <?php
            if ( isset($_SESSION["username"]) ) { 
                echo '    
                    <label for="comment"> Shoot a Comment</label>
                    <textarea name="newcomment" id="newcomment" cols="80" rows="6" placeholder="Write Your Opinion Here And Hit Shoot"></textarea>
                    <button onclick="shootcomment()">Shoot</button>';
            }
            ?>
            <div id="comments">                             
                <!-- Sample Comment  --> 
                <?php   
                while( $comment = $comments->fetch_assoc() ){   
                    // fetching author avatar
                    $commentor_avatar = $conn->query( "SELECT * FROM `users` Where `user_username`='" .$comment["comment_commentor_username"]. "'" )->fetch_assoc();
                    $commentor_username = $commentor_avatar["user_username"]; 
                    $commentor_avatar = $commentor_avatar["user_profile_picture_link"]; 
                    $comment_date = $comment["comment_birthdate"];
                    $commentid = $comment["comment_id"];
                    // echo "SELECT * FROM `users` Where `user_username`='" .$comment["comment_commentor_username"]. "'";
                    echo 
                    '<div class="comment" data-commentid="'.$commentid.'">
                        <div class="commentor">
                            <a href="user.php?username='.$commentor_username.'">
                                <img src=img/profilepic/'.$commentor_avatar.' alt="" width="80px" height="80px" id="commentorAvatar">  <!-- Commentor Avatar -->
                                <label for="commentorAvatar">'.$comment["comment_commentor_fullname"].'</label>
                            </a>
                        </div>                       
                        <div class="commentcontent"> 
                            '.$comment["comment_content"].'
                            <span id="commentDate">'.$comment_date.'</span>                   
                        </div>
                    </div>';
                }
                ?>
                <!-- /Sample Comment -->                
            </div>

        </div>
    </div>
    <script type="text/javascript" src="js/post.js"></script>
    
<?php include_once("footer.php") ?>