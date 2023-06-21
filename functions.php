<?php

function register_leads_cpt() {
    $labels = array(
        'name' => 'Leads',
        'singular_name' => 'Lead',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Lead',
        'edit_item' => 'Edit Lead',
        'new_item' => 'New Lead',
        'view_item' => 'View Lead',
        'search_items' => 'Search Leads',
        'not_found' => 'No Leads found',
        'not_found_in_trash' => 'No Leads found in Trash',
        'parent_item_colon' => 'Parent Lead:',
        'menu_name' => 'Leads'
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Leads',
        'supports' => array('title', 'custom-fields'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    register_post_type('leads', $args);
}
add_action('init', 'register_leads_cpt');

include_once(__DIR__ . '/lead/lead-handler.php');
include_once(__DIR__ . '/lead/lead-form-shortcode.php');

?>