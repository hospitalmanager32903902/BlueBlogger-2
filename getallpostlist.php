<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blueblogger";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  
    
    session_start();
    $username = $_SESSION["username"];

    $sql = "SELECT `post_thumbnail`,`post_id`,`post_visit_count`,`post_comment_count`,`post_title`,`post_number` FROM `posts` WHERE `post_author_username`='$username' LIMIT 5 "; // SQL code for fetching data from the database

    $posts = $conn->query( $sql ); // fetched the data
    $all_post = array();
    $all = array();
    while ( $row = $posts->fetch_assoc() ) {
        foreach( $row as $key => $value ){
           $all_post[$key] = $value;
        }
        array_push($all,$all_post);
    }
    echo json_encode($all);

?>