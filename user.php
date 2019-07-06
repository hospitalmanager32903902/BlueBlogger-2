<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    if( session_status() == 1 )
        session_start(); 
    
    include("connect_to_db.php");
    $username = $_GET["username"];
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
            <div id="userdetail"  style="margin-bottom:50px;padding-bottom:10px;width: 480px;background:white;border:1px solid #72541d54;padding:10px;margin:10px;box-shadow: inset 0px 0px 100px 100px white;">
            <?php
                foreach ($row as $key => $value) {
                    if ( $key == "user_password" || $key == "user_profile_picture_link" || $key == "user_id" ) {
                        continue;
                    }
                    $field_name = $key;
                    $key = strtoupper(explode("_",$key)[1]);
                    if ($key == "PASSWORD") {
                        $value = "****";
                    } elseif ($key == "BLOODGROUP") {
                        $key = "BLOOD GROUP";
                        $value = strtoupper($value);
                        if( !stripos($value,"-") ){
                            $value = $value . "+";
                        }
                    } elseif( $key != "USERNAME" ){
                        $value  = ucfirst($value);
                    }
                    echo "<div data-field-name='$field_name' class='user-detail-element' ><strong >$i. $key : </strong> <span class='value'>". $value . '</span><span title="click to edit" id="edit-detail"></span></div>'; 
                    $i++;
                }

            ?>
            </div>
        </div>

    <script type="text/javascript" src="js/user.js"></script>

<?php include_once("footer.php") ?>
