<?php

namespace BeforeAfter\BASRS;

class Install {

    private $SchemaCPT = 'ba_schema_cpt';

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
        $SchemaPostType->setName($this->SchemaCPT);
        $SchemaPostType->setTranslate($schema_translate);
        $SchemaPostType->register_posttype();

        $Metabox = new Metabox();
        $Metabox->setCpt($this->SchemaCPT);
        $Metabox->setName('Schema Rich Snippets');
        add_action('save_post_'.$this->SchemaCPT, array($Metabox, 'save_metabox'));
        add_action('add_meta_boxes', array($Metabox, 'register_metabox'));
    }

}
