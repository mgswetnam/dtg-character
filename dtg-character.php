<?php
/**
 *
 * @link              http://www.deadtreegames.com
 * @since             1.0.0
 * @package           DTG_Character
 *
 * @wordpress-plugin
 * Plugin Name:       DTG Character
 * Plugin URI:        http://www.deadtreegames.com
 * Description:       Plugin for creating role playing game characters.
 * Version:           1.0.0
 * Author:            Matthew Swetnam
 * Author URI:        http://www.deadtreegames.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dtg-character
 * Domain Path:       /languages
 *
 * @package  dtg_character
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'CONTENT_URL', content_url() );
define( 'DTG_CHARACTER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DTG_CHARACTER_PLUGIN_URL', CONTENT_URL . '/plugins/dtg-character/' );
define( 'DTG_CHARACTER_VERSION', '1.3.2' );
define( 'DTG_CHARACTER_DB_VERSION', '1.2.1' );

register_activation_hook( __FILE__, array( 'DTG_Character', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'DTG_Character', 'plugin_deactivation' ) );

require_once DTG_CHARACTER_PLUGIN_DIR . 'classes/class-dtg-character-core.php';
require_once DTG_CHARACTER_PLUGIN_DIR . 'classes/class-dtg-character-cpts.php';
require_once DTG_CHARACTER_PLUGIN_DIR . 'classes/class-dtg-character-metaboxes.php';
require_once DTG_CHARACTER_PLUGIN_DIR . 'classes/class-dtg-character-base.php';
require_once DTG_CHARACTER_PLUGIN_DIR . 'classes/class-dtg-character-shortcodes.php';
if ( is_admin() ){
	require_once DTG_CHARACTER_PLUGIN_DIR . 'admin/class-dtg-character-admin.php';
}

/* Actions */
add_action( 'init', array( 'DTG_Character', 'init' ) );
add_action( 'init', array( 'DTG_Character_CPTs', 'init' ) );
add_action( 'init', array( 'DTG_Character_CPTs', 'dtg_add_custom_post_types' ) );
add_action( 'init', array( 'DTG_Character_Metaboxes', 'init' ) );
add_action( 'init', array( 'DTG_Character_Core', 'init' ) );
add_action( 'init', array( 'DTG_Character_Base', 'init' ) );
add_action( 'init', array( 'DTG_Character_Shortcode', 'init' ) );

if ( is_admin() ){
	add_action( 'init', array( 'DTG_Character_Admin', 'init' ) );
}

// Disable admin bar
show_admin_bar( false );

class DTG_Character
{
	private $version;
	public static $_instance;

	static function init(){
		if ( !self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		// Set cron jobs; cron jobs scheduled on plugin activation
		//add_action( 'dtg_check_coupons', array( $this, 'dtg_coupon_schedule_cron' ) );
		// End cron jobs
		//require_once 'modules/arrowdown/dtg-bb-helper-module-arrowdown.php';
	}

	/**
	 * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
	 * @static
	 */
	public static function plugin_activation( $network_wide ) {
		global $wpdb;

		// Define variables
		//$location_table = $wpdb->prefix . "dtg_character_location";
		//$charset_collate = $wpdb->get_charset_collate();

		// Include file needed for dbDelta function
		//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// Create location table if it doesn't already exist
		/*$location_sql = "CREATE TABLE IF NOT EXISTS $location_table (
				location_id int(11) NOT NULL AUTO_INCREMENT,
				character_id int(11) NOT NULL,
				location_name varchar(250) NOT NULL,
				location_short_name varchar(250) NOT NULL,
				location_address_street varchar(250) NOT NULL,
				location_address_city varchar(250) NOT NULL,
				location_address_state varchar(250) NOT NULL,
				location_address_zip varchar(250) NOT NULL,
				location_is_primary int(1) NOT NULL DEFAULT 0,
				location_status varchar(25) NOT NULL,
				location_author varchar(25) NOT NULL,
				location_date varchar(25) NOT NULL,
				location_modified varchar(25) NOT NULL,
				PRIMARY KEY (location_id)
			) $charset_collate;";
		dbDelta( $location_sql );

		add_option( 'dtg_character_db_version', DTG_CHARACTER_DB_VERSION );*/

		/*if( get_option( 'dtg_character_admin_posttypes' ) === false ){
			add_option( 'dtg_character_admin_posttypes', array( 'characters' ) );
		}*/
		return;
	}

	/**
	 * Removes all connection options
	 * @static
	 */
	public static function plugin_deactivation() {
		/*wp_clear_scheduled_hook( 'dtg_check_coupons' );*/
		return;
	}

	/**
	 * Must never be called statically
	 */
	public function plugin_upgrade(){
		return;
	}

	/**
	 * Load language files
	 */
	public static function plugin_textdomain(){
		load_plugin_textdomain( 'dtg-character', false, DTG_CHARACTER_PLUGIN_DIR.'/languages/' );
	}
}
