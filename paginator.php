 <?php
    if ( $postCount > $postPerPage ) {
        $pageNeeded = ($postCount % $postPerPage) > 0 ? 1 : 0;
        $pageNeeded += (int)($postCount / $postPerPage);
        $tmp = "";
        for ($i=1; $i <= $pageNeeded; $i++) {                 
            if( $page == $i) {
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
                    <div class='pagelinks'> ❮ </div>
                </a>
                $tmp
                <a href='index.php?page=$nextPage'>
                    <div class='pagelinks'> ❯ </div>
                </a>
            </div>"; 
    }
?>