<?php
require_once("auth.php");
createTmpTables();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Карта - FiberMS</title>
        <link rel="stylesheet" href="ext-all.css" type="text/css">
        <link rel="stylesheet" href="style/buttons.css" type="text/css">
        <link rel="stylesheet" href="map_edt.css" type="text/css">
        <style type="text/css">
            #controlToggle li {
                list-style: none;
            }
        </style>
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
    </head>
    <body>
        <div id="map"></div>
    </body>
</html>