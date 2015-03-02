<?php

/**
 * Create taxonomy deal
 */

add_action( 'init', 'create_taxonomy_deal');

function create_taxonomy_deal() {

    $labels = array(
        'name'              => _x( 'All Deals', 'taxonomy general name' ),
        'singular_name'     => _x( 'Deal', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Deal' ),
        'all_items'         => __( 'All Deals' ),
        'parent_item'       => __( 'Parent Deal' ),
        'parent_item_colon' => __( 'Parent Deal:' ),
        'edit_item'         => __( 'Edit Deal' ),
        'update_item'       => __( 'Update Deal' ),
        'add_new_item'      => __( 'Add New Deal' ),
        'new_item_name'     => __( 'New Genre Deal' ),
        'menu_name'         => __( 'Deals' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'deal' ),
    );

    register_taxonomy( 'deal', array( 'post' ), $args );
}

/* End taxonomy deal */

/**
 *  Shortcode add deal in editor
 *
 */

add_action('admin_head', 'shortcode_add_button_deal');

function shortcode_add_button_deal() {
    global $typenow;
    // Check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
        return;
    }
    // Verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter( 'mce_external_plugins', 'shortcode_add_tinymce_plugin' );
        add_filter('mce_buttons', 'shortcode_register_button_deal');
    }
}

function shortcode_add_tinymce_plugin($plugin_array) {
    $plugin_array['hotdealblog_button_deal'] = plugins_url( '../js/shortcode-add-deals.js', __FILE__ );
    return $plugin_array;
}

function shortcode_register_button_deal($buttons) {
    array_push( $buttons, 'hotdealblog_button_deal' );
    return $buttons;
}

add_action( 'wp_ajax_get_data_deals', 'func_get_data_deals' );

function func_get_data_deals() {

    $deals = get_terms(array('deal'), array('hide_empty' => false));

    echo json_encode($deals);

    exit();
}
