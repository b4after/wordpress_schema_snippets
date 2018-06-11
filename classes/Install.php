<?php

namespace BeforeAfter\BASRS;

class Install {

    /**
     * Constructor
     */
    function __construct() {
        
    }

    /**
     * Adds post types and metaboxes
     */
    public function init() {
        $schema_translate = [
            'single' => __('Schema'),
            'plural' => __('Schemas'),
        ];

        $SchemaPostType = new Helpers\PostTypeGenerator();
        $SchemaPostType->setName('ba_schema_cpt');
        $SchemaPostType->setTranslate($schema_translate);
        $SchemaPostType->register_posttype();
        
        
        
    }

}
