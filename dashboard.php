<?php
    if (isset($_POST["operation"]) && $_POST["operation"] == "getdashboardpostlist" ) {
        // import database connector 
        include("connect_to_db.php");
        
        if( session_status() == 1 )
            session_start();

        // fetching all the post of the user and
        // putting them all in all() array 
        $username = $_SESSION["username"];
        $sql = "SELECT `post_status`, `post_thumbnail`,`post_id`,`post_visit_count`,`post_comment_count`,`post_title`,`post_number` FROM `posts` WHERE `post_author_username`='$username' "; // SQL code for fetching data from the database
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
        $sql = "SELECT * FROM `comments` WHERE `comment_post_author_username`='$username' "; // SQL code for fetching data from the database
        $comments = $conn->query( $sql ); // fetched the data
        $comment = array();
        $all = array();
        while ( $row = $comments->fetch_assoc() ) {
            foreach( $row as $key => $value ){
                $comment[$key] = $value;
            }            
            $tmp = $comment["comment_post_id"];
            $post_tilte = $conn->query("SELECT `post_title` FROM `posts` WHERE `post_id`='$tmp' ")->fetch_assoc()["post_title"];
            $comment["post_title"] = $post_tilte;
            array_push($all,$comment);
        }
        echo json_encode($all);
        exit(0);
    }
?>

<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
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
                <div id="drafts" onclick="highlightSelected(this)">Drafts</div>
        </nav>
        <!-- tab for the post list -->
        <div id="all-post-content">
            <div id="allposts">
                <div id="allpostsheader">
                    <span id="postnumberhash" class="allpostsheader-element">#</span>
                    <span id="posttumbpic" class="allpostsheader-element">Thumbnail</span>
                    <span id="posttitle" class="allpostsheader-element">Title</span>
                    <span id="postvisits" class="allpostsheader-element">Views</span>
                    <span id="postcomments" class="allpostsheader-element">Comments</span>
                    <span id="delete" class="allpostsheader-element tools">DELETE</span>
                    <span id="edit" class="allpostsheader-element tools">EDIT</span>
                    <span id="unpublish" class="allpostsheader-element tools">UN <strong>/</strong> PUBLISH</span>
                </div>
                <div id="allpostlist">
                    
                </div>
            </div>
        </div>
        <!-- /tab for the post list -->

        <!-- tab for the comments list -->
        <div id="all-comment-content">
            <div id="allcomments">
                <div id="allcommentsheader">
                    <span id="commentnumberhash" class="allcommentsheader-element">#</span>
                    <span id="commentcommentor" class="allcommentsheader-element">Commentor</span>
                    <span id="commentcomment" class="allcommentsheader-element">Comment</span>
                    <span id="commentpost" class="allcommentsheader-element">Post</span>
                    <span id="commentdate" class="allcommentsheader-element">Comment Given On</span>
                    <span id="deletecomment" class="allcommentsheader-element commenttools">DELETE</span>
                    <span id="massagecommentor" class="allcommentsheader-element commenttools">Send Massage</span>                    
                </div>
                <div id="allcommentslist">
                    
                </div>
            </div>
        </div>
        <!-- tab for the comments list -->

    </div>

    <script src="js/bblibrary.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>