<?php

namespace BeforeAfter\BASRS;

/**
 * Renders schemas in particular pages
 */
class Renderer {

    /**
     *  Holds up post->ID for each schema cpt
     * @var type 
     */
    private $schemaID;

    /**
     * Holds up json with schema
     * @var type 
     */
    private $schema;

    /**
     * Holds up scopes for each schema
     * @var type 
     */
    private $scopes;

    public function __construct() {
        add_action('wp_footer', [$this, 'renderInFooter']);

        $this->init();
    }

    public function init() {


//        debug($this->getSchemaID());
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

        print_r($this->getScopes());
        echo $this->getSchema();
        echo $this->getSchemaID();
    }

    /**
     * Gets schema from DB based on given post_ID
     * @param type $schemaID
     * @return type
     */
    public function getSchemaID() {

        return $this->schemaID;
    }

    /**
     * 
     * @param type $schemaID
     */
    public function setSchemaID($schemaID) {
        $this->schemaID = $schemaID;
    }

    /**
     * 
     * @return type
     */
    public function getSchema() {

        return $this->schema;
    }

    /**
     * 
     * @param type $schema
     */
    public function setSchema($schema) {

        $this->schema = $schema;
    }

    function getScopes() {
        return $this->scopes;
    }

    function setScopes($scopes) {
        $this->scopes = $scopes;
    }

}
