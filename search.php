<?php    
    if( session_status() == 1 ){
        session_start();
    }
    include("connect_to_db.php");

    $searchTerm = $_GET["q"];
    
?>
<?php include("header.php"); ?>
    
    <div id="container">
        <?php
            echo $searchTerm;
        ?>
    </div>
    <script type="text/javascript" src="js/post.js"></script>
    <script type="text/javascript" src="js/bblibrary.js"></script>
</body>
</html>