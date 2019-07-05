<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
    if( !isset($_SESSION["username"]) ){
        header("Location:login.php");
    }
    // fetch user profile data
    include("connect_to_db.php");
    $username = $_SESSION["username"];
    $r = $conn->query("SELECT * FROM `users` WHERE `user_username`='$username' ");
    $row = $r->fetch_assoc();
    $i = 1;
?>

<?php  include("header.php"); ?>

        <div id="container">
            <div id="leftside">
                <div id="prfile-pic" >
                    <img style="border:3px solid white; width:inherit; height:120px;" src="img/profilepic/<?php echo $row["user_profile_picture_link"]; ?>" alt="">
                    <div id="prfile-pic-caption"><?php echo $row["user_fullname"]; ?></div>
                </div>
            </div>
            <div id="userdetail">
            <?php 
                foreach ($row as $key => $value) {
                    if( $key == "user_id" || $key == "user_profile_picture_link" || $key == "user_comment_count" || $key == "user_post_count" ){
                        continue;
                    }
                    $tmpkey = $key;
                    $key = strtoupper(explode("_",$key)[1]);
                    if ($key == "PASSWORD") {  // if it is password make it invisible
                        $value = "****";
                    } elseif ($key == "BLOODGROUP") {   // if it is BLOODGROUP make it uppercased
                        $key = "BLOOD GROUP";
                        $value = strtoupper($value);
                        if( !stripos($value,"-") ){
                            $value = $value . "+";
                        }
                    } elseif ($key == "FULLNAME") {
                        $key = "NAME ";
                        $value = strtoupper($value);
                    }
                    echo "<div data-field-name='$tmpkey' class='user-detail-element' onmouseover='showedit(this)' onmouseout='hideedit(this)'><strong >$i. $key : </strong> <span class='value'>". $value . '</span><span title="click to edit" onclick="edit_user_detail_field(this)" id="edit-detail"><svg viewBox="0 0 24 24" id="ic_edit_24px" width="100%" height="100%"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></span></div>'; $i++;
                }

            ?>
            </div>
        </div>

    <script type="text/javascript" src="js/profile.js"></script>
    <script type="text/javascript" src="js/bblibrary.js"></script>
</body>
</html>
