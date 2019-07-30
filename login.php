<?php
     if( session_status() == 1 )
     session_start();
     $doesnotmatch = false;
    if ( isset($_POST["operation"]) && $_POST["operation"]=="homepagesidebarlogin" && isset($_POST["username"]) && isset($_POST["password"]) && strlen($_POST["username"]) && strlen($_POST["password"]) ) {
        include("connect_to_db.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT `user_password` from `users` Where `user_username`='$username' LIMIT 1";
        $r = $conn->query($sql);
        $fetched_pass = $r->fetch_assoc()["user_password"];
        if( password_verify($password, $fetched_pass) ){            
            $_SESSION["username"] = $username; 
            $sql = "SELECT *  from `users` Where `user_username`='$username' LIMIT 1";
            $r = $conn->query($sql)->fetch_assoc();
            $_SESSION["user_roll"] = $r["user_roll"];
            echo json_encode($r);
        } else {
            echo "login failed";
        }
        $conn->close();
        exit(0);
    }
?>

<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
     if( session_status() == 1 )
        session_start();
    if( isset($_SESSION["username"]) ){
        header("Location:profile.php");
    }
    
?>



<?php
     if( session_status() == 1 )
     session_start();
     $doesnotmatch = false;
    if ( isset($_POST["username"]) && isset($_POST["password"]) && strlen($_POST["username"]) && strlen($_POST["password"]) ) {
        include("connect_to_db.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT * from `users` Where `user_username`='$username' LIMIT 1";
        $r = $conn->query($sql)->fetch_assoc();
        $fetched_pass = $r["user_password"];
        $user_roll = $r["user_roll"];
        if( password_verify($password, $fetched_pass) ){
            header("Location:dashboard.php");
            $_SESSION["username"] = $username;
            $_SESSION["user_roll"] = $user_roll;
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
                <label for="username">User Name </label>
                <input type="text" name="username" id="username" placeholder="Type User Name " >
                <label for="password">Password  </label>
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