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
            if( $post_number > 0 ) $post_number--; // decrease it by 1
            $r = $conn->query("UPDATE `users` SET `user_post_count`=$post_number WHERE `user_username`='".$user."'");

            if ( $r ) {
                echo "User Post Count Decremented";
            } else {
                echo "User Post Count Not Decremented";
            }
            // delete all the comments off that post
            $r = $conn->query("DELETE FROM `comments` WHERE comment_post_id='$postid'");            
            if ( $r ) {
                echo "All comments of that post is deleted";
            } else {
                echo " comments not deleted";
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

    // checking if operation and commentid exist and the operation "deletecomment"
    if( isset($_SESSION["username"]) && isset($_POST["operation"]) && isset($_POST["commentid"]) && $_POST["operation"] == "deletecomment" ){
        $commentid = $_POST["commentid"];
        $user = $_SESSION["username"];
        $sql = "DELETE FROM `comments` WHERE `comment_id`=$commentid AND `comment_post_author_username`='$user'";
        // echo $sql;
        $r = $conn->query( $sql );
        if($r){
            echo "Comment Deleted";
            // decrement Comment count by 1 
            $commnet_number = (int)($conn->query("SELECT `user_comment_count` FROM `users` WHERE `user_username`='".$user."'")->fetch_assoc()["user_comment_count"]);
            $commnet_number == 0 ? $commnet_number : $commnet_number--; // decrease it by 1
            $r = $conn->query("UPDATE `users` SET `user_comment_count`=$commnet_number WHERE `user_username`='".$user."'");

            // decrement Comment count by 1 
            $commnet_number = (int)($conn->query("SELECT `post_comment_count` FROM `posts` WHERE `post_id`='".$post_id."'")->fetch_assoc()["user_comment_count"]);
            $commnet_number == 0 ? $commnet_number : $commnet_number--; // decrease it by 1
            $r = $conn->query("UPDATE `users` SET `user_comment_count`=$commnet_number WHERE `user_username`='".$user."'");

            if ( $r ) {
                echo "User Comment Count Decremented";
            } else {
                echo "User Comment Count Not Decremented";
            }
        } else {
            echo "Comment Not Deleted";
        }
    } 

?>