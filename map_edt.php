<?php
require_once 'auth.php';
require_once 'backend/map.php';

if ( !checkSession() || $_SESSION[ 'class' ] > 1 )
{
    header( "Location: map.php" );
    exit();
}
setMapUserActivity();
$user_res = getCurrUserInfo();
$user = $user_res[ 'rows' ][ 0 ][ 'id' ];
//checkData();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Карта - FiberMS</title>
        <link rel="stylesheet" href="ext-all.css" type="text/css">
        <link rel="stylesheet" href="style/buttons.css" type="text/css">
        <link rel="stylesheet" href="map_edt.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="style/jquery.slidepanel.css">
        <style type="text/css">
            #controlToggle li {
                list-style: none;
            }
            /*#container {
                width: 100%;
                height: 100%;
                position: relative;
            }

            #sidebar, 
            #map {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
            }

            #sidebar {
                z-index: 10;
            }*/
        </style>
        <script type="text/javascript">
<?php
print 'var userId = '.$user.';';
?>
        </script>
        <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
        <script src="js/OpenLayers-2.12/OpenLayers.debug.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/ext-all.js"></script>
        <script type="text/javascript" src="js/noty/jquery.noty.js"></script>
        <script type="text/javascript" src="js/js_xml.js"></script>        
        <script type="text/javascript" src="js/map_edt_cableLine.js"></script>
        <script type="text/javascript" src="js/map_edt_node.js"></script>
        <script type="text/javascript" src="js/map_edt_singPoint.js"></script>
        <script type="text/javascript" src="js/map_edt_noty.js"></script>
        <script type="text/javascript" src="js/map_edt_parseXML.js"></script>
        <script type="text/javascript" src="js/noty/jquery.noty.js"></script>
        <script type="text/javascript" src="js/noty/layouts/center.js"></script>
        <script type="text/javascript" src="js/noty/themes/default.js"></script>
        <script type="text/javascript" src="js/noty/layouts/bottom.js"></script>
        <script type="text/javascript" src="js/noty/layouts/bottomCenter.js"></script>
        <script type="text/javascript" src="js/noty/layouts/bottomLeft.js"></script>
        <script type="text/javascript" src="js/noty/layouts/bottomRight.js"></script>
        <script type="text/javascript" src="js/noty/layouts/center.js"></script>
        <script type="text/javascript" src="js/noty/layouts/centerLeft.js"></script>
        <script type="text/javascript" src="js/noty/layouts/centerRight.js"></script>
        <script type="text/javascript" src="js/noty/layouts/inline.js"></script>
        <script type="text/javascript" src="js/noty/layouts/top.js"></script>
        <script type="text/javascript" src="js/noty/layouts/topCenter.js"></script>
        <script type="text/javascript" src="js/noty/layouts/topLeft.js"></script>
        <script type="text/javascript" src="js/noty/layouts/topRight.js"></script>
        <script type="text/javascript" src="js/map_edt.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <script type="text/javascript">
            $( document ).ready( function() {
                $( '[data-slidepanel]' ).slidepanel( {
                    orientation: 'left',
                    mode: 'overlay'
                } );
                $( '#menuBtn' ).click( function() {
                    $( '#menuBtn' ).hide();
                } );
            } );
            /*$( function() {
             var $sidebar = $( "#sidebar" ),
             $window = $( window ),
             offset = $sidebar.offset(),
             topPadding = 200;
             
             $window.scroll( function() {
             if ( $window.scrollTop() > offset.top ) {
             $sidebar.stop().animate( {
             marginTop: $window.scrollTop() - offset.top + topPadding
             } );
             } else {
             $sidebar.stop().animate( {
             marginTop: 0
             } );
             }
             } );
             
             } );*/
        </script>
    </head>
    <body>
        <div id="container">
            <div id="map"></div>
            <div id="sidebar">
                <a href="map_menu.html" data-slidepanel="panel" title="Меню">
                    <img src="pic/menu.png" id="menuBtn" />
                </a>
            </div>            
        </div>        
    </body>
</html>