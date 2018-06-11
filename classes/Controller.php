<?php

namespace BeforeAfter\BASRS;

class Controller {

    /**
     *  Singleton 
     * @var type 
     */
    protected static $_instance = null;

    /**
     * Main Instance.
     *
     * Ensures only one instance of BASOS is loaded or can be loaded.
     *
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 
     */
    public function __construct() {
        $this->init_instalation();
    }

    /**
     * 
     */
    private function init_instalation() {

        $Instalator = new Install();
        add_action('plugins_loaded', array($Instalator, 'init'));
        
        
        
        
        
    }

}
