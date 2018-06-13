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
        add_action('wp_footer', [$this, 'render']);

//        $this->init();
    }
    /**
     * 
     */
    public function render() {

        $scopes = $this->getScopes();
//        debug($this->schemaID);
//        debug($this->schema);
//        debug($this->scopes);
//        debug($scopes);
        if (!empty($scopes)) {

            foreach ($scopes as $key => $scope) {
                /**
                 * Case for taxonomies and categories
                 */
//                debug($scope);
                if ($scope === 'tax') {

                    foreach ($scopes['ids']as $tax) {
                        /*
                         * Is taxonomy custom with name $tax
                         */
                        if (is_tax($tax)) {
                            echo $this->getSchema();
                        }
                        /**
                         * Is Wordpress custom category
                         */
                        elseif (is_category()) {
                            echo $this->getSchema();
                            break;
                        }
                    }
                }
                if ($scope === 'post') {

                    foreach ($scopes['ids'] as $post_ID) {
                        /**
                         * Is single post - blog post
                         */
                        if (is_single($post_ID)) {
                            echo $this->getSchema();
                        }
                        /**
                         * Is single page
                         */
                        elseif (is_page($post_ID)) {
                            echo $this->getSchema();
                        }
                    }
                }
                if ($scope === 'cpt') {
                    foreach ($scopes['ids'] as $cpt) {
                        if (is_singular($cpt)) {
                            echo $this->getSchema();
                        }
                    }
                }
            }
        }

       
    }

    public function checkScope() {
        
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
        
        $html = '<!--/ B4after Schema Plugin /-->';
        $html .= '<script type="application/ld+json">' . $this->schema . '</script>';
        $html .= '<!--/ B4after Schema Plugin /-->';
       
        return $html;
    }

    /**
     * 
     * @param type $schema
     */
    public function setSchema($schema) {

        $this->schema = $schema;
    }

    function getScopes() {
        $scopes = [];
        /**
         * Sort IDs
         */
        if (!empty($this->scopes && $this->scopes)) {
            foreach ($this->scopes as $key => $scope) {
                $scopes['scope'] = explode('|', $scope)[0];
                $scopes['ids'][] = explode('|', $scope)[1];
            }
        }




        return $scopes;
    }

    function setScopes($scopes) {
        $this->scopes = $scopes;
    }

}
