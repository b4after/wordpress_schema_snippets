<?php

/**
 * Enqueue scripts and styles in admin area
 */

function bascs_admin_enqueue_styles(){

	wp_enqueue_style('ba_srs_admin_styles', BASRS_URL . 'assets/css/ba_srs_styles.css', array(), '1.0', false);

//	wp_enqueue_script('ba_srs_admin_scripts', BASRS_URL . 'assets/js/admin-bascs.js', false, '1.0.0', true);
}

add_action('admin_enqueue_scripts', 'bascs_admin_enqueue_styles');
