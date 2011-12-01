<?php
/**
 * Description of modules
 *
 * @author Bogdan
 */
class clsModules {
    private $module;
    
    public function clsModules() {
        global $SETTINGS;
        
        $this->module = (isset($_GET['run']) ? $_GET['run'] : null);
        
        if(strlen($this->module) == 0 || !file_exists($SETTINGS['MODULES_DIR'].'/'.$this->module.'/frontend.php'))
            $this->module = $SETTINGS['DEFAULT_MODULE'];
    }
    
    public function run_user() {
        global $SETTINGS;
        
        require_once $SETTINGS['MODULES_DIR'].'/'.$this->module.'/frontend.php';
        $clsModule = new $this->module;
        
        unset($clsModule);
    }
    
    public function run_admin() {
        
        // if -> admin, then ...
        
    }


    public function register($name, $classname) {
        // add module in database.
    }
}

?>
