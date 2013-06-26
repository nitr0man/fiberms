<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!--meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"-->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Карта - FiberMS</title>
        <!--link rel="stylesheet" type="text/css" href="style_popup.css" />
        <link rel="stylesheet" href="style_popup2.css" type="text/css"-->
        <link rel="stylesheet" href="ext-all.css" type="text/css">
        <link rel="stylesheet" href="style/buttons.css" type="text/css">
        <link rel="stylesheet" href="map_edt.css" type="text/css">
        <style type="text/css">
            #controlToggle li {
                list-style: none;
            }
        </style>
        <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
        <!--script src="js/OpenLayers_2.13.js"></script-->
        <!--script src="http://openlayers.org/api/OpenLayers.js"></script-->
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
        <script type="text/javascript">
            var lat = 48.5;
            var lon = 32.24;
            var zoom = 14;
            var map;
            var drawControls, selectedFeature;
            var lineLayer, lineLayer_halo, layerNodes, layerCableLinePoints, layerNodeNames,
                    selectSingPointLayer, addNodeLayer;
            var CableLineText_arr = Array();
            var CableLine_arr = { };

            var notyInformation, notyQuestion, notyError;

            var coor;
            var converted;
            var CableLineEdtInfo = { };
            var jsonInsertCoor;
            var cableTypeArr, nodesArr, networkBoxesArr;
            var mapCr = true;
            var selectSingPoint = false, selectDeleteSingPointMode = false,
                    selectDeleteCableLineMode = false, selectDeleteNodeMode = false;
            var selectLineControl, selectSingPointControl,
                    selectDeleteSingPointControl, selectDeleteCableLineControl;
            var selectedCableLineId;

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
            },
            {
                // Стиль линии (1-8 волокон)
                strokeColor: 'white',
                //strokeOpacity: 5.5
                strokeWidth: 2
            },
            {
                // Стиль линии (9-24 волокон)
                strokeColor: 'white',
                //strokeOpacity: 5.5
                strokeWidth: 4
            },
            {
                // Стиль линии (25+ волокон)
                strokeColor: 'white',
                //strokeOpacity: 5.5
                strokeWidth: 6
            } );

            function disableControls() {
                selectSingPointControl.deactivate();
                selectSingPoint = false;
                selectDeleteSingPointControl.deactivate();
                selectDeleteSingPointMode = false;
                selectDeleteCableLineControl.deactivate();
                selectDeleteCableLineMode = false;
                selectLineControl.deactivate();
                selectSingPoint = false;
                //addNodeControl.deactivate();
                deleteNodeControl.deactivate();
                selectDeleteNodeMode = false;
            }

            function getData() {
                getCableTypes(); // получаем типы кабелей            
                getNodes(); // получаем узлы
                getNetworkBoxes(); // получаем ящики

            }

            function getCableTypes() {
                function fillArr( data ) {
                    cableTypesObj = JSON.parse( data );
                    cableTypeArr = [ ];
                    for ( var i = 0; i < cableTypesObj.CableTypes.length; i++ ) {
                        cableTypeArr[i] = [ ];
                        cableTypeArr[i][0] = cableTypesObj.CableTypes[i].id;
                        cableTypeArr[i][1] = cableTypesObj.CableTypes[i].marking;
                    }
                }
                $.get( 'getLayers_edt.php?mode=GetCableTypes',
                        fillArr );
            }

            function getNodes() {
                function fillArr( data ) {
                    nodesArrObj = JSON.parse( data );
                    nodesArr = [ ];
                    for ( var i = 0; i < nodesArrObj.Nodes.length; i++ ) {
                        nodesArr[i] = [ ];
                        nodesArr[i][0] = nodesArrObj.Nodes[i].id;
                        nodesArr[i][1] = nodesArrObj.Nodes[i].name;
                    }
                }
                $.get( 'getLayers_edt.php?mode=GetNodes',
                        fillArr );
            }

            function getNetworkBoxes() {
                function fillArr( data ) {
                    var networkBoxesObj = JSON.parse( data );
                    networkBoxesArr = [ ];
                    for ( var i = 0; i < networkBoxesObj.Boxes.length; i++ ) {
                        networkBoxesArr[i] = [ ];
                        networkBoxesArr[i][0] = networkBoxesObj.Boxes[i].id;
                        networkBoxesArr[i][1] = networkBoxesObj.Boxes[i].inventoryNumber;
                    }
                }
                $.get( 'getLayers_edt.php?mode=GetNetworkBoxes',
                        fillArr );
            }

            function refreshAllLayers() {
                lineLayer_halo.destroyFeatures();
                lineLayer.destroyFeatures();
                layerNodeNames.destroyFeatures();
                j = 0;
                nodesLabels_Count = 0;
                layerNodes.refresh( { force: true } );
                layerCableLinePoints.refresh( { force: true } );
                getData();
                GetXMLFile(
                        "getLayers_edt.php?mode=GetCableLines",
                        parseCableLineXML );
            }

            function addPoint( lon, lat, title, ident, layr ) {
                var ttt = new OpenLayers.LonLat( parseFloat( lon ),
                        parseFloat(
                        lat ) );
                ttt.transform( new OpenLayers.Projection(
                        "EPSG:4326" ),
                        new OpenLayers.Projection( "EPSG:900913" ) );
                for ( var k = 0; k < layr.features.length; k++ ) {
                    if ( layr.features[k].attributes.PointId == ident ) {
                        layr.features[k].move( ttt );
                        layr.features[k].attributes.label = title;
                        return false;
                    }
                }
                var point0 = new OpenLayers.Geometry.Point( parseFloat(
                        lon ),
                        parseFloat( lat ) );
                point0.transform( new OpenLayers.Projection(
                        "EPSG:4326" ),
                        new OpenLayers.Projection( "EPSG:900913" ) );
                layr.addFeatures( new OpenLayers.Feature.Vector(
                        point0,
                        { label: title, name: title, PointId: ident } ) );
            }

            function toggleControl( element ) {
                for ( key in drawControls ) {
                    var control = drawControls[key];
                    if ( element.value == key && element.checked ) {
                        control.activate();
                    } else {
                        control.deactivate();
                    }
                }
            }

            function init() {
                map = new OpenLayers.Map( {
                    div: "map",
                    projection: new OpenLayers.Projection(
                            "EPSG:4326" ),
                    displayProjection: new OpenLayers.Projection(
                            "EPSG:4326" ),
                    controls: [
                        new OpenLayers.Control.MousePosition()
                    ],
                    units: "m"/*,
                     allOverlays: true*/
                } );
                var localLayer = new OpenLayers.Layer.OSM(
                        "Локальна карта",
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
                lineLayer_halo = new OpenLayers.Layer.Vector(
                        "Кабельные линии (гало)" );
                map.addLayer( lineLayer_halo );

                lineLayer = new OpenLayers.Layer.Vector(
                        "Кабельные линии" );
                map.addLayer( lineLayer );
                lineLayer.events.on( {
                    "featureselected": selectDeleteCableLine
                } );
                selectDeleteCableLineControl = new OpenLayers.Control.SelectFeature(
                        [ lineLayer ] );
                map.addControl( selectDeleteCableLineControl );

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

                layerNodes = new OpenLayers.Layer.Vector(
                        "Узлы",
                        {
                            strategies: [ new OpenLayers.Strategy.BBOX(
                                        { resFactor: 1.1 } ) ],
                            protocol: new OpenLayers.Protocol.HTTP(
                                    {
                                        url: "get_layers.php?mode=GetNodesMarkers",
                                        format: new OpenLayers.Format.Text()
                                    } )
                        } );
                map.addLayer( layerNodes );
                layerNodes.events.on( {
                    "featureselected": selectDeleteNode
                } );
                deleteNodeControl = new OpenLayers.Control.SelectFeature(
                        [ layerNodes ] );
                map.addControl( deleteNodeControl );

                layerCableLinePoints = new OpenLayers.Layer.Vector(
                        "Особые точки линии",
                        {
                            minScale: 7000,
                            strategies: [ new OpenLayers.Strategy.BBOX(
                                        { resFactor: 1.1 } ) ],
                            protocol: new OpenLayers.Protocol.HTTP(
                                    {
                                        url: "get_layers.php?mode=GetSingularCableLinePoints",
                                        format: new OpenLayers.Format.Text()
                                    } )
                        } );
                layerCableLinePoints.events.on( {
                    "featureselected": selectDeleteSingPoint
                } );
                selectDeleteSingPointControl = new OpenLayers.Control.SelectFeature(
                        [ layerCableLinePoints ] );
                map.addControl( selectDeleteSingPointControl );

                map.addLayer(
                        layerCableLinePoints );

                layerNodeNames = new OpenLayers.Layer.Vector(
                        "Узлы (надписи)",
                        {
                            minScale: 7000,
                            styleMap: new OpenLayers.StyleMap(
                                    { "default": styleMarkersLabels,
                                        "select": { pointRadius: 20 }
                                    } )
                        } );
                map.addLayer( layerNodeNames );

                lineLayer.events.on( {
                    "afterfeaturemodified": updCableLine,
                    "beforefeaturemodified": function() {
                        notyInformation.close();
                        showInformation( 'topCenter',
                                'Щелкните в любом месте для завершения редактирования' );
                        setTimeout( function() {
                            notyInformation.close();
                        }, 5000 );
                    },
                    "featureselected": getSingPoints
                } );
                selectLineControl = new OpenLayers.Control.SelectFeature(
                        [ lineLayer ] );
                map.addControl( selectLineControl );
                //selectLineControl.activate();

                addCableLineLayer = new OpenLayers.Layer.Vector(
                        "AddLineLayer" );
                map.addLayer(
                        addCableLineLayer );
                addCableLineLayer.events.on( {
                    "featureadded": addCableLine
                } );

                selectSingPointLayer = new OpenLayers.Layer.Vector(
                        "SelectSingPointLayer" );
                map.addLayer(
                        selectSingPointLayer );

                addNodeLayer = new OpenLayers.Layer.Vector(
                        "AddNodeLayer" );
                map.addLayer(
                        addNodeLayer );
                addNodeLayer.events.on( {
                    "featureadded": addNodeMsg
                } );
                /*addNodeControl = new OpenLayers.Control.SelectFeature(
                 [ addNodeLayer ] );
                 map.addControl( addNodeControl );*/

                selectSingPointLayer.events.on( {
                    "featureselected": setSingPoint
                } );
                selectSingPointControl = new OpenLayers.Control.SelectFeature(
                        [ selectSingPointLayer ] );
                map.addControl( selectSingPointControl );

                var panel = new OpenLayers.Control.Panel(
                        {
                            //displayClass: "olControlEditingToolbar",
                            createControlMarkup: function(
                                    control ) {
                                var button = document.createElement(
                                        'button' ),
                                        iconSpan = document.createElement(
                                        'span' ),
                                        textSpan = document.createElement(
                                        'span' );
                                iconSpan.innerHTML = '&nbsp;';
                                button.appendChild(
                                        iconSpan );
                                if ( control.text ) {
                                    textSpan.innerHTML = control.text;
                                }
                                button.appendChild(
                                        textSpan );
                                return button;
                            }
                        }
                );

                var editCable = new OpenLayers.Control.ModifyFeature(
                        lineLayer, {
                    title: "Позволяет редактировать кабельные линии",
                    text: 'Изменить<br>линию',
                    vertexRenderIntent: 'temporary',
                    displayClass: "olControlEditCable",
                    modified: true,
                    createVertices: true,
                    mode: OpenLayers.Control.ModifyFeature.RESHAPE
                } );

                editCable.events.register( "activate", this, function() {
                    disableControls();
                    showInformation( 'topCenter', 'Выберите линию' );
                } );

                var drawCable = new OpenLayers.Control.DrawFeature(
                        addCableLineLayer,
                        OpenLayers.Handler.Path,
                        {
                            title: "Позволяет добавлять кабельные линии",
                            text: 'Добавить<br>линию',
                            displayClass: "olControlDrawCable",
                            handlerOptions: { multi: false }
                        } );

                drawCable.events.register( "activate", this, function() {
                    disableControls();
                    showInformation( 'topCenter',
                            'Щелкните два раза для завершения рисования' );
                } );

                var deleteCableLine = new OpenLayers.Control.Navigation(
                        {
                            title: "Позволяет удалять кабельные линии",
                            text: "Удалить<br>линию",
                            displayClass: "olControlDeleteCable",
                            mode: OpenLayers.Control.Navigation
                        }
                );

                deleteCableLine.events.register( "activate", this, function() {
                    disableControls();
                    selectDeleteCableLineControl.activate();
                    selectDeleteCableLineMode = true;
                    showInformation( 'topCenter', 'Выберите линию' );
                } );

                var addSingPoint = new OpenLayers.Control.Navigation(
                        {
                            title: "Позволяет добавлять особые точки",
                            text: "Добавить<br>особую точку",
                            displayClass: "olControlAddSingPoint",
                            mode: OpenLayers.Control.Navigation
                        } );

                addSingPoint.events.register( "activate", this,
                        function() {
                            disableControls();
                            selectLineControl.activate();
                            selectSingPoint = true;
                            showInformation( 'topCenter', 'Выберите линию' );
                        } );

                var deleteSingPoint = new OpenLayers.Control.Navigation(
                        {
                            title: "Позволяет удалять особые точки",
                            text: "Удалить<br>особую точку",
                            displayClass: "olControlDeleteSingPoint",
                            mode: OpenLayers.Control.Navigation
                        } );
                deleteSingPoint.events.register( "activate", this,
                        function() {
                            disableControls();
                            selectDeleteSingPointControl.activate();
                            selectDeleteSingPointMode = true;
                            showInformation( 'topCenter',
                                    'Выберите особую точку' );
                        } );

                var addNode = new OpenLayers.Control.DrawFeature( addNodeLayer,
                        OpenLayers.Handler.Point, {
                    title: "Позволяет добавлять узлы",
                    text: "Добавить<br>узел",
                    displayClass: "olControlAddNode",
                    handlerOptions: { multi: false }
                } );
                addNode.events.register( "activate", this,
                        function() {
                            disableControls();
                            //addNodeControl.activate();
                        } );

                var deleteNode = new OpenLayers.Control.Navigation(
                        {
                            title: "Позволяет удалять узлы",
                            text: "Удалить<br>узел",
                            displayClass: "olControlDeleteNode",
                            mode: OpenLayers.Control.Navigation
                        } );
                deleteNode.events.register( "activate", this,
                        function() {
                            disableControls();
                            deleteNodeControl.activate();
                            selectDeleteNodeMode = true;
                            showInformation( 'topCenter', 'Выберите узел' );
                        } );

                panel.addControls(
                        [ editCable, drawCable, deleteCableLine,
                            addSingPoint, deleteSingPoint, addNode, deleteNode ] );
                map.addControl(
                        panel );

                map.addControls( [
                    new OpenLayers.Control.Navigation(),
                    //new OpenLayers.Control.PanZoomBar(),
                    //new OpenLayers.Control.Zoom(),
                    new OpenLayers.Control.LayerSwitcher(
                            { 'ascending': false } ),
                    new OpenLayers.Control.Permalink(),
                    new OpenLayers.Control.ScaleLine(),
                    new OpenLayers.Control.Permalink(
                            'permalink' ),
                    new OpenLayers.Control.MousePosition(),
                    //new OpenLayers.Control.OverviewMap(),
                    new OpenLayers.Control.KeyboardDefaults()
                ] );
                var lonLat = new OpenLayers.LonLat(
                        lon,
                        lat ).transform(
                        new OpenLayers.Projection(
                        "EPSG:4326" ),
                        map.getProjectionObject() );
                map.setCenter( lonLat,
                        zoom );
                map.setLayerIndex(
                        map.layers[6],
                        7 );
                mapCr = false;
                drawFeatures();
            }

            function drawFeatures() {
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
                        points[k2] = new OpenLayers.Geometry.Point(
                                lon1,
                                lat1 );
                    }
                    var line = new OpenLayers.Geometry.LineString(
                            points );
                    line.transform( new OpenLayers.Projection(
                            "EPSG:4326" ),
                            new OpenLayers.Projection(
                            "EPSG:900913" ) );
                    var lineFeature = new OpenLayers.Feature.Vector(
                            line,
                            null, style_halo );
                    lineLayer_halo.addFeatures(
                            [ lineFeature ] );
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

                for ( k = 0; k < j; k++ ) {
                    var points = Array();
                    for ( k2 = 0; k2 < CableLine_Points_count[k]; k2++ ) {
                        lon1 = CableLine_arr[k]['points'][k2]['lon'];
                        lat1 = CableLine_arr[k]['points'][k2]['lat'];
                        points[k2] = new OpenLayers.Geometry.Point(
                                lon1,
                                lat1 );
                    }
                    var line = new OpenLayers.Geometry.LineString(
                            points );
                    line.transform(
                            new OpenLayers.Projection(
                            "EPSG:4326" ),
                            new OpenLayers.Projection(
                            "EPSG:900913" ) );
                    var lineFeature = new OpenLayers.Feature.Vector(
                            line,
                            null,
                            style_arr[CableLine_arr[k]['style']] );
                    var line_halo = lineFeature.clone();
                    lineLayer.addFeatures(
                            [ lineFeature ] );
                    CableLineText_arr[lineFeature.id] = '<h2><a target="_blank" href="CableLine.php?mode=charac&cablelineid=' + CableLine_arr[k]['cableLineId'] + '">' + CableLine_arr[k]['name'] + '</a></h2>'
                            + 'Тип кабеля: <a target="_blank" href="CableType.php?mode=charac&cabletypeid=' + CableLine_arr[k]['cableTypeId'] + '">' + CableLine_arr[k]['cableTypeMarking'] + '</a><br>'
                            + 'Направление: ' + CableLine_arr[k]['direction'] + '<br>'
                            + 'К-во модулей: ' + CableLine_arr[k]['modules'] + '<br>';
                    if ( CableLine_arr[k]['fibers'] != '0' ) {
                        CableLineText_arr[lineFeature.id] = CableLineText_arr[lineFeature.id] + 'К-во волокон: ' + CableLine_arr[k]['fibers'] + '<br>';
                        CableLineText_arr[lineFeature.id] = CableLineText_arr[lineFeature.id] + 'К-во незадействованных волокон: ' + CableLine_arr[k]['free_fibers'];
                    }
                    CableLineEdtInfo[lineFeature.id] = { };
                    CableLineEdtInfo[lineFeature.id]['seqStart'] = CableLine_arr[k]['sequenceStart'];
                    CableLineEdtInfo[lineFeature.id]['seqEnd'] = CableLine_arr[k]['sequenceEnd'];
                    CableLineEdtInfo[lineFeature.id]['cableLineId'] = CableLine_arr[k]['cableLineId'];
                }

                var lat2, lon2, title, ident;
                for ( l = 0; l < nodesLabels_Count; l++ ) {
                    lat2 = nodesLabels_arr[l]["points"][0]["lat"];
                    lon2 = nodesLabels_arr[l]["points"][0]["lon"];
                    title = nodesLabels_arr[l]["title"];
                    ident = nodesLabels_arr[l]["ident"];
                    addPoint( lon2,
                            lat2,
                            title,
                            ident,
                            layerNodeNames );
                }
            }

            //GetXMLFile("get_layers.php?mode=GetCableLines", parseCableLineXML); // получаем кабельные линии
            j = 0;
            j2 = 0;
            getData();
            GetXMLFile(
                    "getLayers_edt.php?mode=GetCableLines",
                    parseCableLineXML ); // получаем кабельные линии
        </script>	
    </head>
    <body>
        <div id="map"></div>
    </body>
</html>