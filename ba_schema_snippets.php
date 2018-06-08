<?php

/**
 * Plugin Name: Before / After: Schema.org Rich snippets
 * Author: Before / After
 * Author URI: http://www.b4after.pl/
 * Description: System do dodawania znaczników schema
 * Plugin URI: http://www.b4after.pl
 * Version: 1.0
 * License: GPLv2
 * Text Domain: BASRS
 * Domain Path: /languages
 */

require_once( 'vendor/autoload.php' );


class BA_SchemaSnippets {

    public $version = '1.0.0';

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

        do_action('init_BA_schema');
        
        $this->define_constants();

        $this->load_textdomain();

//        $this->controller();
//        add_action('plugins_loaded', array(new BeforeAfter\BASCS\Install(), 'init',));
    }

    /**
     * Define constants used in plugin
     */
    public function define_constants() {

        define('BASRS_PLUGIN_FILE', __FILE__);

        define('BASRS_ABSPATH', dirname(__FILE__) . '/');

        define('BASRS_VERSION', $this->version);

        define('BASRS_PATH', plugin_dir_path(__FILE__));

        define('BASRS_URL', plugin_dir_url(__FILE__));
    }

    /**
     * Makes plugin translable
     */
    public function load_textdomain() {

        /**
         * BASRS - BeforeAfterSchemaRichSnippets
         */
        load_plugin_textdomain('BASRS', false, basename(dirname(__FILE__)) . '/languages/');
    }

}

$Snippets = BA_SchemaSnippets::instance();
