<?php
    if( session_status() == 1 )
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css" />
    <title>Blue Blogger</title>
</head>
<body>
    <header id="header">
        <div id="headerPoster"></div>
        <nav id="navbar">
            <?php
              if( isset($_SESSION["username"]) ){
                echo "<a href='dashboard.php' title='Dashboard Page'>Dashboard</a>";
              }  else {                  
                echo "<a href='login.php'>Login</a>";
              }
            ?>
            <?php
                $pageName = explode("/",$_SERVER["PHP_SELF"]);
                if( $pageName[count($pageName)-1] == "user.php"){
                    echo '
                        <div id="rightNav">
                            <span id="notification">
                                <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 100%; height: 100%;">
                                    <g class="style-scope yt-icon">
                                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" class="style-scope yt-icon">
                                        </path>
                                    </g>
                                </svg>
                            </span>
                        </div>';
                } else {
                    echo '
                    <div id="rightNav">
                        <span id="notification" title="notifications">
                            <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 100%; height: 100%;">
                                <g class="style-scope yt-icon">
                                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" class="style-scope yt-icon">
                                    </path>
                                </g>
                            </svg>
                        </span>
                        <a href="user.php">
                            <span id="profile" title="Click to go to Profile Page">

                            </span>
                        </a>
                    </div>';
                }

            ?>
        </nav>
    </header>

    