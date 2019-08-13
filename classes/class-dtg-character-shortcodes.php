<?php
/**
 * Shortcode functionality.
 *
 * @link       http://www.deadtreegames.com
 * @since      1.0.0
 *
 * @package    DTG_Character_Shortcode
 * @author     Matthew Swetnam <matts@deadtreegames.com>
 */

class DTG_Character_Shortcode
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
		// Character
		add_shortcode( 'dtg_character_legal_name', array( $this, 'dtg_character_legal_name' ) );

	}

	/*--------- Character Shortcodes ---------*/

	// Return character full legal name from meta data
	public function dtg_character_legal_name( $atts ){
		$a = shortcode_atts( array(
			"id" => "",
			"class" => "",
			"wrap" => "",
			"formatted" => "true"
		), $atts );
    // Set variables
    $id = ( ( $a[ "id" ] != "" )? $a[ "id" ] : NULL );
    $class = ( ( $a[ "class" ] != "" )? $a[ "class" ] : NULL );
    $wrap = ( ( $a[ "wrap" ] != "" )? $a[ "wrap" ] : NULL );
    $formatted = ( ( $a[ "formatted" ] == "false" )? false : true );
		$results = $this->fetch_character_meta( $id, "dtg_field_custom_legalname" );
		// Return rendered data
		if( $formatted ){
			return $this->render_character_meta( $results, $wrap, "legalname", $class );
		} else {
			return $results;
		}
	}

	// Gets meta value for the requested name and uses primary if ID is not supplied
	public static function fetch_character_meta( $character_id=NULL, $meta_name=NULL ){
		global $wpdb;
		$results = "";
		$value = "";
		if( $meta_name ){
			if( $character_id ){
				$results = get_post_meta( $character_id, $meta_name, TRUE );
			} else {
				$table = $wpdb->prefix."postmeta";
				$value = "yes";
				$id_raw = $wpdb->get_results(
					"SELECT post_id
					FROM $table
					WHERE meta_key = 'dtg_field_custom_primarycharacter'
					AND meta_value = '$value'",
					ARRAY_A
				);
				$id = ( ( array_key_exists( 0, $id_raw ) )? ( ( array_key_exists( "post_id", $id_raw[ 0 ] ) )? $id_raw[ 0 ][ "post_id" ] : "" ) : "" );
				$results = get_post_meta( $id, $meta_name, TRUE );
			}
	    return $results;
		} else {
			return false;
		}
	}

	// Renders character data in HTML format
	public static function render_character_meta( $data=NULL, $wrap=NULL, $meta=NULL, $class=NULL ){
		// Define search and  replace
		$search = array( '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/' );
		$replace = array( '>', '<', '\\1', '' );
		// Refine variables
		$data = ( ( $data )? $data : "" );
		$wrap = ( ( $wrap )? $wrap : "span" );
		$meta = ( ( $meta )? $meta : "data" );
		$class = ( ( $class )? $class : "" );
		ob_start();
		?>
		<<?=$wrap?> class="dtg-character-<?=$meta?> <?=$class?>">
			<?=$data?>
		</<?=$wrap?>>
		<?php
  	$buffer = ob_get_clean();
		// We have to minimize the HTML because otherwise
    // line breaks are rendered incorrectly in widgets
		$buffer = preg_replace( $search, $replace, $buffer );
    return $buffer;
	}
}

?>
