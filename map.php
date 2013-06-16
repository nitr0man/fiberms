<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!--meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"-->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Карта - FiberMS</title>
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
        <script type="text/javascript" src="js/js_xml.js"></script>
        <script type="text/javascript">
            var lat = 48.5;
            var lon = 32.24;
            var zoom = 14;
            var map;
            var drawControls, selectControl, selectedFeature, lineLayer;
            var CableLineText_arr = Array();
            var CableLine_arr = { };
            var j = 0, j2 = 0;
            var CableLine_Points_count = Array();
            var nodesLabels_Count = 0;
            var nodesLabels_arr = Array();
            var nodeDescription_arr = Array();
            var style_arr = Array( {
                // Стиль линии (0 волокон)
                strokeColor: 'blue',
                //strokeOpacity: 5.5
                strokeWidth: 2
                        // Стиль линии (0 волокон)
            },
            {
                // Стиль линии (1-8 волокон)
                strokeColor: 'white',
                //strokeOpacity: 5.5
                strokeWidth: 2
                        // Стиль линии (1-8 волокон)
            },
            {
                // Стиль линии (9-24 волокон)
                strokeColor: 'white',
                //strokeOpacity: 5.5
                strokeWidth: 4
                        // Стиль линии (9-24 волокон)
            },
            {
                // Стиль линии (25+ волокон)
                strokeColor: 'white',
                //strokeOpacity: 5.5
                strokeWidth: 6
                        // Стиль линии (25+ волокон)
            } );

            function addPoint( lon, lat, title, ident, layr ) {
                var ttt = new OpenLayers.LonLat( parseFloat( lon ), parseFloat(
                        lat ) );
                ttt.transform( new OpenLayers.Projection( "EPSG:4326" ),
                        new OpenLayers.Projection( "EPSG:900913" ) );
                for ( var k = 0; k < layr.features.length; k++ ) {
                    if ( layr.features[k].attributes.PointId == ident ) {
                        layr.features[k].move( ttt );
                        layr.features[k].attributes.label = title;
                        return false;
                    }
                }
                var point0 = new OpenLayers.Geometry.Point( parseFloat( lon ),
                        parseFloat( lat ) );
                point0.transform( new OpenLayers.Projection( "EPSG:4326" ),
                        new OpenLayers.Projection( "EPSG:900913" ) );
                layr.addFeatures( new OpenLayers.Feature.Vector( point0,
                        { label: title, name: title, PointId: ident } ) );
            }

            function toggleControl( element ) {
                alert( element );
                for ( key in drawControls ) {
                    var control = drawControls[key];
                    if ( element.value == key && element.checked ) {
                        control.activate();
                    } else {
                        control.deactivate();
                    }
                }
            }

            function onPopupClose( evt ) {
                selectControl.unselect( selectedFeature );
            }
            function onPopupClose2( evt ) {
                // 'this' is the popup.
                selectControl.unselect( this.feature );
            }
            function onFeatureSelect( evt ) {
                feature = evt.feature;
                id = feature.id;
                var lonlat = map.getLonLatFromPixel( map.getControlsByClass(
                        "OpenLayers.Control.MousePosition" )[0].lastXy );
                popup = new OpenLayers.Popup.FramedCloud( "featurePopup",
                        lonlat,
                        new OpenLayers.Size( 100, 100 ),
                        //"<h2>"+feature.attributes.title + "</h2>" +
                        CableLineText_arr[id],
                        null, true, onPopupClose2 );
                feature.popup = popup;
                popup.feature = feature;
                map.addPopup( popup );
            }

            function onFeatureUnselect( evt ) {
                feature = evt.feature;
                if ( feature.popup ) {
                    popup.feature = null;
                    map.removePopup( feature.popup );
                    feature.popup.destroy();
                    feature.popup = null;
                }
            }

            function onFeatureSelect2( evt ) {
                feature = evt.feature;
                popup = new OpenLayers.Popup.FramedCloud( "featurePopup",
                        feature.geometry.getBounds().getCenterLonLat(),
                        new OpenLayers.Size( 100, 100 ),
                        "<h2>" + feature.attributes.title + "</h2>" +
                        feature.attributes.description,
                        null, true, onPopupClose2 );
                feature.popup = popup;
                popup.feature = feature;
                map.addPopup( popup );
            }

            function onFeatureSelect3( evt ) {
                feature = evt.feature;
                popup = new OpenLayers.Popup.FramedCloud( "featurePopup",
                        feature.geometry.getBounds().getCenterLonLat(),
                        new OpenLayers.Size( 100, 100 ),
                        "<h2>" + feature.attributes.title + "</h2>" +
                        //feature.attributes.description,
                        nodeDescription_arr[feature.attributes.description],
                        null, true, onPopupClose2 );
                feature.popup = popup;
                popup.feature = feature;
                map.addPopup( popup );
            }

            function onFeatureUnselect2( evt ) {
                feature = evt.feature;
                if ( feature.popup ) {
                    popup.feature = null;
                    map.removePopup( feature.popup );
                    feature.popup.destroy();
                    feature.popup = null;
                }
            }
            function init() {
                map = new OpenLayers.Map( {
                    div: "map",
                    projection: new OpenLayers.Projection( "EPSG:4326" ),
                    displayProjection: new OpenLayers.Projection(
                            "EPSG:4326" ),
                    controls: [
                        new OpenLayers.Control.MousePosition()
                    ],
                    units: "m"/*,
                     allOverlays: true*/
                } );
                // This is the layer that uses the locally stored tiles
                var localLayer = new OpenLayers.Layer.OSM( "Локальна карта",
                        "map/tiles/${z}/${x}/${y}.png",
                        { numZoomLevels: 19,
                            alpha: false,
                            isBaseLayer: true,
                            attribution: "",
                        } );
                //localLayer.setOpacity(0.6);
                map.addLayer( localLayer );

                var osm = new OpenLayers.Layer.OSM();
                map.addLayers( [ osm ] );

                // рисуем типо гало :)
                var lineLayer_halo = new OpenLayers.Layer.Vector(
                        "Кабельные линии (гало)" );
                map.addLayer( lineLayer_halo );

                var k, k2;
                for ( k = 0; k < j; k++ ) {
                    var style_halo = {
                        strokeColor: 'black',
                        strokeWidth: style_arr[CableLine_arr[k]['style']]['strokeWidth'] + 1
                    };

                    var points = Array();
                    for ( k2 = 0; k2 < CableLine_Points_count[k]; k2++ ) {
                        //alert(CableLine_Points_count[k]);
                        lon1 = CableLine_arr[k]['points'][k2]['lon'];
                        lat1 = CableLine_arr[k]['points'][k2]['lat'];
                        points[k2] = new OpenLayers.Geometry.Point( lon1,
                                lat1 );
                    }
                    var line = new OpenLayers.Geometry.LineString( points );
                    line.transform( new OpenLayers.Projection( "EPSG:4326" ),
                            new OpenLayers.Projection( "EPSG:900913" ) );
                    var lineFeature = new OpenLayers.Feature.Vector( line,
                            null, style_halo );
                    lineLayer_halo.addFeatures( [ lineFeature ] );
                    /*CableLineText_arr[lineFeature.id] = '<h2><a target="_blank" href="CableLine.php?mode=charac&cablelineid=' +CableLine_arr[k]['cableLineId'] +'">' +CableLine_arr[k]['name'] + '</a></h2>'
                     +'Тип кабеля: <a target="_blank" href="CableType.php?mode=charac&cabletypeid=' +CableLine_arr[k]['cableTypeId'] +'">' +CableLine_arr[k]['cableTypeMarking'] +'</a><br>'
                     +'К-во модулей: ' +CableLine_arr[k]['modules'] +'<br>'
                     +'К-во волокон: ' +CableLine_arr[k]['fibers'] +'<br>'
                     +'Направление: ' +CableLine_arr[k]['direction'] +'<br>'
                     +'К-во незадействованных волокон: ' +CableLine_arr[k]['free_fibers'];*/
                    CableLineText_arr[lineFeature.id] = '<h2><a target="_blank" href="CableLine.php?mode=charac&cablelineid=' + CableLine_arr[k]['cableLineId'] + '">' + CableLine_arr[k]['name'] + '</a></h2>'
                            + 'Тип кабеля: <a target="_blank" href="CableType.php?mode=charac&cabletypeid=' + CableLine_arr[k]['cableTypeId'] + '">' + CableLine_arr[k]['cableTypeMarking'] + '</a><br>'
                            + 'Направление: ' + CableLine_arr[k]['direction'] + '<br>';
                    CableLineText_arr[lineFeature.id] = CableLineText_arr[lineFeature.id] + 'К-во модулей: ' + CableLine_arr[k]['modules'] + '<br>';
                    if ( CableLine_arr[k]['fibers'] != '0' ) {
                        CableLineText_arr[lineFeature.id] = CableLineText_arr[lineFeature.id] + 'К-во волокон: ' + CableLine_arr[k]['fibers'] + '<br>';
                        CableLineText_arr[lineFeature.id] = CableLineText_arr[lineFeature.id] + 'К-во незадействованных волокон: ' + CableLine_arr[k]['free_fibers'];
                    }
                }
                // рисуем типо гало :)


                lineLayer = new OpenLayers.Layer.Vector( "Кабельные линии" );
                map.addLayer( lineLayer );

                for ( k = 0; k < j; k++ ) {
                    var points = Array();
                    for ( k2 = 0; k2 < CableLine_Points_count[k]; k2++ ) {
                        lon1 = CableLine_arr[k]['points'][k2]['lon'];
                        lat1 = CableLine_arr[k]['points'][k2]['lat'];
                        points[k2] = new OpenLayers.Geometry.Point( lon1,
                                lat1 );
                    }
                    var line = new OpenLayers.Geometry.LineString( points );
                    line.transform( new OpenLayers.Projection( "EPSG:4326" ),
                            new OpenLayers.Projection( "EPSG:900913" ) );
                    var lineFeature = new OpenLayers.Feature.Vector( line,
                            null, style_arr[CableLine_arr[k]['style']] );
                    var line_halo = lineFeature.clone();
                    lineLayer.addFeatures( [ lineFeature ] );
                    CableLineText_arr[lineFeature.id] = '<h2><a target="_blank" href="CableLine.php?mode=charac&cablelineid=' + CableLine_arr[k]['cableLineId'] + '">' + CableLine_arr[k]['name'] + '</a></h2>'
                            + 'Тип кабеля: <a target="_blank" href="CableType.php?mode=charac&cabletypeid=' + CableLine_arr[k]['cableTypeId'] + '">' + CableLine_arr[k]['cableTypeMarking'] + '</a><br>'
                            + 'Направление: ' + CableLine_arr[k]['direction'] + '<br>'
                            + 'К-во модулей: ' + CableLine_arr[k]['modules'] + '<br>';
                    if ( CableLine_arr[k]['fibers'] != '0' ) {
                        CableLineText_arr[lineFeature.id] = CableLineText_arr[lineFeature.id] + 'К-во волокон: ' + CableLine_arr[k]['fibers'] + '<br>';
                        CableLineText_arr[lineFeature.id] = CableLineText_arr[lineFeature.id] + 'К-во незадействованных волокон: ' + CableLine_arr[k]['free_fibers'];
                    }

                }

                var styleMarkersLabels = new OpenLayers.Style( // стили для надписей узлов
                        {
                            strokeWidth: 2,
                            labelYOffset: 10,
                            label: "${label}",
                            fontColor: 'red',
                            fontSize: 9,
                            fontWeight: "bold",
                            labelOutlineColor: "black",
                            labelOutlineWidth: 1
                        } );
                //dddd

                var layerNodes = new OpenLayers.Layer.Vector( "Узлы", {
                    strategies: [ new OpenLayers.Strategy.BBOX(
                                { resFactor: 1.1 } ) ],
                    protocol: new OpenLayers.Protocol.HTTP( {
                        url: "get_layers.php?mode=GetNodesMarkers",
                        format: new OpenLayers.Format.Text()
                    } )
                } );
                map.addLayer( layerNodes );

                var layerCableLinePoints = new OpenLayers.Layer.Vector(
                        "Особые точки линии", {
                    minScale: 7000,
                    strategies: [ new OpenLayers.Strategy.BBOX(
                                { resFactor: 1.1 } ) ],
                    protocol: new OpenLayers.Protocol.HTTP( {
                        url: "get_layers.php?mode=GetSingularCableLinePoints",
                        format: new OpenLayers.Format.Text()
                    } )
                } );

                map.addLayer( layerCableLinePoints );

                var vectorPoint = new OpenLayers.Layer.Vector(
                        "Узлы (надписи)",
                        {
                            minScale: 7000,
                            styleMap: new OpenLayers.StyleMap(
                                    { "default": styleMarkersLabels,
                                        "select": { pointRadius: 20 }
                                    } )
                        } );
                map.addLayer( vectorPoint );

                var lat2, lon2, title, ident;
                for ( l = 0; l < nodesLabels_Count; l++ ) {
                    lat2 = nodesLabels_arr[l]["points"][0]["lat"];
                    lon2 = nodesLabels_arr[l]["points"][0]["lon"];
                    title = nodesLabels_arr[l]["title"];
                    ident = nodesLabels_arr[l]["ident"];
                    addPoint( lon2, lat2, title, ident, map.layers[6] );
                }

                lineLayer.events.on( {
                    'featureselected': onFeatureSelect,
                    'featureunselected': onFeatureUnselect
                } );

                lineLayer_halo.events.on( {
                    'featureselected': onFeatureSelect,
                    'featureunselected': onFeatureUnselect
                } );

                layerNodes.events.on( {
                    'featureselected': onFeatureSelect3,
                    'featureunselected': onFeatureUnselect2
                } );

                layerCableLinePoints.events.on( {
                    'featureselected': onFeatureSelect2,
                    'featureunselected': onFeatureUnselect2
                } );
                selectControl = new OpenLayers.Control.SelectFeature(
                        [ layerNodes, lineLayer, lineLayer_halo, layerCableLinePoints, vectorPoint ] );
                map.addControl( selectControl );
                selectControl.activate();

                map.addControls(
                        [
                            new OpenLayers.Control.LayerSwitcher(),
                            new OpenLayers.Control.Navigation(),
                            new OpenLayers.Control.Attribution(),
                            new OpenLayers.Control.PanZoomBar(),
                            new OpenLayers.Control.MousePosition()
                        ]
                        );
                var lonLat = new OpenLayers.LonLat( lon,
                        lat ).transform( new OpenLayers.Projection(
                        "EPSG:4326" ), map.getProjectionObject() );
                map.setCenter( lonLat, zoom );
                map.setLayerIndex( map.layers[6], 7 );
            }

            function parseCableLineXML( Response ) {
                var doc = Response.responseXML.documentElement;
                var cableLine = doc.getElementsByTagName(
                        "cableLine" );

                for ( var i = 0; i < cableLine.length; i++ ) {
                    var f_child = cableLine[i].firstChild;
                    j2 = 0;
                    CableLine_arr[i] = { };
                    CableLine_arr[i]["points"] = Array();

                    while ( f_child.nextSibling ) {
                        switch ( f_child.nodeName ) {
                            case "node":
                                CableLine_arr[i]["points"][j2] = { };

                                CableLine_arr[i]["points"][j2]["lon"] = f_child.getAttribute(
                                        "lon" );
                                CableLine_arr[i]["points"][j2]["lat"] = f_child.getAttribute(
                                        "lat" );
                                j2++;
                                break;
                            case "cableLineId":
                                CableLine_arr[i]['cableLineId'] = f_child.firstChild.nodeValue;
                                break;
                            case "name":
                                CableLine_arr[i]['name'] = f_child.firstChild.nodeValue;
                                break;
                            case "cableTypeId":
                                CableLine_arr[i]['cableTypeId'] = f_child.firstChild.nodeValue;
                                break;
                            case "modules":
                                CableLine_arr[i]['modules'] = f_child.firstChild.nodeValue;
                                break;
                            case "fibers":
                                CableLine_arr[i]['fibers'] = f_child.firstChild.nodeValue;
                                break;
                            case "direction":
                                CableLine_arr[i]['direction'] = f_child.firstChild.nodeValue;
                                break;
                            case "free_fibers":
                                CableLine_arr[i]['free_fibers'] = f_child.firstChild.nodeValue;
                                break;
                            case "cableTypeMarking":
                                CableLine_arr[i]['cableTypeMarking'] = f_child.firstChild.nodeValue;
                                break;
                        }
                        f_child = f_child.nextSibling;
                    }
                    if ( ( CableLine_arr[i]['cableTypeId'] == 'NULL' ) || ( CableLine_arr[i]['fibers'] == '-1' ) ) {
                        CableLine_arr[i]['style'] = 4;
                    } else {
                        if ( ( CableLine_arr[i]['fibers'] >= 1 ) && ( CableLine_arr[i]['fibers'] <= 8 ) ) {
                            CableLine_arr[i]['style'] = 1;
                        } else {
                            if ( ( CableLine_arr[i]['fibers'] >= 9 ) && ( CableLine_arr[i]['fibers'] <= 24 ) ) {
                                CableLine_arr[i]['style'] = 2;
                            } else {
                                if ( ( CableLine_arr[i]['fibers'] >= 25 ) ) {
                                    CableLine_arr[i]['style'] = 3;
                                } else {
                                    if ( ( CableLine_arr[i]['fibers'] == 0 ) ) {
                                        CableLine_arr[i]['style'] = 0;
                                    }
                                }
                            }
                        }
                    }
                    CableLine_Points_count[i] = j2;
                    j++;
                }
                GetXMLFile(
                        "get_layers.php?mode=GetNetworkNodesDescription",
                        parseNetworkNodesDescriptionXML ); // получаем описание для узлов
            }

            function parseNetworkNodesDescriptionXML( Response ) {
                var doc = Response.responseXML.documentElement;
                var nodeDescription = doc.getElementsByTagName(
                        "nodeDescription" );

                var txt_index = 0;
                for ( var i = 0; i < nodeDescription.length; i++ ) {
                    var f_child = nodeDescription[i].firstChild;
                    j2 = 0;

                    while ( f_child.nextSibling ) {
                        switch ( f_child.nodeName ) {
                            case "index":
                                //nodeDescription_arr[i]['title'] = f_child.firstChild.nodeValue;
                                txt_index = f_child.firstChild.nodeValue;
                                break;
                            case "description":
                                nodeDescription_arr[txt_index] = f_child.firstChild.nodeValue;
                                break;
                        }
                        f_child = f_child.nextSibling;
                    }
                }

                GetXMLFile( "get_layers.php?mode=GetNodesLabels",
                        parseNodesLabelsXML ); // получаем надписи для узлов
            }

            function parseNodesLabelsXML( Response ) {
                var doc = Response.responseXML.documentElement;
                var nodeLabel = doc.getElementsByTagName(
                        "nodeLabel" );

                for ( var i = 0; i < nodeLabel.length; i++ ) {
                    var f_child = nodeLabel[i].firstChild;
                    j2 = 0;
                    nodesLabels_arr[i] = { };
                    nodesLabels_arr[i]["points"] = Array();

                    while ( f_child.nextSibling ) {
                        switch ( f_child.nodeName ) {
                            case "node":
                                nodesLabels_arr[i]["points"][0] = { };

                                nodesLabels_arr[i]["points"][0]["lon"] = f_child.getAttribute(
                                        "lon" );
                                nodesLabels_arr[i]["points"][0]["lat"] = f_child.getAttribute(
                                        "lat" );
                                break;
                            case "title":
                                nodesLabels_arr[i]['title'] = f_child.firstChild.nodeValue;
                                break;
                            case "ident":
                                nodesLabels_arr[i]['ident'] = f_child.firstChild.nodeValue;
                                break;
                        }
                        f_child = f_child.nextSibling;
                    }
                    nodesLabels_Count++;
                }

                init();
            }

            GetXMLFile( "get_layers.php?mode=GetCableLines",
                    parseCableLineXML ); // получаем кабельные линии
        </script>	
    </head>
    <body>
        <div id="map"></div><br>
    </body>
</html>