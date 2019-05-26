<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
    if( !isset($_SESSION["username"]) ){
        header("Location:login.php");
    }
    
?>
<?php  include("connect_to_db.php"); ?>
<?php  include("header.php"); ?>

<script src="js/user.js"></script>
</body>
</html>
