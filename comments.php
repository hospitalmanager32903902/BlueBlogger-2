<?php
    if ( isset($_POST["operation"]) && $_POST["operation"]=="registernewcomment" && isset($_POST["comment_content"]) && isset($_POST["commentor_username"]) ) {        
        include("connect_to_db.php"); // including db connect file
        session_start();
        $comment_id = $post_id = (int)($conn->query("SELECT MAX(comment_id) AS comment_id from `comments`")->fetch_assoc()["comment_id"]);
        $comment_id++;
        $comment_post_id = $_POST["comment_post_id"];
        $comment_commentor_username = $_POST["commentor_username"];
        $comment_commentor_fullname = $_POST["commentor_fullname"];
        $comment_post_author_username = $_SESSION["username"];
        $comment_content = $_POST["comment_content"];
        $comment_birthdate = date("d-m-y");
        $comment_order = (int)($conn->query("SELECT MAX(comment_id) AS comment_id from `comments` WHERE `comment_post_id`='$comment_post_id'")->fetch_assoc()["comment_id"]);
        $comment_order++;

        $sql = "INSERT INTO `comments`(`comment_id`, `comment_post_id`, `comment_commentor_username`, `comment_commentor_fullname`, `comment_post_author_username`, `comment_content`, `comment_birthdate`, `comment_order`) VALUES ($comment_id, $comment_post_id, $comment_commentor_username, $comment_commentor_fullname, '$comment_post_author_username', $comment_content, $comment_birthdate, $comment_order)";
        //echo $sql;
        $r = $conn->query( $sql );
        
        $post_comment_count =  (int)$conn->query( "SELECT `post_comment_count` FROM `posts` WHERE `post_id`='$comment_post_id'" )->fetch_assoc()["post_comment_count"];
        $post_comment_count++;
        $conn->query("UPDATE `posts` SET `post_comment_count`='$post_comment_count' WHERE `post_id`='$comment_post_id'");
        //echo $sql;
        $r = $conn->query( $sql );
        if( $r ){
            $r = $conn->query("UPDATE `posts` SET `post_comment_count`='$post_comment_count' WHERE `post_id`='$comment_post_id'");
            if( $r ){
                echo "successful";
            }
        } else {
            echo $sql;
        }
        exit(0);
    }

?>