<?php

namespace BeforeAfter\BASRS;

/**
 * Description of Scope
 *
 * @author BA_komp_2
 */
class Scope {

    private $scopes = [];
    private $cpts;

    public function __construct() {
        $this->Scopes();
    }

    /**
     * Gets list of scopes
     * 
     */
    private function Scopes() {

        $this->scopes['taxonomy'] = $this->getTaxonomies();
        $this->scopes['post_types'] = $this->getPostTypes();
        $this->scopes['pages'] = $this->getPages();

//        debug($this->scopes);
//        $this->getTaxonomies();
    }

    /**
     * Gets list of all post types
     */
    private function getPostTypes() {

        $postTypes = get_post_types();


        unset($postTypes['attachment']);
        unset($postTypes['revision']);
        unset($postTypes['nav_menu_item']);
        unset($postTypes['custom_css']);
        unset($postTypes['customize_changeset']);
        unset($postTypes['oembed_cache']);
        unset($postTypes['user_request']);
        unset($postTypes['acf-field-group']);
        unset($postTypes['acf-field']);
        unset($postTypes['wpcf7_contact_form']);
        unset($postTypes['ba_schema_cpt']);



        $posts = [];
        foreach ($postTypes as $key => $post_type) {
            $posts[$key]['ID'] = 'cpt|' . $post_type;
            $posts[$key]['name'] = $post_type;
        }

        $this->cpts = $postTypes;
//        $this->scopes['post_types'][] = $posts;
        return $posts;
    }

    /**
     * Retrives list of taxonomies
     * @return type
     */
    private function getTaxonomies() {
        $taxonomies = get_taxonomies();

        unset($taxonomies['post_tag']);
        unset($taxonomies['nav_menu']);
        unset($taxonomies['link_category']);
        unset($taxonomies['post_format']);

        $taxes = [];

        foreach ($taxonomies as $key => $term) {
            $taxes[$key]['ID'] = 'tax|' . $term;
            $taxes[$key]['name'] = $term;
        }


        return $taxes;
    }

    /**
     * Gets lists of posts with IDs
     * @return type
     */
    private function getPages() {

        $args = [
            'post_type' => $this->cpts,
            'numberposts' => -1,
        ];

        $allPages = get_posts($args);


        $pages = [];
        /**
         * Trim values
         */
        foreach ($allPages as $key => $post) {

            $pages[$key]['ID'] = 'post|' . $post->ID;
            $pages[$key]['name'] = $post->post_title;
            $pages[$key]['post_type'] = $post->post_type;
        }


//        $this->scopes['pages'][] = $pages;

        return $pages;
    }

    /**
     * 
     * @param type $scopes
     */
    function setScopes($scopes) {
        $this->scopes = $scopes;
    }

    /**
     * 
     * @return type
     */
    function getScopes() {
        return $this->scopes;
    }

    /**
     * Gets part of scopes
     * @param type $name
     * @return type
     */
    function getScope($name) {
        return $this->scopes[$name];
    }

}
