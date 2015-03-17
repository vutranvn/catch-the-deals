<?php
/*
Plugin Name: Hotdeal - Catch the Deals
 * Plugin URI:  http://blog.hotdeal.vn/
 * Description: Retrieve the deals from main website
 * Version:     1.0.0
 * Author:      ...
 * Author URI:  ...
 * License:     GPL-2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

defined( 'ABSPATH' ) || exit;

add_action('init','catch_the_deal_init');

function catch_the_deal_init() {
	/* Runs when plugin is activated */
	register_activation_hook( __FILE__ , 'catch_the_deal_active' );
	/* Runs on plugin deactivation */
	register_deactivation_hook( __FILE__, 'catch_the_deal_deactive' );
	/* Runs on plugin uninstall */
	register_uninstall_hook( __FILE__, 'catch_the_deal_uninstall' );
}

function catch_the_deal_active() {
	add_option( 'catch-the-deals', 'active' );
}

function catch_the_deal_deactive() {
	delete_option( 'catch-the-deals' );
}

function catch_the_deal_uninstall() {
	// Delete taoxonomy term
}

require_once 'inc/deals-settings.php';

if( is_admin() ) {
	add_action('admin_menu', 'menu_add_deals' );
}


function menu_add_deals(){
	add_submenu_page( 'tools.php', __( 'Catch the Deals Page', 'hotdealblog' ), __( 'Catch the Deals', 'hotdealblog' ), 'manage_options', 'catch-the-deals', 'callback_catch_the_deal');
}

function callback_catch_the_deal( ) {
	?>
	<div class="wrap">
		<h2><?php echo __( 'Catch the Deals', 'hotdealblog' ); ?></h2>

		<form method="post" action="" novalidate="novalidate">
			<input type="hidden" name="option_page" value="catch-the-deals">
			<input type="hidden" name="action" value="update">
			<table class="form-table">
				<tbody>
				<tr>
					<th scope="row"><label for="ctd-url"><?php echo __( 'The Url to Retrieve Deals', 'hotdealblog' ); ?></label></th>
					<td>
						<input name="ctd-url" type="text" id="ctd-url" value="<?php echo ( !empty($_POST['ctd-url'] ) ) ? $_POST['ctd-url'] : ''; ?>" class="regular-text" placeholder="http://domain.com/get-deals">
						<p class="description"><?php echo __( 'The url address to retrieve deals', 'hotdealblog' ); ?></p>
					</td>
				</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="Get Deals">
			</p>
		</form>
		<div class="result_retrieve">
			<ul>
			<?php
			if( isset($_POST['submit']) && $_POST['submit']='Get Deals' ) {
				if( !empty($_POST['ctd-url']) ) {
					$str_json = wp_remote_get($_POST['ctd-url']);
					$arr_obj_deals = json_decode($str_json['body']);

					foreach( $arr_obj_deals as $obj_deal) {
						$flag_exists = term_exists( $obj_deal->slug, 'deal' );
						if( isset($flag_exists) && !empty($flag_exists) ) {
							$notice = $obj_deal->name . '::'. $obj_deal->slug . ' is exists';
						}else{
							$flag_insert = wp_insert_term(
								$obj_deal->name,
								'deal',
								array(
									'slug' => $obj_deal->slug,
									'description' => $obj_deal->description,
								)
							);

							if( !empty($flag_insert) ) {
								$notice = $obj_deal->name . '::'. $obj_deal->slug . ' is inserted successful';
							}else{
								$notice = $obj_deal->name . '::'. $obj_deal->slug . ' is inserted fails';
							}
						}
						echo "<li>" . $notice . "</li>";
					}
				}
			}
			?>
			</ul>
		</div>
	</div>
	<style type="text/css">
		.result_retrieve {
			float: left;
		}

		.result_retrieve ul {
			display: block;
			max-height: 450px;
			overflow: scroll;
		}

		.result_retrieve ul li {
			opacity: 1.5;
			-webkit-transition: all 1s ease;
			-moz-transition: all 1s ease;
			-ms-transition: all 1s ease;
			-o-transition: all 1s ease;
			transition: all 1s ease;
		}
	</style>
<?php
}


add_action( 'init', 'add_script_catch_the_deals' );

function add_script_catch_the_deals() {
	wp_localize_script( 'var_ajax_url', 'var_ajaxurl', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'var_ajax_url' );
}

/*
 * Do list:
 * - Fixed show custom taxonomy term deal
 * - Transfer data json to tinymce
 * - function search, add deals
 */

