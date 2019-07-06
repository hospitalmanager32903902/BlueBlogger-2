
<?php
    // Check if user logged in if yes
    // continue otherwise redirect to login page
    session_start();
    if( !isset($_SESSION["username"]) ){
        header("Location:login.php");
    }
?>

<?php require_once("connect_to_db.php");
    
    if ( isset($_POST["operation"]) && $_POST["operation"] == "updatepost" ) {
        $user = "'".$_SESSION["username"]."'";
        // setting all the attributes for new post
        $post_title = addslashes( $_POST["post_title"] );
        $post_content = addslashes( htmlentities($_POST["post_body"]) );
        $post_excerpt = addslashes( htmlentities($_POST["post_excerpt"]) );        
        $post_author_username = $_SESSION["username"];
        $post_id = $_POST["post_id"];
        $post_thumbnail = "img/post_image/"."post_".$post_id."_thumpic.jpg";
        $post_thumbnail_name = "post_".$post_id."_thumpic.jpg";
        if( isset($_FILES["post_thumnail"]) ){
            move_uploaded_file( $_FILES["post_thumnail"]["tmp_name"],$post_thumbnail );
        }
        $sql = "UPDATE `posts` SET post_thumbnail='$post_thumbnail_name', post_title='$post_title', post_excerpt='$post_excerpt', post_content='$post_content' WHERE post_id=".$post_id;    
        $r = $conn->query($sql);
        if( $r ){
            echo "updated";
        } else {
            echo "Something went worng";
        }
        exit(0);
    }
?>


<?php
    $user = $_SESSION["username"];
    $post_id = $_GET["postid"];
    $sql = "SELECT post_author_username FROM `posts` WHERE post_id=".$post_id;
    $post_author_username = $conn->query($sql)->fetch_assoc()["post_author_username"];
    if( $user == $post_author_username ){
        $sql = "SELECT * FROM `posts` WHERE post_id=".$post_id;
        $r = $conn->query($sql)->fetch_assoc();
    } else {
        header("Location:index.php");
    }
?>


<?php include("header.php"); ?>

    <div id="createnewpost-toolbox">
        <div id="Publish" onclick="update()">Update</div>
        <div id="Cancel" onclick="cancel()">Cancel</div>
    </div>
    <div id="container">
        <div id="createnewpost">
            <div id="upper">
                <div id="tumbnailupload" onclick="document.querySelector('#postthumbnail').click()">
                    <img src="img/post_image/<?php echo $r["post_thumbnail"]; ?>" width="100%" height="100%" alt="" id="thumbpic">
                    <input type="file" name="postthumbnail" id="postthumbnail" onchange="showThumb()">
                </div>
                <div id="excerpt">
                    <label for="post_excerpt">Write An Excerpt of Your Post</label>
                    <textarea name="post_excerpt" id="post_excerpt" cols="50" rows="6" placeholder="Smaller the Better ">
                        <?php 
                            echo $r["post_excerpt"];
                        ?>
                    </textarea>
                </div>
            </div>
        </div>
        <div id="lower">
            <div id="posttitle">
                <label for="post_title">Write a Title of Your Post </label>
                <textarea name="post_title" id="post_title" cols="35" rows="2" placeholder="Add Title of Your Post ">
                    <?php 
                        echo $r["post_title"];
                    ?>
                </textarea>
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
                    <?php 
                        echo $r["post_content"];                
                    ?>
                </textarea>
            </div>
        </div>
    </div>

        <script src="js/bblibrary.js"></script>
        <script src="js/editpost.js"></script>

<?php include_once("footer.php") ?>