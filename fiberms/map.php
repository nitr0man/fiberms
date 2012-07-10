<?php

?>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"-->
    <meta name="apple-mobile-web-app-capable" content="yes">
        <title>OpenLayers All Overlays with Google and OSM</title>
		<link rel="stylesheet" href="map_css/style.css" type="text/css">
        <link rel="stylesheet" href="map_css/google.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="style_map.css" />
		<link rel="stylesheet" type="text/css" href="style_popup.css" />
		<link rel="stylesheet" href="style_popup2.css" type="text/css">
		<style type="text/css">
        #controlToggle li {
            list-style: none;
        }
    </style>
        <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
        <script src="js/OpenLayers.js"></script>
		<script type="text/javascript" src="js/MarkerGrid.js"></script>
		<script type="text/javascript" src="js/MarkerTile.js"></script>
		<script type="text/javascript" src="js/bounds.js"></script>
		<script type="text/javascript">
			var lat=48.5;
            var lon=32.24;
            var zoom=14;
			var map;
			var drawControls, selectControl, selectedFeature, lineLayer;
			var CableLineText_arr = Array();
			
			
			
			function toggleControl(element) {
				alert(element);
				for(key in drawControls) {
					var control = drawControls[key];
					if(element.value == key && element.checked) {					
						control.activate();
					} else {
						control.deactivate();
					}
				}
			}
			
			function onPopupClose(evt) {
				selectControl.unselect(selectedFeature);
			}
			function onPopupClose2(evt) {
                 // 'this' is the popup.
                 selectControl.unselect(this.feature);
            }
			function onFeatureSelect(evt) {			
				/*selectedFeature = feature;
				id = feature.id;				
				var lonlat = map.getLonLatFromPixel(map.getControlsByClass("OpenLayers.Control.MousePosition")[0].lastXy);

				popup = new OpenLayers.Popup.FramedCloud("chicken", 
														lonlat,
														null,
														"<div style='font-size:.8em'>" +CableLineText_arr[id] +"</div>",
														null, true, onPopupClose);
				feature.popup = popup;
				map.addPopup(popup);*/
				feature = evt.feature;
				id = feature.id;
				var lonlat = map.getLonLatFromPixel(map.getControlsByClass("OpenLayers.Control.MousePosition")[0].lastXy);
                popup = new OpenLayers.Popup.FramedCloud("featurePopup",
                                          lonlat,
                                          new OpenLayers.Size(100,100),
                                          "<h2>"+feature.attributes.title + "</h2>" +
                                          CableLineText_arr[id],
                                          null, true, onPopupClose2);
                 feature.popup = popup;
                 popup.feature = feature;
                 map.addPopup(popup);
			}
			/*function onFeatureUnselect(feature) {
				map.removePopup(feature.popup);
				feature.popup.destroy();
				feature.popup = null;
			}*/
			
			function onFeatureUnselect(evt) {
				feature = evt.feature;
                 if (feature.popup) {
                     popup.feature = null;
                     map.removePopup(feature.popup);
                     feature.popup.destroy();
                     feature.popup = null;
                 }
			}
			
			function onFeatureSelect2(evt) {
                 feature = evt.feature;
                 popup = new OpenLayers.Popup.FramedCloud("featurePopup",
                                          feature.geometry.getBounds().getCenterLonLat(),
                                          new OpenLayers.Size(100,100),
                                          "<h2>"+feature.attributes.title + "</h2>" +
                                          feature.attributes.description,
                                          null, true, onPopupClose2);
                 feature.popup = popup;
                 popup.feature = feature;
                 map.addPopup(popup);
              }
              function onFeatureUnselect2(evt) {
                 feature = evt.feature;
                 if (feature.popup) {
                     popup.feature = null;
                     map.removePopup(feature.popup);
                     feature.popup.destroy();
                     feature.popup = null;
                 }
              }
			function init() {
				map = new OpenLayers.Map({
					div: "map",
					projection: new OpenLayers.Projection("EPSG:4326"),
					displayProjection: new OpenLayers.Projection("EPSG:4326"),
					controls:[
						new OpenLayers.Control.MousePosition()
					],
					units: "m",
					allOverlays: true
				});

			var osm = new OpenLayers.Layer.OSM();
			map.addLayers([osm]);
	
	//
			lineLayer = new OpenLayers.Layer.Vector("Кабельные линии"); 
			map.addLayer(lineLayer);                    
			//map.addControl(new OpenLayers.Control.DrawFeature(lineLayer, OpenLayers.Handler.Path));
			
	
			var style = {  // стиль медных кабелей
				strokeColor: 'blue',
				//strokeOpacity: 5.5
				strokeWidth: 5
			};
	
			<?php // медные кабели
				require_once('backend/CableType.php');
	
				$res = getCopperCableLines();
				$rows = $res['rows'];
				for ($i = 0; $i < count($res['count']); $i++) {
					$OpenGIS = $rows[$i]['OpenGIS'];
					if (preg_match_all('/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches)) {
						for ($j = 0; $j < count($matches[0]); $j++) {
							if (strlen($points) > 0) {
								$points .= ',';
							}
							$points .= "\t".'new OpenLayers.Geometry.Point('.$matches['x'][$j].', '.$matches['y'][$j].')';
						}
					}
					$js_text  = 'var points = new Array('."\n";
					$js_text .= $points."\n";
					$js_text .= ');'."\n";
			
					$js_text .= 'var line = new OpenLayers.Geometry.LineString(points);'."\n";
					$js_text .= 'line.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));'."\n";
					$js_text .= 'var lineFeature = new OpenLayers.Feature.Vector(line, null, style);'."\n";
					$js_text .= 'lineLayer.addFeatures([lineFeature]);'."\n";
					$js_text .= "CableLineText_arr[lineFeature.id]='Имя: ".$rows[$i]['name']."<br>Комментарий: ".nl2br($rows[$i]['comment'])."';"."\n";
				}
				print($js_text);
			?>
			
			var style2 = {  // стиль обычных кабелей
				strokeColor: 'white',
				//strokeOpacity: 5.5
				strokeWidth: 5
			};
	
			<?php // обычные кабели
				require_once('backend/CableType.php');
				$points = '';
				$js_text = '';
	
				$res = getNormalCableLines();
				$rows = $res['rows'];
				for ($i = 0; $i < count($res['count']); $i++) {
					$OpenGIS = $rows[$i]['OpenGIS'];
					if (preg_match_all('/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches)) {
						for ($j = 0; $j < count($matches[0]); $j++) {
							if (strlen($points) > 0) {
								$points .= ',';
							}
							$points .= "\t".'new OpenLayers.Geometry.Point('.$matches['x'][$j].', '.$matches['y'][$j].')';
						}
					}
					$js_text  = 'var points = new Array('."\n";
					$js_text .= $points."\n";
					$js_text .= ');'."\n";
			
					$js_text .= 'var line = new OpenLayers.Geometry.LineString(points);'."\n";
					$js_text .= 'line.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));'."\n";
					$js_text .= 'var lineFeature = new OpenLayers.Feature.Vector(line, null, style2);'."\n";
					$js_text .= 'lineLayer.addFeatures([lineFeature]);'."\n";
					$js_text .= "CableLineText_arr[lineFeature.id]='Имя: ".$rows[$i]['name']."<br>Комментарий: ".nl2br($rows[$i]['comment'])."';"."\n";
				}
				print($js_text);
			?>
				
			/*var lineLayer = new OpenLayers.Layer.Vector("Line Layer"); 
			map.addLayer(lineLayer);                    
			map.addControl(new OpenLayers.Control.DrawFeature(lineLayer, OpenLayers.Handler.Path));
	
			var points = new Array(
				new OpenLayers.Geometry.Point(47, 32.24),
				new OpenLayers.Geometry.Point(45, 33),
				new OpenLayers.Geometry.Point(49, 35)
			);

			var line = new OpenLayers.Geometry.LineString(points);
			line.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));

			var style = { 
				strokeColor: '#0000ff', 
				strokeOpacity: 0.5,
				strokeWidth: 5
			};

			var lineFeature = new OpenLayers.Feature.Vector(line, null, style);
			alert(lineFeature.id);
			lineLayer.addFeatures([lineFeature]);*/
	
	
	
	/*var points = new Array(
		new OpenLayers.Geometry.Point(47, 32.24),
		new OpenLayers.Geometry.Point(32.24, 48.5)
	);

	var line = new OpenLayers.Geometry.LineString(points);
	line.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));

	var style = { 
		strokeColor: '#0000ff', 
		strokeOpacity: 0.5,
		strokeWidth: 5
	};

	var lineFeature = new OpenLayers.Feature.Vector(line, null, style);
	alert(lineFeature.id);
	lineLayer.addFeatures([lineFeature]);
	
	var click = new OpenLayers.Control.Click();
    map.addControl(click);
    click.activate();*/
	//map.events.register('click', map, handleMapClick);

	/*function handleMapClick(e) {
		var lonlat = map.getLonLatFromViewPortPx(e.xy);
		// use lonlat

		// If you are using OpenStreetMap (etc) tiles and want to convert back 
		// to gps coords add the following line :-
		// lonlat.transform( map.projection,map.displayProjection);
		
		// Longitude = lonlat.lon
		// Latitude  = lonlat.lat
		alert(lonlat.lon);
	}*/
	/*var options = {
    onSelect: getCoordinates,
	};

	var selectEt = new OpenLayers.Control.SelectFeature(lineLayer, options);
	map.addControl(selectEt);*/


	
	
	//selectControl.activate();
			 
			/*selectControl = new OpenLayers.Control.SelectFeature(lineLayer,
					{onSelect: onFeatureSelect, onUnselect: onFeatureUnselect});
			
			drawControls = {
                select: selectControl
            };
			
			for(var key in drawControls) {	
					map.addControl(drawControls[key]);				
					var control = drawControls[key];
					control.activate();
				}	*/
			
			
			/*map.events.register("click", map , function(e){
				var opx = map.getLonLatFromPixel(e.xy) ;
				var marker = new OpenLayers.Marker(lonLat);
				selectControl = new OpenLayers.Control.SelectFeature(lineLayer,
					{onSelect: onFeatureSelect, onUnselect: onFeatureUnselect});
				drawControls = {
						select: selectControl
					};			
				for(var key in drawControls) {	
					map.addControl(drawControls[key]);				
					var control = drawControls[key];
					control.activate();
				}
			});*/
	
	//
		
			/*var lookup = {};
				lookup[0] = {fillOpacity: 10, strokeWidth: 10};
				lookup[1] = {fillColor: "#33ff33", fillOpacity: 10.4, strokeColor: "blue", strokeWidth: 1.7}; // вид медных кабелей
            
            var context = function(feature) {
                return feature;
            }
	
	var mystyle = new OpenLayers.StyleMap({
		"default": new OpenLayers.Style({
		    pointRadius: 100,
		})
	    });
	    mystyle.addUniqueValueRules("default", "ported", lookup, context);
	    
            var layer = new OpenLayers.Layer.Vector("Линии (медь)", {
                    strategies: [new OpenLayers.Strategy.Fixed()],
		    styleMap: mystyle,
                    protocol: new OpenLayers.Protocol.HTTP({
                        url: "get_layers.php?mode=GetCableLines&type=1",   // получение кабельных линий (медь)
                        format: new OpenLayers.Format.OSM()
                    }),
                    //maxResolution: 10,
                    projection: new OpenLayers.Projection("EPSG:4326")
            });
 
            map.addLayers([layer]);
			
	var lookup = {};
	    lookup[0] = {fillOpacity: 10, strokeWidth: 10};
            lookup[1] = {fillColor: "#33ff33", fillOpacity: 10.4, strokeColor: "white", strokeWidth: 1.7}; // вид обычных кабелей
            
            var context = function(feature) {
                return feature;
            }
	var mystyle = new OpenLayers.StyleMap({
		"default": new OpenLayers.Style({
		    pointRadius: 100,
		})
	    });
	    mystyle.addUniqueValueRules("default", "ported", lookup, context);
	
            var layer = new OpenLayers.Layer.Vector("Линии (обычные)", {
                    strategies: [new OpenLayers.Strategy.Fixed()],
		    styleMap: mystyle,
                    protocol: new OpenLayers.Protocol.HTTP({
                        url: "get_layers.php?mode=GetCableLines&type=2",   // получение кабельных линий (обычные)
                        format: new OpenLayers.Format.OSM()
                    }),
                    //maxResolution: 10,
                    projection: new OpenLayers.Projection("EPSG:4326")
            });
 
            map.addLayers([layer]);*/
			
			var stylePoint = new OpenLayers.Style( // стили для надписей узлов
				{ 
					//pointRadius: 5,
					//strokeColor: "red",
					strokeWidth: 2,
					//fillColor: "lime",
					labelYOffset: 10+24,
					label: "${label}",
					fontColor: 'red',
					fontSize: 16 
				});
			var vectorPoint = new OpenLayers.Layer.Vector("Узлы (надписи)",
			{
				styleMap: new OpenLayers.StyleMap(
				{ "default": stylePoint,
				"select": { pointRadius: 20}
				})
			});
			map.addLayer(vectorPoint );
	
			function addPoint(lon,lat,title,ident,layr){
				var ttt = new OpenLayers.LonLat(parseFloat(lon), parseFloat(lat));
				ttt.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
				for (var k = 0; k < layr.features.length; k++) {
					if(layr.features[k].attributes.PointId==ident) {
						layr.features[k].move(ttt);
						layr.features[k].attributes.label=title;
						return false;		
					}
				}
				var point0 = new OpenLayers.Geometry.Point(parseFloat(lon), parseFloat(lat));
				point0.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
				layr.addFeatures(new OpenLayers.Feature.Vector(point0, { label: title, name: title, PointId: ident }));
			}	
		//	addPoint(32.24,48.5,'jjhhn','1',map.layers[5]);	
			<?php
				require_once('backend/NetworkNode.php');

				$res = getNetworkNodeList_NetworkBoxName('', '', '');
				$rows = $res['rows'];
				for ($i = 0; $i < $res['count']; $i++) {
					$OpenGIS = $rows[$i]['OpenGIS'];
					if (preg_match_all('/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches)) {
						for ($j = 0; $j < count($matches[0]); $j++) {
							$lat         = $matches['y'][$j];
							$lon         = $matches['x'][$j];
							$title       = $rows[$i]['name'];
							print("addPoint(".$lon.",".$lat.",'".$title."','".$i."',map.layers[2]);");
						}
					}
				}	
			?>			
			
			/*var pois = new OpenLayers.Layer.Text( "Узлы (маркеры)",
						{ location: "get_layers.php?mode=GetNodesMarkers", //get_layers.php?mode=GetNodesMarkers
						projection: map.displayProjection
						});*/
			/*var pois = new OpenLayers.Layer.Vector("Узлы (маркеры)", {
                    protocol: new OpenLayers.Protocol.HTTP({
                        url: "get_layers.php?mode=GetNodesMarkers",
                        format: new OpenLayers.Format.Text()
                    })
                });*/
			//map.addLayer(pois);
			
			var layerPOI = new OpenLayers.Layer.Vector("POIs", {
                strategies : [new OpenLayers.Strategy.BBOX({resFactor: 1.1})],
                protocol   : new OpenLayers.Protocol.HTTP({
                    url    : "get_layers.php?mode=GetNodesMarkers",
                    format : new OpenLayers.Format.Text()
                })
            });
            map.addLayer(layerPOI);
			selectControl = new OpenLayers.Control.SelectFeature([layerPOI,lineLayer]);
            map.addControl(selectControl);
            selectControl.activate();
			 
			lineLayer.events.on({
                'featureselected'   : onFeatureSelect,
                'featureunselected' : onFeatureUnselect
            });
                 
            layerPOI.events.on({
                'featureselected'   : onFeatureSelect2,
                'featureunselected' : onFeatureUnselect2
            });
          
                 

				 
				 /*selectControl2 = new OpenLayers.Control.SelectFeature(lineLayer);
                 map.addControl(selectControl2);
                 selectControl2.activate();
                 lineLayer.events.on({
                    'featureselected'   : onFeatureSelect,
                    'featureunselected' : onFeatureUnselect
                 });
				 
                 selectControl = new OpenLayers.Control.SelectFeature(layerPOI);
                 map.addControl(selectControl);
                 selectControl.activate();
                 layerPOI.events.on({
                    'featureselected'   : onFeatureSelect2,
                    'featureunselected' : onFeatureUnselect2
                 });*/
			
			
				 
						 
			
			
			
			/*selectControl = new OpenLayers.Control.SelectFeature([lineLayer,pois],{onSelect: onFeatureSelect, onUnselect: onFeatureUnselect});
			drawControls = {
						select: selectControl
					};
			
            for(var key in drawControls) {	
                map.addControl(drawControls[key]);				
				var control = drawControls[key];
				control.activate();
            }*/
			
			/*var selectControl = new OpenLayers.Control.SelectFeature(lineLayer);
			map.addControl(selectControl);
			selectControl.activate();

			lineLayer.events.on({
				'featureselected': onFeatureSelect,
				'featureunselected': onFeatureUnselect
			});*/
			
			/*var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
			var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);

    map.events.register("click", map , function(e){
   var opx = map.getLonLatFromPixel(e.xy) ;
   var marker = new OpenLayers.Marker(lonLat);
   markers.addMarker(marker);
   marker.events.register("click", marker, function(e){
   popup = new OpenLayers.Popup.FramedCloud("chicken",
                         marker.lonlat,
                         new OpenLayers.Size(200, 200),
                         "example popup",
                         null, true);


map.addPopup(popup);
	}); 
});*/
			map.addControls(
				[
					new OpenLayers.Control.LayerSwitcher(),
					new OpenLayers.Control.Navigation(),
					new OpenLayers.Control.Attribution(),
					new OpenLayers.Control.PanZoomBar(),
					new OpenLayers.Control.MousePosition()
				]
			);
			var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
			map.setCenter (lonLat, zoom);	
			//toggleControl('noneToogle', 'selectToogle');
			//toogleControl('selectToogle');

		}		
        
	</script>
	<?php /*print('<iframe width="0" height="0" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="get_layers.php?mode=GetNodesLabels"></iframe>'); */?>
    </head>
    <body onload="init()">
        <div id="map"></div><br>
	<!--ul id="controlToggle">
        <li>
            <input type="radio" name="type" value="none" id="noneToggle"
                   onclick="toggleControl(this);" checked="checked" />
            <label for="noneToggle">navigate</label>
        </li>
        <li>
            <input type="radio" name="type" value="polygon" id="polygonToggle"
                   onclick="toggleControl(this);" />
            <label for="polygonToggle">draw polygon</label>
        </li>
        <li>
            <input type="radio" name="type" value="select" id="selectToggle"
                   onclick="toggleControl(this);" />
            <label for="selectToggle">select polygon on click</label>
        </li>
    </ul-->	

    </body>
</html>

<?php

?>