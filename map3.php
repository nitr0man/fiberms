<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"-->
    <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Карта</title>
		<link rel="stylesheet" type="text/css" href="style_popup.css" />
		<link rel="stylesheet" href="style_popup2.css" type="text/css">
		<style type="text/css">
        #controlToggle li {
            list-style: none;
        }
    </style>
        <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
        <script src="js/OpenLayers_2.13.js"></script>
		<script type="text/javascript" src="js/MarkerGrid.js"></script>
		<script type="text/javascript" src="js/MarkerTile.js"></script>
		<script type="text/javascript" src="js/bounds.js"></script>
		<script type="text/javascript" src="js/js_xml.js"></script>
		<script type="text/javascript">
			var lat=48.5;
            var lon=32.24;
            var zoom=14;
			var map;
			var con;
						
			function init() {	
				map = new OpenLayers.Map({
					div: "map",
					projection: new OpenLayers.Projection("EPSG:4326"),
					displayProjection: new OpenLayers.Projection("EPSG:4326")/*,
					controls:[
						new OpenLayers.Control.MousePosition()
					],
					units: "m"/*,
					allOverlays: true*/
				});
            var localLayer = new OpenLayers.Layer.OSM("Локальна карта", "map/tiles/${z}/${x}/${y}.png", 
				{numZoomLevels: 19, 
				 alpha: false,
				 isBaseLayer: true,
				 attribution: "",
				});
            map.addLayer(localLayer);
			
			var osm = new OpenLayers.Layer.OSM();
			map.addLayers([osm]);			
			
			
			var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
            renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
		
			var vectors = new OpenLayers.Layer.Vector("Vector Layer", {
                renderers: renderer
            });

            map.addLayers([vectors]);			
            map.addControl(new OpenLayers.Control.LayerSwitcher());
            map.addControl(new OpenLayers.Control.MousePosition())
			if (console && console.log) {
                function report(event) {
                    console.log(event.type, event.feature ? event.feature.id : event.components);
                }
                vectors.events.on({
                    "beforefeaturemodified": report,
                    "featuremodified": report,
                    "afterfeaturemodified": report,
                    "vertexmodified": report,
                    "sketchmodified": report,
                    "sketchstarted": report,
                    "sketchcomplete": report
                });
            }
			con = {
                point: new OpenLayers.Control.DrawFeature(vectors,
                            OpenLayers.Handler.Point),
                line: new OpenLayers.Control.DrawFeature(vectors,
                            OpenLayers.Handler.Path),
                polygon: new OpenLayers.Control.DrawFeature(vectors,
                            OpenLayers.Handler.Polygon),
                regular: new OpenLayers.Control.DrawFeature(vectors,
                            OpenLayers.Handler.RegularPolygon,
                            {handlerOptions: {sides: 5}}),
                modify: new OpenLayers.Control.ModifyFeature(vectors)
            };
            
            for(key in con) {
                map.addControl(con[key]);
            }			
			
			var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
			map.setCenter (lonLat, zoom);	
			document.getElementById('noneToggle').checked = true;
		}		
		
		function update() {
				// reset modification mode
				con.modify.mode = OpenLayers.Control.ModifyFeature.RESHAPE;
				var rotate = document.getElementById("rotate").checked;
				if(rotate) {
					con.modify.mode |= OpenLayers.Control.ModifyFeature.ROTATE;
				}
				var resize = document.getElementById("resize").checked;
				if(resize) {
					con.modify.mode |= OpenLayers.Control.ModifyFeature.RESIZE;
					var keepAspectRatio = document.getElementById("keepAspectRatio").checked;
					if (keepAspectRatio) {
						con.modify.mode &= ~OpenLayers.Control.ModifyFeature.RESHAPE;
					}
				}
				var drag = document.getElementById("drag").checked;
				if(drag) {
					con.modify.mode |= OpenLayers.Control.ModifyFeature.DRAG;
				}
				if (rotate || drag) {
					con.modify.mode &= ~OpenLayers.Control.ModifyFeature.RESHAPE;
				}
				con.modify.createVertices = document.getElementById("createVertices").checked;
				var sides = parseInt(document.getElementById("sides").value);
				sides = Math.max(3, isNaN(sides) ? 0 : sides);
				con.regular.handler.sides = sides;
				var irregular =  document.getElementById("irregular").checked;
				con.regular.handler.irregular = irregular;
			}

			function toggleControl2(element) {
				alert(key);
				for(key in con) {
					var cons = con[key];
					if(element.value == key && element.checked) {
						cons.activate();
					} else {
						cons.deactivate();
					}
				}
			}		
	</script>	
    </head>
    <body onLoad="init()">
		<div id="map"></div><br>
		<div id="controls">
        <ul id="controlToggle">
            <li>
                <input type="radio" name="type" value="none" id="noneToggle"
                       onclick="toggleControl2(this);" checked="checked" />
                <label for="noneToggle">navigate</label>
            </li>
            <li>
                <input type="radio" name="type" value="point" id="pointToggle" onclick="toggleControl2(this);" />
                <label for="pointToggle">draw point</label>
            </li>
            <li>
                <input type="radio" name="type" value="line" id="lineToggle" onclick="toggleControl2(this);" />
                <label for="lineToggle">draw line</label>
            </li>
            <li>
                <input type="radio" name="type" value="polygon" id="polygonToggle" onclick="toggleControl2(this);" />
                <label for="polygonToggle">draw polygon</label>
            </li>
            <li>
                <input type="radio" name="type" value="regular" id="regularToggle" onclick="toggleControl2(this);" />
                <label for="regularToggle">draw regular polygon</label>
                <label for="sides"> - sides</label>
                <input id="sides" type="text" size="2" maxlength="2"
                       name="sides" value="5" onchange="update()" />
                <ul>
                    <li>
                        <input id="irregular" type="checkbox"
                               name="irregular" onchange="update()" />
                        <label for="irregular">irregular</label>
                    </li>
                </ul>
            </li>
            <li>
                <input type="radio" name="type" value="modify" id="modifyToggle"
                       onclick="toggleControl2(this);" />
                <label for="modifyToggle">modify feature</label>
                <ul>
                    <li>
                        <input id="createVertices" type="checkbox" checked
                               name="createVertices" onchange="update()" />
                        <label for="createVertices">allow vertices creation</label>
                    </li>
                    <li>
                        <input id="rotate" type="checkbox"
                               name="rotate" onchange="update()" />
                        <label for="rotate">allow rotation</label>
                    </li>
                    <li>
                        <input id="resize" type="checkbox"
                               name="resize" onchange="update()" />
                        <label for="resize">allow resizing</label>
                        (<input id="keepAspectRatio" type="checkbox"
                               name="keepAspectRatio" onchange="update()" checked="checked" />
                        <label for="keepAspectRatio">keep aspect ratio</label>)
                    </li>
                    <li>
                        <input id="drag" type="checkbox"
                               name="drag" onchange="update()" />
                        <label for="drag">allow dragging</label>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    </body>
</html>