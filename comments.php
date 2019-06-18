<?php
    if ( isset($_POST["operation"]) && $_POST["operation"]=="registernewcomment" && isset($_POST["comment_content"]) ) {        
        include("connect_to_db.php"); // including db connect file
        session_start();
        $comment_id = $post_id = (int)($conn->query("SELECT MAX(comment_id) AS comment_id from `comments`")->fetch_assoc()["comment_id"]);
        $comment_id++;
        $comment_post_id = $_POST["comment_post_id"];
        $comment_commentor_username = $_SESSION["username"];
        $comment_commentor_fullname = $conn->query("SELECT `user_fullname` FROM `users` Where `user_username`="."'$comment_commentor_username'")->fetch_assoc()["user_fullname"];
        $comment_post_author_username = $_POST["commentor_post_author_username"];
        $comment_content = $_POST["comment_content"];
        $comment_birthdate = date("d-m-y");
        $comment_order = (int)($conn->query("SELECT MAX(comment_id) AS comment_id from `comments` WHERE `comment_post_id`='$comment_post_id'")->fetch_assoc()["comment_id"]);
        $comment_order++;
        $comment_date = date("Y-m-d");

        $sql = "INSERT INTO `comments`(`comment_id`, `comment_post_id`, `comment_commentor_username`, `comment_commentor_fullname`, `comment_post_author_username`, `comment_content`, `comment_birthdate`, `comment_order`,`comment_date`) VALUES ($comment_id, $comment_post_id, '$comment_commentor_username', '$comment_commentor_fullname', $comment_post_author_username, $comment_content, $comment_birthdate, $comment_order,'$comment_date')";
        // echo $sql;
        $r = $conn->query( $sql );
        
        $post_comment_count =  (int)$conn->query( "SELECT `post_comment_count` FROM `posts` WHERE `post_id`='$comment_post_id'" )->fetch_assoc()["post_comment_count"];
        $post_comment_count++;

        if( $r ){
            $r = $conn->query("UPDATE `posts` SET `post_comment_count`='$post_comment_count' WHERE `post_id`='$comment_post_id'");
            if( $r ){
                echo $comment_commentor_fullname.":".$conn->query("SELECT `user_profile_picture_link` FROM `users` Where `user_username`="."'$comment_commentor_username'")->fetch_assoc()["user_profile_picture_link"];
            }
        } else {
            echo $sql;
        }
        exit(0);
    }
    // code for deleting all the comments when any post is deleted
    if( isset($_POST["operation"]) && $_POST["operation"]=="registernewcomment" &&  isset($_POST["comment_post_id"]) ){
        
    }

?>