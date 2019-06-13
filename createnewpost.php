<?php

    if ( isset($_POST["operation"]) && $_POST["operation"] == "createnewpost" ) {
        // var_dump($_FILES);
        // var_dump($_FILES["post_thumnail"]);
        session_start();
        // include db connect file
        include("connect_to_db.php");
        $user = "'".$_SESSION["username"]."'";
        // setting all the attributes for new post
        $post_title = $_POST["post_title"];
        $post_id = (int)($conn->query("SELECT MAX(post_id) AS post_id from `posts`")->fetch_assoc()["post_id"]);
        $post_id++;
        $post_content = $_POST["post_body"];
        $post_excerpt = $_POST["post_excerpt"];
        $post_author_id = $conn->query("SELECT `user_id` FROM `users` WHERE `user_username`=".$user)->fetch_assoc()["user_id"];
        $post_author_username = $_SESSION["username"];
        $post_comment_count = 0;
        $post_visit_count = 0;
        $post_thumbnail = "img/post_image/"."post_".$post_id."_thumpic.jpg";
        $post_thumbnail_name = "post_".$post_id."_thumpic.jpg";
        $post_birthdate = date("d-m-Y");
        $post_publish_date = date("d-m-Y");
        $post_status = "public";
        $post_comment_allowed = "yes";
        $post_number = (int)($conn->query("SELECT `user_post_count` FROM `users` WHERE `user_username`=".$user)->fetch_assoc()["user_post_count"]);
        $post_number++;

        move_uploaded_file($_FILES["post_thumnail"]["tmp_name"],$post_thumbnail);
        $sql = "INSERT INTO `posts`(`post_title`, `post_id`, `post_content`, `post_excerpt`, `post_author_id`, `post_author_username`, `post_comment_count`, `post_visit_count`, `post_thumbnail`, `post_birthdate`, `post_publish_date`, `post_status`, `post_comment_allowed`, `post_number`) VALUES ('$post_title','$post_id','$post_content','$post_excerpt','$post_author_id', '$post_author_username', '$post_comment_count', '$post_visit_count', '$post_thumbnail_name', '$post_birthdate', '$post_publish_date', '$post_status', '$post_comment_allowed', '$post_number')";
        // echo $sql;
        $r = $conn->query($sql);
        if( $r ) {
            $r = $conn->query("UPDATE `users` SET `user_post_count`=$post_number WHERE `user_username`=".$user);
            if( $r ) {
                echo "Successsful";
            }
        }
        

        exit(0);
    }
?>

<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
    if( !isset($_SESSION["username"]) ){
        header("Location:login.php");
    }
    
?>
<?php include("header.php"); ?>

    <div id="createnewpost-toolbox">
        <div id="Publish" onclick="publish()">Publish</div>
        <div id="Draft" onclick="draft()">Draft</div>
        <div id="Cancel" onclick="cancel()">Cancel</div>
    </div>
    <div id="container">
        <div id="createnewpost">
            <div id="upper">
                <div id="tumbnailupload" onclick="document.querySelector('#postthumbnail').click()">
                    <img src="img/choosethumcoverpic.png" alt="" >
                    <label for="tumbnailupload">Choose a Thumbnail</label>
                    <input type="file" name="postthumbnail" id="postthumbnail">
                </div>
                <div id="excerpt">
                    <label for="post_excerpt">Write An Excerpt of Your Post</label>
                    <textarea name="post_excerpt" id="post_excerpt" cols="37" rows="4" placeholder="Smaller the Better "></textarea>
                </div>
            </div>
        </div>
        <div id="lower">
            <div id="posttitle">
                <label for="post_title">Write a Title of Your Post </label>
                <textarea name="post_title" id="post_title" cols="37" rows="2" placeholder="Add Title of Your Post "></textarea>
            </div>
            <div id="postbody">
                <div id="writingtool">
                    <span id="makeBold" class="writing-tool" onclick="makeBold()">B</span>
                    <span id="makeItalic" class="writing-tool"><i>I</i></span>
                    <span id="makeUnderline" class="writing-tool">U</span>
                    <span id="textColor" class="writing-tool"><span></span></span>
                    <span id="justifyText" class="writing-tool"></span>
                    <span id="fontsize" class="writing-tool">16px</span>
                </div>
                <textarea contentEditable="true" id="writing_pad_textversion">
                    
                </textarea>
            </div>
        </div>
    </div>

    <script src="js/createnewpost.js"></script>
    <script src="js/bblibrary.js"></script>
</body>
</html>
