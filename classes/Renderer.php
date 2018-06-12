<?php

namespace BeforeAfter\BASRS;

/**
 * Renders schemas in particular pages
 */
class Renderer {

    private $schemaID;

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

    public function __construct() {
        add_action('wp_footer', [$this, 'renderInFooter']);

        $this->init();
    }

    private function getScopes() {
//        global $wpdb;
//
//        $query = 'SELECT * FROM ' . $wpdb->postmeta . ' WHERE `meta_key` = "%s"';
//
//
//        $sql = $wpdb->prepare($query, array(
//            'ba_srs_choosen_scope'
//        ));
//
//        $row = $wpdb->get_results($sql, ARRAY_A);
//
//
//
//        return $row;
    }

    public function init() {

        debug($this->getSchemaID());

//        $scopes = $this->getScopes();
//
//        foreach ($scopes as $scope) {
//            $schema = $this->getSchema($scope['post_id']);
//            $types = unserialize(get_post_meta($scope['post_id'], 'ba_srs_choosen_scope', true));
//
//
//            foreach ($types as $key => $value) {
//
//                $data = explode('|', $value);
////                debug($data[1]);
//
//                $this->type = $data[0];
//                if ($data[0] === 'post') {
//                    $postID = $data[1];
//                    $this->IDs[] = $postID;
//                }
//            }
//        }
    }

    public function renderInFooter() {

//        if ($this->type === 'post') {
//            if (in_array(get_the_ID(), $this->IDs)) {
//                debug($this->IDs);
//            }
//        }

        echo 'test';
    }

    private function getType($scope) {

//        $types = debug($types);
    }

    /**
     * Gets schema from DB based on given post_ID
     * @param type $schemaID
     * @return type
     */
    private function getSchemaID() {
//        if (!$schemaID) {
//            return;
//        }
//        $schema = get_post_meta($schemaID, 'schema_json', true);
//
//
        return $this->schemaID;
    }

    public function setSchemaID($schemaID) {
        $this->schemaID = $schemaID;
    }

}
