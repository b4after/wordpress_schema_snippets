<?php

namespace BeforeAfter\BASRS;

class Metabox {

    private $name;
    private $cpt;
    private $schema;

    /**
     * Gets name of Metabxx
     * @return type
     */
    function getName() {

        /**
         * Sets default name if nothing is given
         */
        if (!$this->name) {
            $name = __('Choose schema snippet', 'BASRS');
        }
        else {
            $name = $this->name;
        }
        return $name;
    }

    /**
     * Sets name of Metabxx
     * @param type $name
     */
    function setName($name) {
        $this->name = $name;
    }

    /**
     * gets name for Custom Post type
     * @return type
     */
    function getCpt() {
        /**
         * Sets default name if nothing is given
         */
        if (!$this->cpt) {
            $cpt = 'ba_schema_cpt';
        }
        else {
            $cpt = $this->cpt;
        }
        return $cpt;
    }

    /**
     * Sets name of current using custom post type
     * @param type $cpt
     */
    function setCpt($cpt) {
        $this->cpt = $cpt;
    }

    /**
     * Registers metabox on blog post screen
     */
    public function register_metabox() {

        add_meta_box('schema_screen', __('Choose screen to show schema'), array($this, 'choose_screen'), $this->getCpt(), 'normal', 'high');

        add_meta_box('schema_metabox', __('Choose schema type'), array($this, 'choose_schema'), $this->getCpt(), 'normal', 'high');
    }

    /**
     * 
     * Metabox displays list of aviable screens to show snippet
     * 
     */
    public function choose_screen() {

        echo 'choose_screen';
    }

    /**
     * select box for all aviable schemas
     */
    public function choose_schema() {
        global $post;
        $h = '';
        $Schema = new Schema();
        $schemas = $Schema->getSchemas();

        /**
         * Gets value by $post->ID and meta_key
         */
        $choosenSchema = get_post_meta($post->ID, 'ba_choosen_schema', true);
        $h .= '<div>';
        /**
         * Renders select to choose searched schema
         */
        if (!empty($schemas)) {
            $h .= '<label>' . __('Schema type') . '</label>';
            $h .= '<select name="ba_choosen_schema">';
            $h .= '<option value="0">' . __('---') . '</option>';
            foreach ($schemas as $schema) {

                $h .= '<option value="' . sanitize_title($schema['name']) . '" ' . selected($choosenSchema, sanitize_title($schema['name']), false) . ' >' . $schema['name'] . '</option>';
            }
            $h .= '</select>';
        }

        $this->schema = $Schema->getSchema($choosenSchema);


        $h .= '</div>';
        $h .= '<div>';
        $h .= $this->getSchemaInputs();
        $h .= '</div>';


        echo $h;
    }

    /**
     * 
     * @param type $inputs
     */
    private function getSchemaInputs() {
        $config = $this->schema['schema'];
        $h = '';

        if (empty($config)) {
            return;
        }

        foreach ($config as $field) {

            $h .= 'ddd';
        }


        return $h;
    }

    /**
     * Triggers on save_post action
     *
     * @param $post_ID
     */
    public function save_metabox($post_ID) {
        //TODO: wp nonce

        if (empty($_POST) || !isset($_POST)) {
            return;
        }

        update_post_meta($post_ID, 'ba_choosen_schema', $this->get_param('ba_choosen_schema'));
    }

    /**
     * Safe returns POST or GET params
     * @param $param
     *
     * @return string|void
     */
    public function get_param($param) {

        if (isset($_POST[$param])) {
            return esc_attr($_POST[$param]);
        }
        elseif (isset($_GET[$param])) {
            return esc_attr($_GET[$param]);
        }
        else {
            return esc_attr($param);
        }
    }

}
