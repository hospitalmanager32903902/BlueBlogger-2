<?php include("connect_to_db.php"); 

    $postid = $_GET['post'];
    $sql = "SELECT * FROM `posts` WHERE post_id=$postid LIMIT 1";
    $r = $conn->query($sql);
    $r = $r->fetch_assoc();
    $posttitle = $r["post_title"];
    $postcontent = $r["post_content"];
    $postid = $r["post_id"];
?>
<?php include("header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $posttitle; ?></title>
    <style type="text/css">
    body{
        background:white;
    }
    #content
    {
        width: 55%;
        border-radius:5px;
        background:white;
        border:1px solid #bbb;
        margin: 30px auto;
        line-height: 30px;
        padding:20px;
        box-sizing:border-box;
        transition:.3s linear;
    }
    .content-custom{
        transform: scale(1.01) translateY(50px)!important;
    }
    </style>
</head>
<body>
    <div id="content">
        <h1><?php echo $posttitle; ?></h1>
        <hr style="border: none;border-top: 1.5px solid #03030387;margin: 10px 0px 50px 0px;">
        <div id="blog">
            <?php echo $postcontent; ?>
        </div>
    </div>
    <script type="text/javascript" src="js/post.js"></script>
</body>
</html>