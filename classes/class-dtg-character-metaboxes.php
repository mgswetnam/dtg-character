<?php

/**
 * Metabox factory for DTG Character
 * @class DTG_Character_Metaboxes
 */

final class DTG_Character_Metaboxes {

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

	static public function dtg_add_meta_boxes(){
		global $post;
    include DTG_CHARACTER_PLUGIN_DIR ."includes/metaboxes.php";
		foreach( $metaboxes as $value ){
			add_meta_box( $value[ "mbid" ], $value[ "mbtitle" ], array( __CLASS__, 'dtg_add_custom_fields' ), $value[ "mbscreen" ], $value[ "mbcontext" ], $value[ "mbpriority" ], $value[ "fields" ] );
		}
	}

  public static function dtg_add_custom_fields( $post, $args ){
		global $post;
		$custom = get_post_custom( $post->ID );

		$search = array( '/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/' );
		$replace = array( '>', '<', '\\1', '' );

		ob_start();
    ?>
    <div class="dtg-admin">
    <?php
		foreach( $args[ "args" ] as $field ){
			$fieldval = ( ( array_key_exists( "fid", $field ) )? $field[ "fid" ] : NULL );
      $fielddef = ( ( array_key_exists( "fdefault", $field ) )? $field[ "fdefault" ] : "" );
			$value = ( ( $fieldval && array_key_exists( $fieldval, $custom ) )? ( ( array_key_exists( 0, $custom[ $fieldval ] ) )? $custom[ $fieldval ][ 0 ] : "" ) : "" );
			$value = ( ( $value == "" && $fielddef != "" )? $fielddef  : $value );
      $atts = "";
      $options = array();
			foreach( $field[ "attributes" ] as $k=>$v ){
        if( $k == "options" ){
          $options = $v;
        } else {
          $atts .= $k . "=\"" . $v . "\" ";
        }
			}
			switch( $field[ "ftype" ] ){
				case "input":{
          switch( $field[ "fsubtype" ] ){
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
              <div class="dtg-admin-field<?=( ( array_key_exists( "fwrapclass", $field ) )? " ".$field[ 'fwrapclass' ] : "" )?>">
      					<label for="<?=$field[ 'fid' ]?>"><?=$field[ 'flabel' ]?>  </label></br>
      					<input type="<?=$field[ 'fsubtype' ]?>" name="<?=$field[ 'fid' ]?>" <?=$atts?><?php echo ( ( array_key_exists( 'fdata', $field ) )? " data-field-data=\"".$field[ 'fdata' ]."\"" : "" );?> data-field-value="<?=$value?>" value="<?=$value?>" />
              </div>
    					<?php
    					break;
            }
    				case "radio":{
              $i=0;
    			    ?>
              <div class="dtg-admin-field<?=( ( array_key_exists( "fwrapclass", $field ) )? " ".$field[ 'fwrapclass' ] : "" )?>">
                <label for="<?=$field[ 'fid' ]?>"><?=$field[ 'flabel' ]?>  </label></br>
                <?php foreach( $options as $kitem => $vitem ){ ?>
      					<label for="<?=$field[ 'fid' ]?>-<?=$i?>"><input type="<?=$field[ 'fsubtype' ]?>" id="<?=$field[ 'fid' ]?>-<?=$i?>" name="<?=$field[ 'fid' ]?>" <?=$atts?> <?php echo ( ( $value == $kitem )? 'checked' : '' ); ?> value="<?php echo strtolower( $kitem ); ?>" /><?=$vitem?></label><br/>
                <?php
                $i++;
                } ?>
              </div>
              <?php
    					break;
    				}
    				case "checkbox":{
              $i=0;
              $value = unserialize( $value );
    			    ?>
              <div class="dtg-admin-field<?=( ( array_key_exists( "fwrapclass", $field ) )? " ".$field[ 'fwrapclass' ] : "" )?>">
                <label for="<?=$field[ 'fid' ]?>"><?=$field[ 'flabel' ]?>  </label></br>
                <?php foreach( $options as $kitem => $vitem ){ ?>
      					<label for="<?=$field[ 'fid' ]?>-<?=$i?>"><input type="<?=$field[ 'fsubtype' ]?>" id="<?=$field[ 'fid' ]?>-<?=$i?>" name="<?=$field[ 'fid' ]?>[]" <?=$atts?> <?php echo ( ( is_array( $value ) )? ( ( in_array( strtolower( $kitem ), $value ) )? 'checked' : '' ) : '' ); ?> value="<?php echo strtolower( $kitem ); ?>" /><?=ucfirst( $vitem )?></label><br/>
                <?php
                $i++;
                } ?>
              </div>
              <?php
    					break;
    				}
          }
					break;
				}
				case "select":{
          $selected = ( ( $value != "" )? $value : ( ( $field[ 'fdefault' ] != "" )? $field[ 'fdefault' ] : "" ) );
			    ?>
          <div class="dtg-admin-field<?=( ( array_key_exists( "fwrapclass", $field ) )? " ".$field[ 'fwrapclass' ] : "" )?>">
  					<label for="<?=$field[ 'fid' ]?>"><?=$field[ 'flabel' ]?>  </label></br>
  					<select name="<?=$field[ 'fid' ]?>" <?=$atts?><?php echo ( ( array_key_exists( 'fdata', $field ) )? " data-field-data=\"".$field[ 'fdata' ]."\"" : "" );?> data-field-value="<?=$value?>" />
              <option value="">Select</option>
              <?php foreach( $options as $kitem => $vitem ){ ?>
              <option value="<?php echo strtolower( $kitem ); ?>" <?php echo ( ( $selected == strtolower( $kitem ) )? 'selected' : '' ) ?>><?=$vitem?></option>
              <?php } ?>
  					</select>
          </div>
					<?php
					break;
				}
				case "textarea":{
			    ?>
          <div class="dtg-admin-field<?=( ( array_key_exists( "fwrapclass", $field ) )? " ".$field[ 'fwrapclass' ] : "" )?>">
            <label for="<?=$field[ 'fid' ]?>"><?=$field[ 'flabel' ]?>  </label></br>
            <textarea name="<?=$field[ 'fid' ]?>"<?php echo ( ( array_key_exists( 'fdata', $field ) )? " data-field-data=\"".$field[ 'fdata' ]."\"" : "" );?> <?=$atts?> data-field-value="<?=$value?>" ><?=$value?></textarea>
          </div>
					<?php
					break;
				}
				case "keyval":{
          $value = ( ( $value )? unserialize( $value ) : array() );
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
          $kvfield = ( ( array_key_exists( 'fsubtype', $field ) )? $field[ 'fsubtype' ] : NULL );
			    ?>
          <div class="dtg-admin-field<?=( ( array_key_exists( "fwrapclass", $field ) )? " ".$field[ 'fwrapclass' ] : "" )?>"<?php echo ( ( array_key_exists( 'fdata', $field ) )? " data-field-data=\"".$field[ 'fdata' ]."\"" : "" );?>>
  					<label for="<?=$field[ 'fid' ]?>-1"><?=$field[ 'flabel' ]?>  </label></br>
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
                  <div id="keyval-container-<?=$i?>" class="keyval-container">
                    <?php
                    foreach( $kvfield as $thefield ){
                      foreach( $thefield as $k => $v ){ ?>
                        <div class="keyval-field"><?php
                        $side = ( ( $i % 2 == 0)? 'val' : 'key' );
                        switch( $k ){
                          case "input":{ echo "<input type=\"".$v."\" id=\"".$field[ 'fid' ]."-".$side."-".$i."\" class=\"dtg-keyval ".$side."\" name=\"".$field[ 'fid' ]."[]\" value=\"".$theval[ $side ]."\" >"; break; }
                          case "select":{
                            echo "<select id=\"".$field[ 'fid' ]."-".$side."-".$i."\" class=\"dtg-keyval ".$side."\" name=\"".$field[ 'fid' ]."[]\" >";
                            echo "<option value=\"\">Select</option>";
                            foreach( $v as $kitem => $vitem ){
                              echo "<option value=\"".strtolower( $kitem )."\" ".( ( strtolower( $kitem ) == $theval[ $side ] )? 'selected' : '' )." >".$vitem."</option>";
                            }
                            echo "</select>";
                            break;
                          }
                          case "textarea":{ echo "<textarea name=\"".$field[ 'fid' ]."-".$side."-".$i."\" />".$theval[ $side ]."</textarea>"; break; }
                        }
                      } ?>
                      </div>
                      <?php
                      $i++;
                    } ?>
                    <div class="keyval-revoker"><div class="dtg-character-team-revoker-icon dashicons dashicons-dismiss" data-revoker-field="keyval-container" data-revoker-id="1"></div></div>
                    <div class="keyval-repeater"><div class="dtg-character-team-repeater-icon dashicons dashicons-plus-alt" data-repeater-field="keyval-container" data-repeater-id="1"></div></div>
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
                      case "input":{ echo "<input type=\"".$v."\" id=\"".$field[ 'fid' ]."-".$side."-1\" class=\"dtg-keyval ".$side."\" name=\"".$field[ 'fid' ]."[]\" value=\"\" >"; break; }
                      case "select":{
                        echo "<select id=\"".$field[ 'fid' ]."-".$side."-1\" class=\"dtg-keyval ".$side."\" name=\"".$field[ 'fid' ]."[]\" >";
                        echo "<option value=\"\">Select</option>";
                        foreach( $v as $kitem => $vitem ){
                          echo "<option value=\"".strtolower( $kitem )."\">".$vitem."</option>";
                        }
                        echo "</select>";
                        break;
                      }
                      case "textarea":{ echo "<textarea name=\"".$field[ 'fid' ]."-".$side."-1\" /></textarea>"; break; }
                    }
                  } ?>
                  </div><?php
                  $i++;
                } ?>
                <div class="keyval-revoker"><div class="dtg-character-team-revoker-icon dashicons dashicons-dismiss" data-revoker-field="keyval-container" data-revoker-id="1"></div></div>
                <div class="keyval-repeater"><div class="dtg-character-team-repeater-icon dashicons dashicons-plus-alt" data-repeater-field="keyval-container" data-repeater-id="1"></div></div>
              </div>
              <?php } ?>
            </div>
					<?php
					break;
				}
			}
		}
    ?>
    </div>
    <?php
    $buffer =  ob_get_clean();

    //$buffer = preg_replace( $search, $replace, $buffer );
    echo $buffer;
	}

	public function dtg_save_custom_fields(){
		global $post;
    include DTG_CHARACTER_PLUGIN_DIR ."includes/metaboxes.php";
    // Set variables
		$pid = ( ( $post )? $post->ID : NULL );
    $custom_fields = array();
    $args = NULL;
    // Get field ID from metabox array
    foreach( $metaboxes as $value ){
      $args = ( ( array_key_exists( "fields", $value ) )? $value[ "fields" ] : NULL );
      foreach( $args as $field ){
        $fid = ( ( array_key_exists( "fid", $field ) )? $field[ "fid" ] : NULL );
        array_push( $custom_fields, $fid );
      }
    }
    // Process all fields in array
    if( $args ){
      foreach( $custom_fields as $field ){
        if( $content = ( ( array_key_exists( $field, $_POST ) )? $_POST[ $field ] : "" ) ){
          update_post_meta( $pid, $field, $content );
        }
      }
    }
	}

}
