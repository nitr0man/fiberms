$( document ).ready( function() {
    $( function() {
        $( "#menuBtn" ).click( function() {
            if ( $( this ).parent().css( "left" ) == "-170px" ) {
                $( this ).parent().animate( { left: '0px' },
                    { queue: false, duration: 500 } );
            } else {
                $( this ).parent().animate( { left: '-170px' },
                    { queue: false, duration: 500 } );
            }
        } );
    } );
} );
ddsmoothmenu.init( {
    mainmenuid: "smoothmenu1",
    orientation: 'v',
    classname: 'ddsmoothmenu-v',
    //customtheme: ["white", "black"],
    contentsource: "markup"
} );
