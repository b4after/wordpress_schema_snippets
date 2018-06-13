<?php

namespace BeforeAfter\BASRS;

class Metabox {

    private $name;
    private $cpt;
    private $schema;
    private $metaPrefix = 'ba_srs_';
    private $choosenScope;

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

        add_meta_box('schema_screen', __('Choose screen to show schema', 'basrs'), array($this, 'choose_screen'), $this->getCpt(), 'normal', 'high');

        add_meta_box('schema_metabox', __('Choose schema type', 'basrs'), array($this, 'choose_schema'), $this->getCpt(), 'normal', 'high');
    }

    /**
     * 
     * Metabox displays list of aviable screens to show snippet
     * 
     */
    public function choose_screen() {
        global $post;


        $this->choosenScope = get_post_meta($post->ID, 'ba_choosen_scope', true);
        $screen = new Scope();
        $Scopes = $screen->getScopes();

        $h = '';

        if (!empty($Scopes)) {
            $h .= '<div class="flex_holder">';

            $h .= '<label>' . __('Choose where to show', 'basrs');
            $h .= '<select name="ba_choosen_scope">';

            foreach ($Scopes as $key => $scope) {

                $h .= '<option value="' . $key . '" ' . selected($this->choosenScope, $key, false) . ' >' . ucfirst($key) . '</option>';
            }
            $h .= '</select></label>';

            $h .= '</div>';
            $h .= '<hr>';
            $h .= '<div class="flex_holder scopes">';
            $h .= $this->getScopeInputs();
            $h .= '</div>';
        }
        else {
            $h .= __('Could not find scope list');
        }

        echo $h;
    }

    private function getScopeInputs() {
        global $post;
        $h = '';

        $screen = new Scope();
        $Inputs = $screen->getScope($this->choosenScope);
        $selectedInputs = unserialize(get_post_meta($post->ID, 'ba_choosen_scopes', true));

        debug($selectedInputs);

        if (!empty($Inputs)) {

            foreach ($Inputs as $name => $value) {

                $h .= '<label>' . $value['name'];

                $h .= '<input type="checkbox" name="ba_choosen_scopes[]" value="' . $value['ID'] . '" ' . $this->is_checked($selectedInputs, $value['ID']) . ' >';

                $h .= '</label>';
            }
        }
        else {
            $h .= __('Could not find scope list');
        }




//        $Renderer = new \BeforeAfter\BASRS\Renderer();



        return $h;
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
        $h .= '<div class="flex_holder">';
        /**
         * Renders select to choose searched schema
         */
        if (!empty($schemas)) {
            $h .= '<label>' . __('Schema type', 'basrs');
            $h .= '<select name="ba_choosen_schema">';
            $h .= '<option value="0">' . __('---') . '</option>';
            foreach ($schemas as $schema) {

                $h .= '<option value="' . sanitize_title($schema['name']) . '" ' . selected($choosenSchema, sanitize_title($schema['name']), false) . ' >' . $schema['name'] . '</option>';
            }
            $h .= '</select></label>';
        }
//
        $this->schema = $Schema->getSchema($choosenSchema);
//
//
        $h .= '</div>';
        $h .= '<hr>';
        $h .= '<div class="flex_holder">';
        $h .= $this->getSchemaInputs();
        $h .= '</div>';
//
//
        echo $h;
    }

    /**
     * 
     * @param type $inputs
     */
    private function getSchemaInputs() {
        global $post;
        $config = $this->schema['schema'];
        $h = '';

        if (empty($config)) {
            return;
        }

        foreach ($config as $name => $field) {

            $attr = '';

            if ($field['type'] === 'array') {

                $h .= '<div class="child">';
                $h .= '<h2 class="title">' . $field['placeholder'] . '</h2>';
                $metaVal = unserialize(get_post_meta($post->ID, $this->metaPrefix . $field['name'], true));

//                debug($metaVal);

                foreach ($field['options'] as $option) {
                    /**
                     * Meta val
                     */
//                    $metaVal = get_post_meta($post->ID, $this->metaPrefix . $option['name'], true);

                    $value = $option['default'] ? $option['default'] : $metaVal[$option['name']];

                    $is_readonly = $this->is_blocked($option) === true ? 'readonly' : '';

                    $h .= '<label>' . $option['placeholder'] . '<input type="text" name="' . $this->metaPrefix . $field['name'] . '[' . $option['name'] . ']" value="' . $value . '"' . $is_readonly . '></label>';
                }
                $h .= '</div>';
            }
            /**
             * SELECT
             */
            elseif ($field['type'] === 'select') {

                $metaVal = get_post_meta($post->ID, $this->metaPrefix . $field['name'], true);

                $h .= '<label>' . $field['placeholder'];
                $h .= '<select name="' . $this->metaPrefix . $field['name'] . '">';
                $h .= '<option value="0">---</option>';
                $h .= '<option value="' . $this->schema['name'] . '"' . selected($metaVal, $this->schema['name'], false) . '>' . $this->schema['name'] . '</option>';

                foreach ($field['options'] as $option) {


                    $h .= '<option value="' . $option . '" ' . selected($metaVal, $option, false) . '>' . $option . '</option>';
                }
                $h .= '</select></label>';
            }
            /**
             * TEXT
             */
            elseif ($field['type'] === 'text') {
                $metaVal = get_post_meta($post->ID, $this->metaPrefix . $field['name'], true);

                $value = $metaVal ? $metaVal : $field['default'];

                $is_readonly = $this->is_blocked($field) ? 'readonly' : '';

                $h .= '<label>' . $field['placeholder'] . '<input type="text" name="' . $this->metaPrefix . $field['name'] . '" value="' . $value . '"' . $is_readonly . '></label>';
            }
        }


        return $h;
    }

    /**
     * Checks if array has value 1/true for key "blocked"
     * @param array $fields
     * @return boolean
     */
    public function is_blocked(array $fields) {

        if (array_key_exists('blocked', $fields)) {
            if ($fields['blocked'] == true) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    private function is_checked($values, $value) {

        if (!empty($values)) {

            if (in_array($value, $values)) {
                return 'checked="checked"';
            }
            else {
                return '';
            }
        }
        else {
            return '';
        }

//        return $value;
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
        $json = [];
//        wp_die(debug($_POST));
//        die();
        /**
         * Mass saving for schema
         */
        foreach ($_POST as $key => $value) {

            /**
             * prefix was found in metakey to save
             */
            if (strpos($key, $this->metaPrefix) !== false) {

                /**
                 * Add schema without prefix to array
                 */
                $json[substr($key, strlen($this->metaPrefix))] = $value;



                if (is_array($value)) {
//                    $temp = [];
//                    foreach ($value as $key => $val) {
//                        $temp[esc_attr($key)] = esc_attr($val); 
//                    }
                    update_post_meta($post_ID, $key, serialize($value));
                }
                else {
                    update_post_meta($post_ID, $key, esc_attr($value));
                }
            }
        }


        update_post_meta($post_ID, 'ba_choosen_scope', $this->get_param('ba_choosen_scope'));
        update_post_meta($post_ID, 'ba_choosen_scopes', serialize($_POST['ba_choosen_scopes']));
        update_post_meta($post_ID, 'ba_choosen_schema', $this->get_param('ba_choosen_schema'));
        update_post_meta($post_ID, 'schema_json', json_encode($json));
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
