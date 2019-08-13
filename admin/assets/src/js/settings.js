jQuery( document ).ready( function( $ ){
  console.log( "DTG Character Base" );
  refresh_icons()


  function refresh_icons(){
    $( ".dtg-character-keyval-repeater-icon" ).off();
    $( ".dtg-character-keyval-repeater-icon" ).on( "click", function(){
      repeat_field( this );
    } );
    $( ".dtg-character-keyval-revoker-icon" ).off();
    $( ".dtg-character-keyval-revoker-icon" ).on( "click", function(){
      revoke_field( this );
    } );
  }
  function repeat_field( repeatfield ){
    var rfield = $( repeatfield ).data( "repeater-field" );
    var lastinput = $( ".dtg-settings-wrapper div[id^='keyval-container-']:last" ).attr( "id" );
    var num = parseInt( lastinput.substring( lastinput.lastIndexOf( "-" ) + 1 ) );
    num++;
    var newfield = $( "#" + lastinput ).clone();
    newfield.attr( "id", rfield + "-" + num );
    newfield.find( ".dtg-character-keyval-repeater-icon" ).data( "repeater-id", num );
    newfield.find( ".dtg-character-keyval-revoker-icon" ).data( "revoker-id", num );
    newfield.find( "input" ).val( "" );
    newfield.find( "select" ).val( "" );
    $( "#keyval-outter-wrapper" ).append( newfield );
    refresh_icons();
  }
  function revoke_field( revokefield ){
    var rid = parseInt( $( revokefield ).data( "revoker-id" ) );
    var rfield = $( revokefield ).data( "revoker-field" );
    $( "#" + rfield + "-" + rid ).remove();
  }
} );
