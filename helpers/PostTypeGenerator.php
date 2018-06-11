<?php

/**
 * Author : Mateusz Grzybowski
 * grzybowski.mateuszz@gmail.com
 */

namespace BeforeAfter\BASRS\Helpers;

class PostTypeGenerator {

    private $name;
    private $translate = array();

    public function __construct() {
        
    }

    /**
     * Setter for creating CPT
     * @param type $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Setter for CPT
     * @param array $translate
     */
    public function setTranslate(array $translate) {
        $this->translate = $translate;
    }

    /**
     * Getter for Name
     * @return type
     */
    function getName() {
        return $this->name;
    }

    /**
     *  Getter for translates 
     * @return type
     */
    function getTranslate($kind) {

        if ($this->translate) {
            $translate = $this->translate[$kind];
        }
        else {
            $demoLabels = [
                'single' => __('item'),
                'plural' => __('items'),
            ];

            $translate = $demoLabels[$kind];
        }

        return $translate;
    }

    public function register_posttype() {

        $labels = array(
            'name' => sprintf(__('%s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'singular_name' => sprintf(__('%s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'menu_name' => sprintf(__('%s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'name_admin_bar' => sprintf(__('%s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'add_new' => sprintf(__('New %s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'add_new_item' => sprintf(__('New %s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'new_item' => sprintf(__('New %s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'edit_item' => sprintf(__('Edit %s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'view_item' => sprintf(__('View %s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'all_items' => sprintf(__('All %s', 'b4after-' . $this->getName()), $this->getTranslate('plural')),
            'search_items' => sprintf(__('Search %s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'parent_item_colon' => sprintf(__('Parent %s', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'not_found' => sprintf(__('%s not found', 'b4after-' . $this->getName()), $this->getTranslate('single')),
            'not_found_in_trash' => sprintf(__('%s not found in trash', 'b4after-' . $this->getName()), $this->getTranslate('single')),
        );
        //wont show while public parameter is set to false
//        $rewrite = array(
//            'slug' => $this->getTranslate('plural'),
//            'with_front' => true,
//            'pages' => true,
//            'feeds' => true,
//        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => false,
            'supports' => array('title'),
            'menu_icon' => 'dashicons-megaphone',
            'menu_position' => 99999,
        );

        register_post_type($this->getName(), $args);

        add_shortcode($this->getName(), array($this, 'generate_base_shortcode'));


        //Add new column
        add_filter('manage_' . $this->name . '_posts_columns', array(
            $this,
            'columns_header',
                ), 10);

        //Removes default column
        add_filter('manage_' . $this->name . '_posts_columns', array(
            $this,
            'remove_defaults',
                ), 10);

        //Add content to new columns
        add_action('manage_' . $this->name . '_posts_custom_column', array(
            $this,
            'columns_content',
                ), 10, 2);
    }

    /**
     * Add custom headers
     *
     * @param type $defaults
     *
     * @return string
     */
    function columns_header($defaults) {
        //    $defaults['miniatura'] = 'miniatura';
        $defaults['shortcode'] = 'Shortcode';


        return $defaults;
    }

    /**
     * Remove default fields from CAR LIST
     *
     * @param type $defaults
     *
     * @return type
     */
    function remove_defaults($defaults) {

        //    unset($defaults['title']);
        unset($defaults['date']);

        return $defaults;
    }

    /**
     * Add custom value's
     *
     * @param type $column_name
     * @param type $post_ID
     */
    function columns_content($column_name, $post_ID) {

        if ($column_name == 'shortcode') {
//			echo '['.$this->name.' id="'.$post_ID.'"]';
            echo "<input type='text' onfocus='this.select();' readonly='readonly' value='[$this->name id=\"$post_ID\"]' class='large-text code' style='line-height: 1.7;'>";
        }
    }

    function generate_base_shortcode($atts) {


        $arg = shortcode_atts(array(
            'id' => 0,
                ), $atts);

        if ($arg['id'] == false) {
            $response = sprintf(__('You must enter name of %s'), $this->getTranslate('single'));
        }
        else {
            $response = $arg['id'];
        }
        return $response;
    }

}
