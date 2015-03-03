<?php

/**
 * Create taxonomy deal
 */

if( !taxonomy_exists( 'deal' ) ) {
    add_action( 'init', 'create_taxonomy_deal');
}


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

function deal_taxonomy_add_new_meta_url() {
    // this will add the url meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[url_address]"><?php _e( 'Url address', 'hotdealblog' ); ?></label>
        <input type="text" name="term_meta[url_address]" id="term_meta[url_address]" value="" size="40">
        <p class="description"><?php _e( 'Enter a url address for this field','hotdealblog' ); ?></p>
    </div>
<?php
}

add_action( 'deal_add_form_fields', 'deal_taxonomy_add_new_meta_url', 10, 2 );

/**
 * meta field in edit page
 *
 * @param $term
 */
function deal_taxonomy_edit_meta_field_url($term) {

    // put the term ID into a variable
    $t_id = $term->term_id;

    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$t_id" ); ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[url_address]"><?php _e( 'Url address', 'hotdealblog' ); ?></label></th>
        <td>
            <input type="text" name="term_meta[url_address]" id="term_meta[url_address]" value="<?php echo esc_attr( $term_meta['url_address'] ) ? esc_attr( $term_meta['url_address'] ) : ''; ?>">
            <p class="description"><?php _e( 'Enter a url address for this field','hotdealblog' ); ?></p>
        </td>
    </tr>
<?php
}
// structure: $term_edit_form_fiels
add_action( 'deal_edit_form_fields', 'deal_taxonomy_edit_meta_field_url', 10, 2 );

/**
 * save data meta term
 *
 * @param $term_id
 */
function save_taxonomy_url_address_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}
add_action( 'edited_deal', 'save_taxonomy_url_address_meta', 10, 2 );
add_action( 'create_deal', 'save_taxonomy_url_address_meta', 10, 2 );

/**
 * Meta deal_ID in taxonomy deal
 */

function deal_taxonomy_add_new_meta_ID() {
    // this will add the url meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[deal_ID]"><?php _e( 'ID', 'hotdealblog' ); ?></label>
        <input type="text" name="term_meta[deal_ID]" id="term_meta[deal_ID]" value="" size="40">
        <p class="description"><?php _e( 'Enter a ID deal for this field','hotdealblog' ); ?></p>
    </div>
<?php
}

add_action( 'deal_add_form_fields', 'deal_taxonomy_add_new_meta_ID', 10, 2 );

/**
 * meta field in edit page
 *
 * @param $term
 */
function deal_taxonomy_edit_meta_field_ID($term) {

    // put the term ID into a variable
    $t_id = $term->term_id;

    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$t_id" ); ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[deal_ID]"><?php _e( 'ID', 'hotdealblog' ); ?></label></th>
        <td>
            <input type="text" name="term_meta[deal_ID]" id="term_meta[deal_ID]" value="<?php echo esc_attr( $term_meta['deal_ID'] ) ? esc_attr( $term_meta['deal_ID'] ) : ''; ?>">
            <p class="description"><?php _e( 'Enter a ID deal for this field','hotdealblog' ); ?></p>
        </td>
    </tr>
<?php
}
// structure: $term_edit_form_fiels
add_action( 'deal_edit_form_fields', 'deal_taxonomy_edit_meta_field_ID', 10, 2 );

/**
 * save data meta term
 *
 * @param $term_id
 */
function save_taxonomy_deal_ID_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}
add_action( 'edited_deal', 'save_taxonomy_deal_ID_meta', 10, 2 );
add_action( 'create_deal', 'save_taxonomy_deal_ID_meta', 10, 2 );

/**
 * Custom columns table taxonomy Deals
 */
// Structure: manage_edit-${post_type}_columns
add_filter( 'manage_edit-deal_columns', 'column_table_taxonomy_deal' );

function column_table_taxonomy_deal( $columns ) {
    $new_columns = array(
        'cb'    =>  '<input type="checkbox" />',
        'name'  =>  __( 'Name', 'hotdealblog' ),
        'deal_ID'    =>  __( 'ID', 'hotdealblog'),
        'url'    =>  __( 'Url', 'hotdealblog')
    );
    return $new_columns;
}

/**
 * Add data new column on table taxonomy Deals
 */

add_action( 'manage_deal_custom_column', 'data_table_taxonomy_deal', 10, 3 );

function data_table_taxonomy_deal( $output, $column_name, $id ) {
    $term_name = get_term( $id, 'deal' );
    switch ($column_name) {
        case 'deal_ID':
            $output .= maybe_unserialize( $term_name->deal_ID );
            break;
        case 'url_address':
            $output .= maybe_unserialize( $term_name->url_address );
            break;

        default:
            break;
    }

    return $output;
}

add_action( 'init', 'test_func' );
function test_func() {
    echo "<pre>";
    print_r( get_term( 307, 'deal' ) );
    echo "</pre>";
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


