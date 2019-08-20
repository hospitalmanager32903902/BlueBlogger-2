 <?php
    if ( $postCount > $postPerPage ) {
        $pageNeeded = ($postCount % $postPerPage) > 0 ? 1 : 0;
        $pageNeeded += (int)($postCount / $postPerPage);
        $tmp = "";
        $nextdisplayOrNot = "";
        $prevdisplayOrNot = "";
        if( $page <= 5 ){
            $start = 1;
            $end = $pageNeeded < 10 ? $pageNeeded : 10;
        } else {            
            $start = $page - 4;
            $end = $start + 9;
            if( $end >= $pageNeeded ){
                $end = $pageNeeded;
            }
        }

        if ( $page > $pageNeeded-5) {
            $end = $pageNeeded;
            $start = $pageNeeded - 9;
        }
        if( $page == $pageNeeded ) {            
            $end = $pageNeeded;
            $start = $pageNeeded - 10;
        }

        if( $page == $pageNeeded ){            
            $nextdisplayOrNot = "display:none";
        }
        if( $page == 1 ){            
            $prevdisplayOrNot = "display:none";
            $end += 1;
        }
        if( $pageNeeded < 10 ){
            $nextdisplayOrNot = "display:none";
            $prevdisplayOrNot = "display:none";
            $start = 1;
            $end = $pageNeeded;
        }

        for( $i=$start; $i <= $end; $i++ ) {
            if( $page == $i ) {
                $active = "active";
            } else {
                $active = "";
            }
            $tmp .= "<a href='index.php?page=$i'>
                        <div class='pagelinks $active'>$i</div>
                    </a>";
        }
        if ( $pageNeeded == $page ) {
            $nextPage = $page;
        } else {
            $nextPage = $page + 1;
        } 
        if ( $page == 1 ) {                
            $prevPage = 1;
        } else {
            $prevPage = $page - 1;
        }
        echo 
            "<div id='paginator'>
                <a href='index.php?page=$prevPage'>
                    <div class='pagelinks' style='$prevdisplayOrNot'> ❮ </div>
                </a>
                $tmp
                <a href='index.php?page=$nextPage'>
                    <div class='pagelinks' style='$nextdisplayOrNot'> ❯ </div>
                </a>
            </div>"; 
    }
?>