<?php include("connect_to_db.php"); 

    $postid = $_GET['post'];
    $sql = "SELECT * FROM `posts` WHERE post_id=$postid LIMIT 1";
    $r = $conn->query($sql);
    $r = $r->fetch_assoc();
    $posttitle = $r["post_title"];
    $postcontent = $r["post_content"];
    $postid = $r["post_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $posttitle; ?></title>
    <style type="text/css">
    body{
        background:#000000cc;
    }
    #content
    {
        width: 55%;
        border-radius:5px;
        background:white;
        margin: 30px auto;
        line-height: 30px;
        padding:20px;
        box-sizing:border-box;
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
    <script type="text/javascript">
        window.onload = ()=>{
            var blog = document.querySelector("#blog").innerText;
            blog = blog.split("").map((char)=>{
                if ( char.charCodeAt() == '�'.charCodeAt() ){                    
                    //console.log(char);
                    return "'";
                } else {
                    return char;
                }
            });
            document.querySelector("#blog").innerText = blog.join("");
        }
    </script>
</body>
</html>