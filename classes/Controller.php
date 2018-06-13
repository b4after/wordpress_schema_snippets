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
        $this->runRenderers();
    }

    /**
     * 
     */
    private function init_instalation() {

        $Instalator = new Install();
        add_action('plugins_loaded', array($Instalator, 'init'));
    }

    private function runRenderers() {

        global $wpdb;

        $query = 'SELECT * FROM ' . $wpdb->postmeta . ' WHERE `meta_key` = "%s"';


        $sql = $wpdb->prepare($query, array(
            'schema_json'
        ));

        $row = $wpdb->get_results($sql, ARRAY_A);

        foreach ($row as $renderer) {

            $schema = get_post_meta($renderer['post_id'], 'schema_json', true);
            $scopes = unserialize(get_post_meta($renderer['post_id'], 'ba_choosen_scopes', true));
            $Renderer = new Renderer();
            $Renderer->setSchemaID($renderer['post_id']);
            $Renderer->setSchema($schema);
            $Renderer->setScopes($scopes);
        }
    }

}
