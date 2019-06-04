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
        if( $password ==  $r->fetch_assoc()["user_password"] ){            
            $_SESSION["username"] = $username;
            $sql = "SELECT *  from `users` Where `user_username`='$username' LIMIT 1";
            $r = $conn->query($sql);
            echo json_encode($r->fetch_assoc());
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
                <label for="username">Enter Your User Name </label>
                <input type="text" name="username" id="username" placeholder="Type User Name " >
                <label for="password">Enter Your Password  </label>
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