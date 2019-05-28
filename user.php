<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
    if( !isset($_SESSION["username"]) ){
        header("Location:login.php");
    }
    
?>
<?php  include("header.php"); ?>

        <div id="container">
            <div id="userdetail"  style="margin-bottom:50px;padding-bottom:10px;width: 520px;background:white;border:1px solid #72541d54;padding:20px;margin:10px;margin-left: 40%;box-shadow: inset 0px 0px 100px 100px white;;">
            <?php include("connect_to_db.php");
                $username = $_SESSION["username"];
                $r = $conn->query("SELECT * FROM `users` WHERE `user_username`='$username' ");
                $row = $r->fetch_assoc();
                $i = 1;
                foreach ($row as $key => $value) {
                    $key = strtoupper(explode("_",$key)[1]);
                    if ($key == "PASSWORD") {
                        $value = "****";
                    } elseif ($key == "BLOODGROUP") {
                        $key = "BLOOD GROUP";
                        $value = strtoupper($value);
                    } elseif ($key == "FULLNAME") {
                        $key = "NAME ";
                        $value = strtoupper($value);
                    }
                    echo "<div class='user-detail-element' onmouseover='showedit(this)' onmouseout='hideedit(this)'><strong>$i. $key : </strong> <span class='value'>". $value . '</span><span onclick="edit_user_detail_field(this)" id="edit-detail"><svg viewBox="0 0 24 24" id="ic_edit_24px" width="100%" height="100%"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></span></div>'; $i++;
                }

            ?>
            </div>
        </div>

<script type="text/javascript" src="js/user.js">
   
</script>
</body>
</html>
