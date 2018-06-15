<?php

namespace BeforeAfter\BASRS;

/**
 * TODO: Generate json files based on schema/Generator .php files
 */
class SchemaGenerator {

    private $post;
    private $schemaType;

    public function __construct($postID, $schemaType) {

        $this->post = $postID;
        $this->schemaType = $schemaType;
    }

    function getType() {
        return $this->type;
    }

    function getPostID() {
        return $this->post;
    }

    function getSchemaType() {
        return $this->schemaType;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setPostID($postID) {
        $this->postID = $postID;
    }

    function setSchemaType($schemaType) {
        $this->schemaType = $schemaType;
    }

    /**
     * Generates schema from given $post object
     * @return string
     */
    private function generate_article_schema() {
        $article = array(
            '@context' => 'http://schema.org',
            '@type' => 'NewsArticle',
            'mainEntityOfPage' =>
            array(
                '@type' => 'WebPage',
                '@id' => get_permalink($this->post->ID),
            ),
            'headline' => get_the_title($this->post->ID),
            'datePublished' => get_the_date('Y-m-d\TH:i:s', $this->post->ID),
            'dateModified' => date('Y-m-d\TH:i:s', strtotime($this->post->post_modified)),
            'author' =>
            array(
                '@type' => 'Person',
                'name' => get_the_author(),
            ),
            'publisher' =>
            array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
            ),
            'description' => wp_trim_words(strip_shortcodes(str_replace('"', '\"', get_the_content($this->post->ID))), 40, ''),
        );

        if (has_post_thumbnail($this->post->ID)) {
            $article['image'][] = get_the_post_thumbnail_url($this->post->ID, 'full');
            $article['image'][] = get_the_post_thumbnail_url($this->post->ID, 'thumbnail');
            $article['image'][] = get_the_post_thumbnail_url($this->post->ID, 'medium');
            $article['image'][] = get_the_post_thumbnail_url($this->post->ID, 'large');
        }
        if (wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0]) {
            $article['publisher']['logo']['@type'] = 'ImageObject';
            $article['publisher']['logo']['url'] = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0];
        }
        wp_reset_postdata();
        return $article;
    }

    private function generate_website_schema() {

        $website = [
            '@context' => 'http://schema.org',
            '@type' => 'WebSite',
            'url' => get_bloginfo('url'),
        ];


        return $website;
    }

    public function generate() {
        $schema = '';
        if ($this->getSchemaType() === 'article') {
            $schema = $this->generate_article_schema();
        }
        elseif ($this->getSchemaType() === 'website') {
            $schema = $this->generate_website_schema();
        }



//        debug($schema);
//        debug($this->getSchemaType());
//        debug($this->getPostID());

        return json_encode($schema);
    }

}
