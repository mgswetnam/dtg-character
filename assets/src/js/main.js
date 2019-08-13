/*
 * -------------------
 * Copyright (c) 2019 Matthew Swetnam
 */
jQuery( document ).ready( function( $ ) {
  // Define variables
	if( $( '.dni-link' ).length ){
		var phoneid, dnivar, charmask, numformat, tag, servernum, defaultnum, lastresort, dnicode, reflist, httpref, refnum;
    if ( $( '.csa-dni' ).data( 'phone-id' ) ){ phoneid = $( '.csa-dni' ).data( 'phone-id' ); }
    if ( $( '.csa-dni' ).data( 'dni-var' ) ){ dnivar = $( '.csa-dni' ).data( 'dni-var' ); }
    if ( $( '.csa-dni' ).data( 'dni-tag' ) ){ tag = $( '.csa-dni' ).data( 'dni-tag' ); }
    if ( $( '.csa-dni' ).data( 'character-mask' ) ){ charmask = $( '.csa-dni' ).data( 'character-mask' ); }
		if ( $( '.csa-dni' ).data( 'phone-pattern' ) ){ numformat = $( '.csa-dni' ).data( 'phone-pattern' ); }
		if ( $( '.csa-dni' ).data( 'dni-number' ) ){ servernum = $( '.csa-dni' ).data( 'dni-number' ).toString(); }
		if ( $( '.csa-dni' ).data( 'phone-default' ) ){ defaultnum = $( '.csa-dni' ).data( 'phone-default' ).toString(); }
		if ( $( '.csa-dni' ).data( 'last-resort' ) ){ lastresort = $( '.csa-dni' ).data( 'last-resort' ).toString(); }
		if ( $( '.csa-dni' ).data( 'referrer-list' ) ){ reflist = $( '.csa-dni' ).data( 'referrer-list' ); }
		if ( $( '.csa-dni' ).data( 'referrer' ) ){ httpref = $( '.csa-dni' ).data( 'referrer' ).toString(); }
		if ( $( '.csa-dni' ).data( 'referrer-number' ) ){ refnum = $( '.csa-dni' ).data( 'referrer-number' ).toString(); }

		// If there's a querystring, get the DNI code from that
		if( typeof dnivar !== "undefined" && dnivar != '' ){
			dnicode=getParameterByName( dnivar );
			if( dnicode !== false ){
				createCookie( 'dni_tag',dnicode,30 );
			} else {
				// If there's no query string, get the DNI code from the cookie
				dnicode=readCookie( 'dni_tag' );
				if ( dnicode==null || dnicode=="null" ){
					dnicode=false;
				}
			}
		}
		// If there's no DNI code, use the default number
		if( dnicode === false ){
			if( defaultnum != servernum ){
				console.log( JSON.stringify( "DNI does not match. Correcting." ) );
				console.log( JSON.stringify( refnum, null, 4 ) );
				if( refnum !== '' ){
					var dni_number_formatted = format_number( refnum, numformat, charmask );
					if( dni_number_formatted !== false ){
						$( '.dni-link' ).each( function(){
							$( this ).attr( 'href','tel:'+refnum );
							$( this ).html( dni_number_formatted );
						} );
					}
				} else {
					var dni_number_formatted = format_number( defaultnum, numformat, charmask );
					if( dni_number_formatted !== false ){
						$( '.dni-link' ).each( function(){
							$( this ).attr( 'href','tel:'+defaultnum );
							$( this ).html( dni_number_formatted );
						} );
					}
				}
			} else {
				console.log( "Default DNI Match" );
			}
		} else {
			// Verify that the DNI number displayed is correct
			var thecode = ( typeof dnicode == false )? tag : dnicode;
      var postdata = get_dni_object( "csa_challenge_number", "", phoneid, "", thecode, "", "", "" );
      $.ajax( {
  			url: csa_ajaxobject.ajax_url,
  			type:'POST',
  			dataType: 'json',
  			data: postdata,
  			error: function(jqXHR, textStatus, errorThrown){
  				console.log( JSON.stringify( errorThrown, null, 4 ) );
  			},
  			success: function(data, textStatus, jqXHR){
          if( data.message == "success" ){
            var challengenum = data.content[ 0 ];
						if( challengenum != servernum ){
							console.log( JSON.stringify( "DNI does not match. Correcting." ) );
							console.log( JSON.stringify( refnum, null, 4 ) );
							var dni_number_formatted = format_number( challengenum, numformat, charmask );
							if( dni_number_formatted !== false ){
								$( '.dni-link' ).each( function(){
									$( this ).attr( 'href','tel:'+challengenum );
									$( this ).find( 'span' ).html( dni_number_formatted );
								} );
							}
						} else {
							console.log( "DNI Match" );
						}
          } else {
            console.log( JSON.stringify( "No records returned.", null, 4 ) );
          }
  			}
  		} );
		}
	}

  function createCookie(name, value, days) {
    var expires;
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
    } else {
      expires = "";
    }
    document.cookie = encodeURIComponent( name ) + "=" + encodeURIComponent( value ) + expires + "; path=/";
  }

  function readCookie( name ){
    var nameEQ = encodeURIComponent( name ) + "=";
    var ca = document.cookie.split(';');
    for ( var i = 0; i < ca.length; i++ ) {
        var c = ca[i];
        while ( c.charAt(0) === ' ' ) c = c.substring( 1, c.length );
        if ( c.indexOf(nameEQ) === 0 ) return decodeURIComponent( c.substring( nameEQ.length, c.length ) );
    }
    return null;
  }

  function eraseCookie( name ){
    createCookie(name, "", -1);
  }

  function getParameterByName( name, url ) {
  	if( !url ) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp( "[?&]" + name + "(=([^&#]*)|&|#|$)" ),
    results = regex.exec( url );
    if( !results ) return false;
    if( !results[2] ) return false;
    return decodeURIComponent( results[ 2 ].replace(/\+/g, " " ) );
  }

  function format_number( rawnumber, numformat, charmask ) {
    if( rawnumber.length === ( numformat.match( new RegExp( charmask,"g" ) ) || [] ).length ){
      var x=0;
      var nummask = "";
			var i;
      for( i=0; i < numformat.length; i++ ){
        if( numformat[i] == charmask ){
          nummask += rawnumber.charAt( x );
          x++;
        } else {
          nummask += numformat.charAt( i );
        }
      }
      if( nummask.indexOf( charmask ) === -1 ){
        return nummask;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  function get_dni_object( action, dniid, phoneid, locid, tag, dninum, desc, status ){
    var postdata = {
      "action":	action,
      "dni_id": dniid,
      "parent_phone_id": phoneid,
      "location_id": locid,
      "dni_tag": tag,
      "dni_number": dninum,
      "dni_description": desc,
      "dni_status": status
    };
    return postdata;
  }
} );
