<?php

/**
 * Custom Post Type factory for DTG Character
 * @class DTG_Character_CPTs
 */

final class DTG_Character_CPTs {

  private $version;
  public static $_instance;

  static function init(){
    if ( !self::$_instance ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct() {
    // Nothing needed here
  }

	static public function dtg_add_custom_post_types() {
    include DTG_CHARACTER_PLUGIN_DIR ."includes/cpts.php";
    $selected = ( ( get_option( "dtg_character_admin_posttypes" ) != "" )? get_option( "dtg_character_admin_posttypes" ) : array() );
    if( !empty( $cpts ) ){
      foreach( $cpts as $cpt ){
        // Define variables from array
        $singular = ( ( array_key_exists( "singular", $cpt ) )? $cpt[ "singular" ] : NULL );
        $plural = ( ( array_key_exists( "plural", $cpt ) )? $cpt[ "plural" ] : NULL );
        $labels = ( ( $singular && $plural )? self::define_cpt_labels( $singular, $plural ) : NULL );
        $description = ( ( array_key_exists( "description", $cpt ) )? $cpt[ "description" ] : NULL );
        $exclude = ( ( array_key_exists( "exclude_from_search", $cpt ) )? $cpt[ "exclude_from_search" ] : NULL );
        $queryable = ( ( array_key_exists( "publicly_queryable", $cpt ) )? $cpt[ "publicly_queryable" ] : NULL );
        $showui = ( ( array_key_exists( "show_ui", $cpt ) )? $cpt[ "show_ui" ] : NULL );
        $inmenu = ( ( array_key_exists( "show_in_menu", $cpt ) )? $cpt[ "show_in_menu" ] : NULL );
        $icon = ( ( array_key_exists( "menu_icon", $cpt ) )? $cpt[ "menu_icon" ] : NULL );
        $queryvar = ( ( array_key_exists( "query_var", $cpt ) )? $cpt[ "query_var" ] : NULL );
        $rewrite = ( ( array_key_exists( "rewrite", $cpt ) )? $cpt[ "rewrite" ] : NULL );
        $capability = ( ( array_key_exists( "capability_type", $cpt ) )? $cpt[ "capability_type" ] : NULL );
        $hasarchive = ( ( array_key_exists( "has_archive", $cpt ) )? $cpt[ "has_archive" ] : NULL );
        $hierarchical = ( ( array_key_exists( "hierarchical", $cpt ) )? $cpt[ "hierarchical" ] : NULL );
        $menupos = ( ( array_key_exists( "menu_position", $cpt ) )? $cpt[ "menu_position" ] : NULL );
        $showinrest = ( ( array_key_exists( "show_in_rest", $cpt ) )? $cpt[ "show_in_rest" ] : NULL ); // For Gutenberg editor
        $supports = ( ( array_key_exists( "supports", $cpt ) )? $cpt[ "supports" ] : NULL );
        $taxonomies = ( ( array_key_exists( "taxonomies", $cpt ) )? $cpt[ "taxonomies" ] : NULL );
        if( $labels && in_array( strtolower( $plural ), $selected ) === true ){
          $args = array(
      			'labels' => $labels,
      			'description' => __( $description, 'dtg_'.strtolower( $singular ) ),
      			'exclude_from_search' => $exclude,
      			'publicly_queryable' => $queryable,
      			'show_ui' => $showui,
      			'show_in_menu' => $inmenu,
            'menu_icon' => $icon,
      			'query_var' => $queryvar,
      			'rewrite' => $rewrite,
      			'capability_type' => $capability,
      			'has_archive' => $hasarchive,
      			'hierarchical' => $hierarchical,
      			'menu_position' => $menupos,
						'show_in_rest' => $showinrest,
      			'supports' => $supports,
      			'taxonomies' => $taxonomies
      		);
      		register_post_type( strtolower( $singular ), $args );
        }
      }
    }
	}

  static public function define_cpt_labels( $singular, $plural ) {
    $labels = array(
			'name' => _x( ucwords( $plural ), 'post type general name', 'dtg_'.strtolower( $singular ) ),
			'singular_name' => _x( ucwords( $singular ), 'post type singular name', 'dtg_'.strtolower( $singular ) ),
			'add_new' => _x( 'Add New', strtolower( $singular ), 'dtg_'.strtolower( $singular ) ),
			'add_new_item' => __( 'Add New '.ucwords( $singular ), 'dtg_'.strtolower( $singular ) ),
			'edit_item' => __( 'Edit '.ucwords( $singular ), 'dtg_'.strtolower( $singular ) ),
			'new_item' => __( 'New '.ucwords( $singular ), 'dtg_'.strtolower( $singular ) ),
			'view_item' => __( 'View '.ucwords( $singular ), 'dtg_'.strtolower( $singular ) ),
			'view_items' => __( 'View '.ucwords( $plural ), 'dtg_'.strtolower( $singular ) ),
			'search_items' => __( 'Search '.ucwords( $plural ), 'dtg_'.strtolower( $singular ) ),
			'not_found' => __( 'No '.strtolower( $plural ).' found.', 'dtg_'.strtolower( $singular ) ),
			'not_found_in_trash' => __( 'No '.strtolower( $plural ).' found in Trash.', 'dtg_'.strtolower( $singular ) ),
			'parent_item_colon' => __( 'Parent '.ucwords( $plural ), 'dtg_'.strtolower( $singular ) ),
			'all_items' => __( 'All '.ucwords( $plural ), 'dtg_'.strtolower( $singular ) ),
      'archives' => __( ucwords( $singular ).' Archives', 'dtg_'.strtolower( $singular ) ),
      'attributes' => __( ucwords( $singular ).' Attributes', 'dtg_'.strtolower( $singular ) ),
      'insert_into_item' => __( 'Insert into '.strtolower( $plural ), 'dtg_'.strtolower( $singular ) ),
      'uploaded_to_this_item' => __( 'Uploaded to this '.strtolower( $plural ), 'dtg_'.strtolower( $singular ) ),
      'featured_image' => __( ucwords( $singular ).' Image', 'dtg_'.strtolower( $singular ) ),
      'set_featured_image' => __( 'Set '.strtolower( $singular ).' image', 'dtg_'.strtolower( $singular ) ),
      'remove_featured_image' => __( 'Remove '.strtolower( $singular ).' image', 'dtg_'.strtolower( $singular ) ),
      'use_featured_image' => __( 'Use as '.strtolower( $singular ).' image', 'dtg_'.strtolower( $singular ) ),
			'menu_name' => _x( ucwords( $plural ), 'admin menu', 'dtg_'.strtolower( $singular ) ),
			'name_admin_bar' => _x( ucwords( $singular ), 'add new on admin bar', 'dtg_'.strtolower( $singular ) ),
		);
    return $labels;
  }

}
