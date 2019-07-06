<?php

    if( session_status() == 1 )
    session_start();

    if (isset($_POST["operation"]) && $_POST["operation"] == "getdashboardpostlist" ) {
        // import database connector 
        include("connect_to_db.php");

        // fetching all the post of the user and
        // putting them all in all() array 
        $username = $_SESSION["username"];
        $sql = "SELECT * FROM `posts` WHERE `post_author_username`='$username' "; // SQL code for fetching data from the database
        $posts = $conn->query( $sql ); // fetched the data
        $post = array();
        $all = array();
        while ( $row = $posts->fetch_assoc() ) {
            foreach( $row as $key => $value ){
            $post[$key] = $value;
            }
            array_push($all,$post);
        }
        echo json_encode($all);
        exit(0);
    }


    if ( isset($_POST["operation"]) && $_POST["operation"] == "getdashboardcommentlist" ) {
        // import database connector 
        include("connect_to_db.php");        
        if( session_status() == 1 )
            session_start();

        // fetching all the post of the user and
        // putting them all in all() array 
        $username = $_SESSION["username"];

        $sql = "SELECT posts.post_title, posts.post_id, comments.comment_post_id, comments.comment_commentor_username, comments.comment_commentor_fullname, comments.comment_post_author_username, comments.comment_content, comments.comment_birthdate, comments.comment_birthdate, comments.comment_id FROM `posts` JOIN `comments` ON comments.comment_post_id = posts.post_id AND comments.comment_post_author_username='$username'";
        
        $comments = $conn->query( $sql ); // fetched the data
        $comment = array();
        $all = array();
        while ( $row = $comments->fetch_assoc() ) {
            foreach( $row as $key => $value ){
                $comment[$key] = $value;
            }
            array_push($all,$comment);
        }
        echo json_encode($all);
        exit(0);
    }
    if ( isset($_POST["operation"]) && $_POST["operation"] == "getdashboarduserlist" ) {
        // import database connector 
        include("connect_to_db.php");        
        if( session_status() == 1 )
            session_start();

        // fetching all the post of the user and
        // putting them all in all() array 
        $username = $_SESSION["username"];
        $sql = "SELECT * FROM `users`"; // SQL code for fetching data from the database
        $users = $conn->query( $sql ); // fetched the data
        $user = array();
        $all = array();
        while ( $row = $users->fetch_assoc() ) {
            foreach( $row as $key => $value ){
                $user[$key] = $value;
            }                        
            array_push($all,$user);
        }
        echo json_encode($all);
        exit(0);
    }
    
?>

<?php
    $admin = false;
    if( isset($_SESSION["user_roll"]) &&  $_SESSION["user_roll"] == "admin" ){
        $admin = true;
    }
?>

<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    if( !isset($_SESSION["username"]) ){
        header("Location:login.php");
    }
    
?>
<?php include("header.php"); ?>


    <div id="container">
        <nav id="sidenav">
                <a href="createnewpost.php" id="createnewpost" >Create New Post</a>
                <div id="posts" onclick="showPosts(this)">Posts</div>
                <div id="comments" onclick="showComments(this)">Comments</div>
                <?php 
                    if( $admin ){
                        echo '<div id="users" onclick="showUser(this)">Users</div>';
                    }
                ?>
        </nav>
        <!-- tab for the post list -->
        <div id="all-post-content">
            <div id="allposts">
                <div id="allpostsheader">
                    <span id="postnumberhash" class="allpostsheader-element">#</span>
                    <span id="posttumbpic" class="allpostsheader-element">Thumbnail </span>
                    <span id="posttitle" class="allpostsheader-element" data-sorted-bytitle="no" onclick="sort(this,'title')">Title ▶</span>
                    <span style="width:80px" id="postvisits" class="allpostsheader-element" data-sorted-byviews="no" data-sorted="no"  onclick="sort(this,'views')">Views ▶</span>
                    <span id="postcomments" class="allpostsheader-element"  data-sorted-bycomments="no" onclick="sort(this,'comments')">Comments ▶</span>
                    <span style="width:140px" id="postdate" class="allpostsheader-element"  data-sorted-bydate="no" onclick="sort(this,'date')">Published At ▶</span>
                    <span id="delete" class="allpostsheader-element tools">DELETE</span>
                    <span id="edit" class="allpostsheader-element tools">EDIT</span>
                    <span style="width:105px" id="unpublish" class="allpostsheader-element tools">UN<strong>-</strong>PUBLISH</span>
                </div>
                <div id="allpostlist">
                    
                </div>
            </div>
        </div>
        <!-- /tab for the post list -->

        <!-- tab for the comments list -->
        <div id="all-comment-content">
            
        </div>
        <!-- tab for the comments list -->

        <!-- tab for the users list -->
        <?php
        if( $admin ){
            echo '
                <div id="all-user-content">
                <table id="user-table">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>User Name</td>
                                <td  style="width:80px;">ID</td>
                                <td>Posts</td>
                                <td>Joined</td>
                                <td style="width:200px">Email</td>
                                <td>From</td>
                                <td style="width:50px;cursor: pointer;padding-bottom: 7px;">
                                    <svg viewBox="0 0 24 24" id="ic_delete_24px" width="24px" height="24px"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            
                        </tbody>
                </table>
                </div>';
            }
        ?>        
        <!-- tab for the comments list -->
        <div id="comment-table" style="display: inline-block;">
            <div id="all-comments">
                    <div id="all-comments-header">
                        <span class="allcommentsheader-element" style="font-weight: bold; width:50px;">#</span>
                        <span class="allcommentsheader-element comment-commentor" data-sorted-bytitle="no" onclick="sortComments(this,'commentor')" style="width:180px;">Commentor ▶</span>
                        <span class="allcommentsheader-element comment-content" style="width:380px;" data-sorted-byviews="no" data-sorted="no" onclick="sortComments(this,'content')">Said ▶</span>
                        <span class="allcommentsheader-element comment-post" data-sorted-bycomments="no" onclick="sortComments(this,'post')" style="width:280px;">On The Post ▶</span>
                        <span class="allcommentsheader-element comment-date" style="width:120px;" data-sorted-bydate="no" onclick="sortComments(this,'date')">At ▶</span>
                        <span class="allcommentsheader-element comment-delete-tool" style="padding-top: 5px;width:65px;">
                            <svg viewBox="0 0 24 24" id="ic_delete_24px" width="24px" height="24px"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                        </span>
                    </div>
                    <div id="all-comments-list">
                        
                    </div>
                </div>
        </div>


    </div>

    <script src="js/bblibrary.js"></script>
    <script src="js/dashboard.js"></script>
    
<?php include_once("footer.php") ?>