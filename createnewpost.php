<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
    if( !isset($_SESSION["username"]) ){
        header("Location:login.php");
    }
    
?>
<?php include("header.php"); ?>

    <div id="container">
        
    </div>

    <script src="js/createnewpost.js"></script>
</body>
</html>