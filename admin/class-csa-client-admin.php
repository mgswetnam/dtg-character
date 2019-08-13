<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    DTG_Character
 * @subpackage DTG_Character/admin
 * @author     Matthew Swetnam <matt@deadtreegames.com>
 */
class DTG_Character_Admin {

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
		/* Import required files */
		add_action( "admin_head", array( $this, "enqueue_scripts" ) );
		add_action( "admin_menu", array( $this, "define_dtg_admin_pages" ) );
	  //add_action( 'wp_ajax_dtg_save_location', array( $this, 'dtg_save_location' ) );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	static public function enqueue_scripts() {
		// Scripts
		wp_enqueue_script( "admin-scripts", DTG_CHARACTER_PLUGIN_URL . 'admin/assets/dist/js/admin.min.js', array( 'jquery' ), DTG_CHARACTER_VERSION, false );
		wp_enqueue_script( "datatable-scripts", '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array( 'jquery' ), DTG_CHARACTER_VERSION, false );
		wp_enqueue_script( "jquery-ui-core" );
		wp_enqueue_script( "jquery-ui-dialog" );
		// CSS
		wp_enqueue_style( "admin-styles", DTG_CHARACTER_PLUGIN_URL . 'admin/assets/dist/css/admin.min.css', array(), DTG_CHARACTER_VERSION, 'all' );
		wp_enqueue_style( "datatable-styles", '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', array(), DTG_CHARACTER_VERSION, 'all' );
		wp_enqueue_style( "dtgcharacter-jquery-ui", 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), DTG_CHARACTER_VERSION, 'all' );
	}

	public function define_dtg_admin_pages(){
		include DTG_CHARACTER_PLUGIN_DIR ."admin/pages.php";
		$this->dtg_process_admin_definition( $pages );
	}

	public function dtg_process_admin_definition( $args ){
		global $params;
		$isFirst = true;
		foreach( $args as $page ){
			$page_title = ( ( array_key_exists( "pagetitle", $page ) )? $page[ "pagetitle" ] : NULL );
			$menu_title = ( ( array_key_exists( "menutitle", $page ) )? $page[ "menutitle" ] : NULL );
			$capability = ( ( array_key_exists( "capability", $page ) )? $page[ "capability" ] : NULL );
			$parent_slug = ( ( array_key_exists( "parentslug", $page ) )? $page[ "parentslug" ] : NULL );
			$menu_slug = ( ( array_key_exists( "slug", $page ) )? $page[ "slug" ] : NULL );
			$function = ( ( array_key_exists( "function", $page ) )? $page[ "function" ] : NULL );
			$icon_url = ( ( array_key_exists( "icon", $page ) )? $page[ "icon" ] : NULL );
			$position = ( ( array_key_exists( "position", $page ) )? $page[ "position" ] : NULL );
			$sections = ( ( array_key_exists( "sections", $page ) )? $page[ "sections" ] : NULL );
			if( is_null( $parent_slug ) === true ){
				$hook = add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
				$params[ $hook ] = array( "pagetitle" => $page_title, "pageid" => $menu_slug );
			} else {
				$hook = add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
				$params[ $hook ] = array( "pagetitle" => $page_title, "pageid" => $menu_slug );
			}
			$isFirst = false;
			foreach( $sections as $section ){
				$sid = ( ( array_key_exists( "id", $section ) )? $section[ "id" ] : NULL );
				$stitle = ( ( array_key_exists( "title", $section ) )? $section[ "title" ] : NULL );
				$scallback = ( ( array_key_exists( "callback", $section ) )? $section[ "callback" ] : NULL );
				$spage = $menu_slug;
				$sfields = ( ( array_key_exists( "fields", $section ) )? $section[ "fields" ] : NULL );
				add_settings_section( $sid, $stitle, $scallback, $spage );
				foreach( $sfields as $field ){
					$fid = ( ( array_key_exists( "id", $field ) )? $field[ "id" ] : NULL );
					$ftitle = ( ( array_key_exists( "title", $field ) )? $field[ "title" ] : NULL );
					$fcallback = ( ( array_key_exists( "callback", $field ) )? $field[ "callback" ] : NULL );
					$tooltip = ( ( array_key_exists( "tooltip", $args ) )? $args[ "tooltip" ] : NULL );
					$fpage = $menu_slug;
					$fsection = $sid;
					$fargs = ( ( array_key_exists( "args", $field ) )? $field[ "args" ] : NULL );
					add_settings_field( $fid, $ftitle, $fcallback, $fpage, $fsection, $fargs );
					register_setting( $fpage, $fid );
				}
			}
		}
	}

	public function dtg_admin_page() { // Defines sections of page
		global $params;
		$param = $params[ current_filter() ];
		extract( $param );
		ob_start();
		?>
		<h1><?=$pagetitle?></h1>
		<?php
		if( ! current_user_can( 'manage_options' ) ){
			return;
		}
		if( isset( $_GET['settings-updated'] ) ){
			add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
		}
		settings_errors( 'wporg_messages' );
		?>
		<form name="options" method="post" action="options.php">
			<?php
			settings_fields( $pageid );
			do_settings_sections( $pageid );
			submit_button();
			?>
		</form>
		<?php
		$buffer =  ob_get_clean();

    //$buffer = preg_replace( $search, $replace, $buffer );
    echo $buffer;
	}
	public function dtg_admin_page_section( $arg ) { // Defines fields of section
		/*global $params;
		$param = $params[ current_filter() ];
		extract( $param );
		$sid = ( ( array_key_exists( "id", $arg ) )? $arg[ "id" ] : 0 );
		// Render section
		ob_start();
		?>
		<section class=\"dtg-character-admin settings-section\">
		<?php
		do_settings_fields( $pageid, $sid );
		?>
		</section>
		<?php
		$buffer =  ob_get_clean();
    echo $buffer;*/
	}
	public function dtg_admin_page_section_field( $args ) {
		// Define variables
		$fid = ( ( array_key_exists( "fid", $args ) )? $args[ "fid" ] : "" );
		$type = ( ( array_key_exists( "ftype", $args ) )? $args[ "ftype" ] : "" );
		$subtype = ( ( array_key_exists( "fsubtype", $args ) )? $args[ "fsubtype" ] : "" );
		$tooltip = ( ( array_key_exists( "ftooltip", $args ) )? $args[ "ftooltip" ] : NULL );
		$repeat = ( ( array_key_exists( "frepeat", $args ) )? ( ( $args[ "frepeat" ] == "true" )? true : false ) : false );
		$wrapclass = ( ( array_key_exists( "fwrapclass", $args ) )? " ".$args[ 'fwrapclass' ] : "" );
		$fielddata = ( ( array_key_exists( 'fdata', $args ) )? " data-field-data=\"".$args[ 'fdata' ]."\"" : "" );
		$attributes = ( ( array_key_exists( "attributes", $args ) )? $args[ "attributes" ] : array() );
		$atts = "";
		foreach( $attributes as $k=>$v ){
			if( $k == "options" ){
				$options = $v;
			} else {
				$atts .= $k . "=\"" . $v . "\" ";
			}
		}
		$makearray = ( ( $repeat )? "[]" : "" );
		$value = ( ( get_option( "$fid" ) != "" )? get_option( "$fid" ) : "" );
		$iterations = ( ( gettype( $value ) == "array" && $repeat )? count( $value ) : 1 );
		// Begin field
		ob_start();
		//echo "**<pre>".print_r( $value )."</pre>**<br/>";
		?>
		<div id="<?=$fid?>-wrapper" class="dtg-settings-wrapper">
		<?php
		for( $i=0; $i<$iterations; $i++){
			$val = ( ( gettype( $value ) == "array" )? ( ( array_key_exists( $i, $value ) )? $value[ $i ] : "" ) : $value );
			$tooltip = ( ( $tooltip )? "<div class=\"dtg-character-tooltip-wrapper\"><div class=\"dtg-character-tooltip-icon dashicons dashicons-editor-help\" data-ttid=\"dtg-character-tooltip-".$fid."\"></div><div id=\"dtg-character-tooltip-".$fid."\" class=\"dtg-character-tooltip\">".$tooltip."</div></div>" : "" );
			$revoke = ( ( $repeat )? "<div class=\"dtg-character-revoker-wrapper\"><div class=\"dtg-character-revoker-icon dashicons dashicons-dismiss\" data-revoker-id=\"".$i."\" data-revoker-field=\"".$fid."\"></div></div>" : "" );
			$repeat = ( ( $repeat )? "<div class=\"dtg-character-repeater-wrapper\"><div class=\"dtg-character-repeater-icon dashicons dashicons-plus-alt\" data-repeater-id=\"".$i."\" data-repeater-field=\"".$fid."\"></div></div>" : "" );

			switch( $type ){
				case "input":{
	        switch( $subtype ){
	          case "text":
	          case "password":
	          case "email":
	          case "color":
	          case "date":
	          case "file":
	          case "number":
	          case "time":
	          case "url":{
	  			    ?>
	  					<input type="<?=$subtype?>" id="<?=$fid?>-<?=$i?>" name="<?=$fid?><?=$makearray?>" <?=$atts?> value="<?=$val?>" />
							<?php
	  					break;
	          }
	  				case "radio":{
	            $j=0;
	  			    ?>
	            <?php foreach( $options as $kitem => $vitem ){ ?>
	  					<label for="<?=$fid?>-<?=$i?>-<?=$j?>"><input type="<?=$subtype?>" id="<?=$fid?>-<?=$i?>-<?=$j?>" name="<?=$fid?><?=$makearray?>" <?=$atts?> <?php echo ( ( $val == $kitem )? 'checked' : '' ); ?> value="<?php echo strtolower( $kitem ); ?>" /><?=$vitem?></label><br/>
	            <?php
	            $j++;
							}
	  					break;
	  				}
	  				case "checkbox":{
	            $j=0;
	  			    ?>
	            <?php foreach( $options as $kitem => $vitem ){ ?>
	  					<label for="<?=$fid?>-<?=$i?>-<?=$j?>"><input type="<?=$subtype?>" id="<?=$fid?>-<?=$i?>-<?=$j?>" name="<?=$fid?>[]" <?=$atts?> <?php echo ( ( $value != false && in_array( strtolower( $kitem ), $value ) )? 'checked' : '' ); ?> value="<?php echo strtolower( $kitem ); ?>" /><?=ucfirst( $vitem )?></label><br/>
	            <?php
	            $j++;
							}
	  					break;
	  				}
	        }
					break;
				}
				case "select":{
	        $selected = ( ( $val != "" )? $val : ( ( array_key_exists( "default", $args ) === true && $args[ 'default' ] != "" )? $args[ 'default' ] : "" ) );
			    ?>
					<select id="<?=$fid?>-<?=$i?>" name="<?=$fid?><?=$makearray?>" <?=$atts?> value="<?=$val?>"/>
	          <option value="">Select</option>
	          <?php foreach( $options as $kitem => $vitem ){ ?>
	          <option value="<?php echo strtolower( $kitem ); ?>" <?php echo ( ( $selected == strtolower( $kitem ) )? 'selected' : '' ) ?>><?=$vitem?></option>
	          <?php } ?>
					</select>
					<?php
					break;
				}
				case "textarea":{
			    ?>
					<textarea id="<?=$fid?>-<?=$i?>" name="<?=$fid?><?=$makearray?>" <?=$atts?>/><?=$val?></textarea>
					<?php
					break;
				}
				case "keyval":{
          $i = 0;
          $pairs = array();
          foreach( $value as $key => $val ){
            if( $key%2 == 0 ){
              $i++;
              $pairs[ $i-1 ][ "key" ] = $val;
            } else {
              $pairs[ $i-1 ][ "val" ] = $val;
            }
          }
          //$value = ( ( $value )? array_combine( range( 1, count( $value ) ), array_values( $value ) ) : array() );
          $kvfield = $subtype;
			    ?>
          <div class="dtg-admin-field<?=$wrapclass?>"<?=$fielddata?>>
            <div id="keyval-outter-wrapper" class="dtg-keyval keyval-outter-wrapper">
              <div class="keyval-label-wrapper">
                <div class="keyval-field">Key</div>
                <div class="keyval-field">Value</div>
              </div>
              <?php
              $i=1;
              if( !empty( $pairs ) ){
                foreach( $pairs as $theval ){
                  ?>
                  <div id="keyval-container-<?=$i?>" class="field-container keyval-container">
                    <?php
                    foreach( $kvfield as $thefield ){
                      foreach( $thefield as $k => $v ){ ?>
                        <div class="keyval-field"><?php
                        $side = ( ( $i % 2 == 0)? 'val' : 'key' );
                        switch( $k ){
                          case "input":{ echo "<input type=\"".$v."\" id=\"".$fid."-".$side."-".$i."\" class=\"dtg-keyval ".$side."\" name=\"".$fid."[]\" value=\"".$theval[ $side ]."\" >"; break; }
                          case "select":{
                            echo "<select id=\"".$fid."-".$side."-".$i."\" class=\"dtg-keyval ".$side."\" name=\"".$fid."[]\" >";
                            echo "<option value=\"\">Select</option>";
                            foreach( $v as $kitem => $vitem ){
                              echo "<option value=\"".strtolower( $kitem )."\" ".( ( strtolower( $kitem ) == $theval[ $side ] )? 'selected' : '' )." >".$vitem."</option>";
                            }
                            echo "</select>";
                            break;
                          }
                          case "textarea":{ echo "<textarea id=\"".$fid."-".$side."-".$i."\" name=\"".$fid."[]\" />".$theval[ $side ]."</textarea>"; break; }
                        }
                      } ?>
                      </div>
                      <?php
                      $i++;
                    } ?>
                    <div class="keyval-revoker"><div class="dtg-character-keyval-revoker-icon dashicons dashicons-dismiss" data-revoker-field="keyval-container" data-revoker-id="1"></div></div>
                    <div class="keyval-repeater"><div class="dtg-character-keyval-repeater-icon dashicons dashicons-plus-alt" data-repeater-field="keyval-container" data-repeater-id="1"></div></div>
                  </div>
                  <?php
                }
              } else {
              ?>
              <div id="keyval-container-1" class="keyval-container">
                <?php
                $i=1;
                foreach( $kvfield as $thefield ){
                  foreach( $thefield as $k => $v ){ ?>
                    <div class="keyval-field"><?php
                    $side = ( ( $i % 2 == 0)? 'val' : 'key' );
                    switch( $k ){
                      case "input":{ echo "<input type=\"".$v."\" id=\"".$fid."-".$side."-1\" class=\"dtg-keyval ".$side."\" name=\"".$fid."[]\" value=\"\" >"; break; }
                      case "select":{
                        echo "<select id=\"".$fid."-".$side."-1\" class=\"dtg-keyval ".$side."\" name=\"".$fid."[]\" >";
                        echo "<option value=\"\">Select</option>";
                        foreach( $v as $kitem => $vitem ){
                          echo "<option value=\"".strtolower( $kitem )."\">".$vitem."</option>";
                        }
                        echo "</select>";
                        break;
                      }
                      case "textarea":{ echo "<textarea id=\"".$fid."-".$side."-1\" name=\"".$fid."[]\" /></textarea>"; break; }
                    }
                  } ?>
                  </div><?php
                  $i++;
                } ?>
                <div class="keyval-revoker"><div class="dtg-character-keyval-revoker-icon dashicons dashicons-dismiss" data-revoker-field="keyval-container" data-revoker-id="1"></div></div>
                <div class="keyval-repeater"><div class="dtg-character-keyval-repeater-icon dashicons dashicons-plus-alt" data-repeater-field="keyval-container" data-repeater-id="1"></div></div>
              </div>
              <?php } ?>
            </div>
					<?php
					break;
				}
			}
			?>
			<?=$revoke?>
			<?php
		}
		?>
		</div><?=$repeat?><?=$tooltip?>
		<?php
    $buffer =  ob_get_clean();

    //$buffer = preg_replace( $search, $replace, $buffer );
    echo $buffer;
	}

	/** AJAX **/

	/**
	 * AJAX save location
	 *
	 * @since    1.0.0
	 */
	public function dtg_save_location() {
		global $wpdb;
		$response = $this->dtg_get_response_container();
		$locjeeves = new DTG_Character_Location();
		$locjeeves->set_location_by_post( $_POST );
		try{
			if( $locjeeves->get_loc_primary() == "1" ){
				$locjeeves->unset_location_primary();
			}
			$result = "";
			if( $locjeeves->get_loc_lid() ){
				$response[ "message" ][ "action" ] = "update";
				$result = $locjeeves->update_location();
			} else {
				$response[ "message" ][ "action" ] = "insert";
				$result = $locjeeves->insert_location();
			}
			$response[ "message" ][ "result" ] = $result;
			array_push( $response[ "content" ], $result );
		} catch( Exception $e ){
			$response[ "error" ] = true;
			array_push( $response[ "message" ], $e );
		}
		wp_send_json( $response );
		unset( $locjeeves );
	}

	/** End AJAX **/

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
