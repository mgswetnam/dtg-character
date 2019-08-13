<?php
/**
 * The core functionality of the plugin.
 *
 * @link       http://www.deadtreegames.com
 * @since      1.0.0
 *
 * @package    DTG_Character_Core
 * @author     Matthew Swetnam <matt@deadtreegames.com>
 */

class DTG_Character_Core
{
	private $version;
	public static $_instance;

	static function init(){
		if ( !self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */

	public function __construct() {
    // Actions
    add_action( "wp_print_scripts", array( $this, "dtg_character_setup" ) );
		add_action( 'add_meta_boxes', array( $this, 'dtg_add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'dtg_save_custom' ) );
		// AJAX
		//add_action( 'wp_ajax_dtg_challenge_number', array( $this, 'dtg_challenge_number' ) );
		//add_action( 'wp_ajax_nopriv_dtg_challenge_number', array( $this, 'dtg_challenge_number' ) );
    // Filters
    // Shortcodes
	}

  public static function dtg_character_setup(){
		// Scripts
    wp_enqueue_script( 'dtg-character-main', DTG_CHARACTER_PLUGIN_URL . 'assets/dist/js/main.min.js', array('jquery'), DTG_CHARACTER_VERSION );
		wp_localize_script( 'dtg-character-main', 'dtg_ajaxobject', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    // Styles
    wp_enqueue_style( 'dtg-character-main', DTG_CHARACTER_PLUGIN_URL . 'assets/dist/css/main.min.css', array(), DTG_CHARACTER_VERSION );
  }

	public function dtg_add_meta_boxes(){
    $metabox = new DTG_Character_Metaboxes();
    $metabox->dtg_add_meta_boxes();
	}

	public function dtg_save_custom(){
    $metabox = new DTG_Character_Metaboxes();
    $metabox->dtg_save_custom_fields();
	}

	/** START AJAX **/

	/**
	 * AJAX save DNI
	 *
	 * @since    1.0.0
	 */
	/*public function dtg_challenge_number() {
		global $wpdb;
		$response = $this->dtg_get_response_container();
		$dnijeeves = new DTG_Character_DNI();
		$dnijeeves->set_dni_by_post( $_POST );
		try{
			$fetch_params = array(
				"pid" => $dnijeeves->_dpid,
				"tag" => $dnijeeves->_dtag,
			);
			$challenge_raw = $dnijeeves->fetch_dni( $fetch_params );
			$number = "";
			if( count( $challenge_raw ) > 0 ){
				$results = ( ( array_key_exists( 0, $challenge_raw ) )? ( ( array_key_exists( "dni_number", $challenge_raw[ 0 ] ) )? $challenge_raw[ 0 ][ "dni_number" ] : false ) : false );
				$response[ "message" ] = "success";
				array_push( $response[ "content" ], $results );
			} else {
				$response[ "error" ] = true;
				$response[ "message" ][ "result" ] = "No records were returned.";
			}
		} catch( Exception $e ){
			$response[ "error" ] = true;
			array_push( $response[ "message" ], $e );
		}
		wp_send_json( $response );
		unset( $dnijeeves );
	}*/

	/** END DNI AJAX **/

	/**
	 * Returns a response container to assure uniform response arrays
	 *
	 * @since    1.0.0
	 */
	private static function dtg_get_response_container() {
		$response = array(
			"error" => false,
			"message" => array(),
			"content" => array()
		);
		return $response;
	}
}

?>
