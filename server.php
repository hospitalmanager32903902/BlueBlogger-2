<?php

    session_start();
    foreach ($_SESSION as $key => $value) {
        echo "<div>
                <strong>$key</strong> : $value <br><br>
            </div>";
    }

?>