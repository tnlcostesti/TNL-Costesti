<?php

class site {
    public function site() {
        global $SITE;
        $SITE['TITLE'] .= "Acasa";
        $SITE['CONTENT'] .= "<p>Hello World!</p>";
    }
}

?>
