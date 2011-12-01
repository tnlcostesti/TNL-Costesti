<?php
    /** include important files
     * @todo Baze de date, engine module, setari.
     */
    session_start();
    require_once 'includes/template.php';
    require_once 'includes/cache_p.php';
    require_once 'includes/modules.php';
    require_once 'includes/settings.php';
    
    $template   = new clsTinyButStrong;
    
    
    $chpname    = $_SERVER['REQUEST_URI'];
    $chpname   .= "_" . session_id();
    $chpname    = substr($chpname, 1, strlen($chpname));
    if($_POST == NULL) {
        $dirarr = explode('/', $chpname); $prev = './cache/'; $i = 0;
        while($i < sizeof($dirarr)) {
            if(!is_dir($prev)) mkdir($prev);
            $prev .= $dirarr[$i] . "/";
            $i++;
        }
        $template->PlugIn(TBS_INSTALL, TBS_CACHE, './cache', '*.tmp');
        $template->PlugIn(TBS_CACHE, $chpname, 3); // salvez in cache pentru 5 minute
    }
    else {
        $template->PlugIn(TBS_INSTALL, TBS_CACHE, './cache', '*.tmp');
        $template->PlugIn(TBS_CACHE, $chpname, TBS_CACHEDELETE);
    }
    
    // baze de date.
    $dbLink = @mysql_connect($DB['host'], $DB['user'], $DB['pass']);
    if(!$dbLink) error("Serverul MySQL nu mai stie sa raspunda :-<");
    
    $seldb = @mysql_select_db($DB['name'], $dbLink);
    if(!$seldb) error("Cred ca baza de date a fost stearsa :-s");
    
    // module
    $modules    = new clsModules;
    
    $modules->run_user();
    $template->LoadTemplate('themes/default/theme.html');
    
    mysql_close($dbLink);
    $template->Show(true);
    
    //print_r(memory_get_usage() / (1024 * 1024));
    function error($error) {
        global $template, $chpname, $SITE;
        
        $template->LoadTemplate('themes/default/error.html');
        $SITE['CONTENT'] = $error;
        
        // if cache then =>
        $template->PlugIn(TBS_CACHE, $chpname, TBS_CACHECANCEL);
        $template->PlugIn(TBS_CACHE, $chpname, TBS_CACHEDELETE);
        
        $template->Show(false);
        
        die();
    }
?>