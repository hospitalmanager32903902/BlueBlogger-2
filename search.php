<?php    
    if( session_status() == 1 ){
        session_start();
    }
    include("connect_to_db.php");

    $searchTerm = $_GET["q"];
    
    $results = array();
    if( strlen($searchTerm) ){
        $sql = "SELECT * FROM posts WHERE post_title LIKE '%$searchTerm%' OR post_excerpt LIKE '%$searchTerm%' OR post_content LIKE '%$searchTerm%' LIMIT 10";
        $result = $conn->query($sql);
        // echo $sql;
        $tmp = array();
        while ( $x =  $result->fetch_assoc() ) {
            array_push($tmp,$x);
        }
        $results = $tmp;
    }
    
?>
<?php include("header.php"); ?>
    
    <div id="container">
        <div id="content">
            <div id="searchBox">
                <input type="text" name="searchkey" onkeypress="enterSearch(event)" id="searchkey" placeholder="Enter Your Search Term and Hit Search" value="<?php echo $searchTerm; ?> ">
                <button onclick="search(this)"  id="searchButton">Search</button>
            </div>
            
            <div id="searchResultBox">
                    <?php
                        foreach( $results as $key ){
                            $title = $key["post_title"];
                            $content = $key["post_content"];
                            $postid = $key["post_id"];
                            $post_publish_date = $key["post_publish_date"];
                            $post_author_username = $key["post_author_username"];
                            echo "  
                                    <div class='matched-item'>
                                        <div style='color:#3e3e3e; font-style:italic; font-size:12.5px; position:absolute;top:1px; right:5px;'>$post_publish_date</div>
                                        <div class='matched-content-item'>
                                            <a href='post.php?post=$postid'><div class='post-title'>$title</div></a> - <a href='user.php?username=$post_author_username' style=' font-style:italic; font-size:13px; color:#3e3e3e;'>$post_author_username</a>
                                            <p class='post-content'>$content</p>
                                        </div>
                                        <span class='show-more' onclick='showMore(this)'>Show More ↓↓↓ </span>
                                    </div>
                                ";
                            }
                    ?>
            </div>

        </div>
    </div>
    <script type="text/javascript" src="js/search.js"></script>
    <script type="text/javascript" src="js/bblibrary.js"></script>
</body>
</html>