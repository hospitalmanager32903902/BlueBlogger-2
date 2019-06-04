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
    if( isset($_POST["operation"]) && $_POST["operation"] == "updatefield" && isset($_POST["newvalue"]) && isset($_POST["fieldname"])  ){

        $user_username = $_SESSION["username"];
        $newvalue = $_POST["newvalue"];
        $fieldname = $_POST["fieldname"];
        $sql = "UPDATE `users` SET `$fieldname`='$newvalue' WHERE `user_username`='$user_username'";
        $r = $conn->query( $sql );
        if($r){
            echo "Profile Updated";
        } else {
            echo "Profile Not Updated. sql=$sql";
        }
        if( $fieldname == "user_username" ){            
            $sql = "UPDATE `posts` SET `post_author_username`='$newvalue' WHERE `post_author_username`='$user_username'";
        }  

        $r = $conn->query( $sql );
        if($r && $fieldname == "user_username" ){
            $_SESSION["username"] = $newvalue;
            echo "username has been updated in posts table";
        } else {
            echo "username has NOT been updated in posts table. sql=$sql";
        }
    } 
   

?>