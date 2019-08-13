jQuery( document ).ready( function( $ ){
  $( ".dtg-numrange.time" ).on( "change", function(){
    var timeval = $( this ).val();
    if( timeval.length == 1 ){
      $( this ).val( '0'+timeval );
    }
  } );
} );
