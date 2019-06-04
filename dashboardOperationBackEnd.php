<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
    if( !isset($_SESSION["username"]) ){
        echo "User Not Logged in";
    }
    
?>
<?php   include("connect_to_db.php");
    // checking if operation and postid exist and the operation "delete"
    if( isset($_SESSION["username"]) && isset($_POST["operation"]) && isset($_POST["postid"]) && $_POST["operation"] == "delete" ){
        $postid = $_POST["postid"];
        $user = $_SESSION["username"];
        $sql = "DELETE FROM `posts` WHERE `post_id`=$postid AND `post_author_username`='$user'";
        // echo $sql;
        $r = $conn->query( $sql );
        if($r){
            echo "Post Deleted";
            // decrepent post count by 1 
            $post_number = (int)($conn->query("SELECT `user_post_count` FROM `users` WHERE `user_username`='".$user."'")->fetch_assoc()["user_post_count"]);
            $post_number--; // icrease it by 1
            $r = $conn->query("UPDATE `users` SET `user_post_count`=$post_number WHERE `user_username`='".$user."'");

            if ( $r ) {
                echo "User Post Count Decremented";
            } else {
                echo "User Post Count Not Decremented";
            }
        } else {
            echo "Post Not Deleted";
        }
    } 
    
    // checking if operation and postid exist and the operation "publish or unpublish"
    if( isset($_POST["operation"]) && isset($_POST["postid"]) && ( $_POST["operation"] == "public" || $_POST["operation"] == "private" ) ){
        $postid = $_POST["postid"];
        $pub_unpub = $_POST["operation"];
        if( $pub_unpub == "public" ){
            $pub_unpub = "private";
        } else {
            $pub_unpub = "public";
        }
        $sql = "UPDATE `posts` SET post_status='$pub_unpub' WHERE `post_id`=$postid";
        $r = $conn->query( $sql );
        if($r){
            echo "$pub_unpub";
        }
    }

?>