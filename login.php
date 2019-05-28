<?php
     if( session_status() == 1 )
     session_start();
     $doesnotmatch = false;
    if ( isset($_POST["username"]) && isset($_POST["password"]) && strlen($_POST["username"])&& strlen($_POST["password"]) ) {
        include("connect_to_db.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT `user_password` from `users` Where `user_username`='$username' LIMIT 1";
        $r = $conn->query($sql);

        if( $password ==  $r->fetch_assoc()["user_password"] ){
            header("Location:dashboard.php");
            $_SESSION["username"] = $username;
        } else {
            $doesnotmatch = true;
        }

        $conn->close();
    }
?>

<?php include("header.php"); ?>

    <div id="container">
        <div id="content" class="<?php if($doesnotmatch) echo "doesnotmatch" ?>">
            <form action="login.php" method="post">
                <input type="text" name="username" id="username" placeholder="Type User Name " >
                <input type="password" name="password" id="password" placeholder="Type Password " >
                <input type="submit" value="Login">
            </form>
            <button id="signup" onclick="window.location='signup.php'">Sign Up</button>
            <?php 
                if($doesnotmatch){
                    echo "<span style='width:100%;height:50px;display:block;text-align: center;color:purple;font-style:italic;line-height: 50px;'> Try Again With Correct Info </span>";
                } 
            ?>
        </div>
    </div>

</body>
</html>