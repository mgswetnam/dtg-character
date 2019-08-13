<?php

class DTG_Character_Base{

	private $version;
	public static $_instance;

	// Set global variables
	var $_cid;
	var $_clegal;

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
	public function __construct( $cid=0, $legal="" ) {
		$this->_cid = $cid;
		$this->_clegal = $legal;
	}

	// Get/set the arguments for character ID
	public function get_character_cid() {
		return $this->_cid;
	}

	public function set_character_cid( $cid ) {
		$this->_cid = $cid;
	}

	// Get/set the arguments for character full name
	public function get_character_legalname() {
		return $this->_clegal;
	}

	public function set_character_legalname( $legal ) {
		$this->_clegal = $legal;
	}

	/**
	 * Sets the character object by the ID
	 *
	 * @since    1.0.0
	 */

	public function set_character_by_id( $id = NULL ){
		global $wpdb;
		include DTG_CHARACTER_PLUGIN_DIR ."includes/metaboxes.php";
    // Set variables
    $custom_fields = array();
    // Get field ID from metabox array
    foreach( $metaboxes as $value ){
      $args = ( ( array_key_exists( "fields", $value ) )? $value[ "fields" ] : NULL );
      foreach( $args as $field ){
        $fid = ( ( array_key_exists( "fid", $field ) )? $field[ "fid" ] : NULL );
        array_push( $custom_fields, $fid );
      }
    }
		if( $id ){
			// Fetch the row from the database by ID
			$character_raw = get_post_meta( $id );
			// Load object data from row
			$this->set_character_cid( $id );
			foreach( $custom_fields as $field ){
				$value = ( ( array_key_exists( $field, $character_raw ) )? ( ( array_key_exists( 0, $character_raw[ $field ] ) )? $character_raw[ $field ][ 0 ] : NULL ) : NULL );
				$title = str_replace( "dtg_field_custom_", "", $field );
				$func = "set_character_".$title;
				$this->$func( $value );
			}
			/*if( $this->get_character_departments() ){
				$this->set_character_departments( $this->departments_string_to_array() );
			}
			if( $this->get_character_industry() ){
				$this->set_character_industry( $this->industries_serial_to_array() );
			}*/
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns the array value of a string of departments
	 *
	 * @since    1.0.0
	 */

	public function departments_string_to_array( $args=NULL ){
		$departments = ( ( $args )? $args : $this->get_character_departments() );
		return explode( "\n", str_replace( "\r", "", $departments ) );
	}

	/**
	 * Returns the array value of serialized industries
	 *
	 * @since    1.0.0
	 */

	public function industries_serial_to_array( $args=NULL ){
		$industry = ( ( $args )? $args : $this->get_character_industry() );
		return unserialize( $industry );
	}

}
