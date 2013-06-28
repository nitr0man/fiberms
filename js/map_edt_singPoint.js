function getSingPoints( /*event*/ ) {
    if ( selectSingPoint ) {
        /*var feature = event.feature;
         selectedLineAddSingPoint = feature;
         selectedCableLineId = CableLineEdtInfo[feature.id]['cableLineId'];
         coor = feature.geometry.getVertices();*/
        for ( var i = 0; i < coor.length; i++ )
        {
            var point = new OpenLayers.Geometry.Point( coor[ i ].x,
                    coor[ i ].y );
            if ( isCanAddSingPoint( coor[ i ] ) ) {
                selectSingPointLayer.addFeatures(
                        [ new OpenLayers.Feature.Vector( point ) ] );
            }
        }
        selectSingPointControl.activate();
        notyInformation.close();
        showInformation( 'topCenter', 'Выберите точку' );
        //alert( "select" );
        //selectSingPoint = false;
    }
}

function setSingPoint( event ) {
    var jsonSingPointCoor = {
        CableLineId: "",
        meterSign: "",
        apartment: "",
        building: "",
        note: "",
        networkNode: "",
        coorArr: [ ]
    };
    notyInformation.close();
    var feature = event.feature;
    var coorSingPoint = feature.geometry.getVertices();
    form = Ext.create( 'Ext.form.Panel', {
        bodyPadding: 10,
        defaultType: 'textfield',
        items: [
            {
                xtype: 'combobox',
                fieldLabel: 'Узел',
                name: 'networkNode',
                id: 'networkNodeId',
                valueField: 'value',
                displayField: 'text',
                store: new Ext.data.SimpleStore( {
                    id: nodesArr[0].id,
                    fields:
                            [
                                'value',
                                'text'
                            ],
                    data: nodesArr
                } )
            },
            {
                fieldLabel: 'Отметка',
                name: 'meterSign',
                value: ''
            },
            {
                fieldLabel: 'Квартира',
                name: 'apartment',
                value: ''
            },
            {
                fieldLabel: 'Здание',
                name: 'building',
                value: ''
            },
            {
                fieldLabel: 'Примечание',
                name: 'note',
                value: ''
            }
        ],
        buttons: [
            {
                text: 'Добавить',
                handler: function() {
                    var form = this.up( 'form' ).getForm();
                    jsonSingPointCoor.CableLineId = selectedCableLineId;
                    jsonSingPointCoor.apartment = form.getValues().apartment;
                    jsonSingPointCoor.building = form.getValues().building;
                    jsonSingPointCoor.meterSign = form.getValues().meterSign;
                    jsonSingPointCoor.note = form.getValues().note;
                    jsonSingPointCoor.networkNode = form.getValues().networkNode;
                    addSingPoint( coorSingPoint,
                            jsonSingPointCoor );
                    dialog.destroy();
                }
            }
        ]
    } );
    dialog = new Ext.Window( {
        title: "Добавить особую точку",
        layout: "fit",
        height: 220, width: 330,
        plain: true,
        items: [ form ]
    } );
    dialog.show();
    var res = isEndLine( coorSingPoint );
    if ( !res ) {
        Ext.getCmp( 'networkNodeId' ).disable();
    }
    //selectSingPointControl.deactivate();
    selectSingPointLayer.destroyFeatures();
}

function addSingPoint( coor, jsonSingPointCoor ) {
    //coor = feature.geometry.getVertices();
    var ll = new OpenLayers.LonLat( coor[ 0 ].x,
            coor[ 0 ].y ).transform(
            new OpenLayers.Projection( "EPSG:900913" ),
            new OpenLayers.Projection( "EPSG:4326" ) );
    jsonSingPointCoor.coorArr[ 0 ] = { };
    jsonSingPointCoor.coorArr[ 0 ]["lon"] = ll.lon;
    jsonSingPointCoor.coorArr[ 0 ]["lat"] = ll.lat;
    json = JSON.stringify( jsonSingPointCoor );
    $.post( "map_post.php", { coors: json, mode: "addSingPoint" },
    function() {
        refreshAllLayers();
    } );
}

function selectDeleteSingPoint( event, del ) {
    del = ( typeof del === "undefined" ) ? false : del;
    notyInformation.close();
    if ( selectDeleteSingPointMode && del ) {
        var jsonCoor = {
            coorArr: [ ]
        };
        var feature = event.feature;
        var coorSingPoint = feature.geometry.getVertices();
        var ll = new OpenLayers.LonLat( coorSingPoint[ 0 ].x,
                coorSingPoint[ 0 ].y ).transform(
                new OpenLayers.Projection( "EPSG:900913" ),
                new OpenLayers.Projection( "EPSG:4326" ) );
        jsonCoor.coorArr[0] = { };
        jsonCoor.coorArr[ 0 ]["lon"] = ll.lon;
        jsonCoor.coorArr[ 0 ]["lat"] = ll.lat;
        json = JSON.stringify( jsonCoor );
        $.post( "map_post.php", { coors: json, mode: "deleteSingPoint" },
        function() {
            refreshAllLayers();
        } );
    } else if ( selectDeleteSingPointMode && !del ) {
        showDeleteCableLineQuestion( 'center',
                'Вы действительно хотите удалить особую точку?',
                function() {
                    selectDeleteSingPoint( event, true );
                } );
    }
}

function isCanAddSingPoint( coor ) {
    function checkCoor( data ) {

    }
    var result = false;
    var ll = new OpenLayers.LonLat( coor.x,
            coor.y ).transform(
            new OpenLayers.Projection( "EPSG:900913" ),
            new OpenLayers.Projection( "EPSG:4326" ) );
    var llLon = parseFloat( Number( ll.lon ).toFixed( 10 ) );
    var llLat = parseFloat( Number( ll.lat ).toFixed( 10 ) );
    for ( var i = 0; i < freePointsArr.length; i++ ) {
        var lon = parseFloat( Number( freePointsArr[i].lon ).toFixed( 10 ) );
        var lat = parseFloat( Number( freePointsArr[i].lat ).toFixed( 10 ) );
        if ( lon == llLon && lat == llLat ) {
            result = true;
            break;
        }
    }
    return result;
}

function getFreeSingPoint( event ) {
    function fillArr( data ) {
        var freePointsObj = JSON.parse( data );
        freePointsArr = [ ];
        for ( var i = 0; i < freePointsObj.Points.length; i++ ) {
            freePointsArr[i] = { };
            freePointsArr[i].lon = freePointsObj.Points[i].lon;
            freePointsArr[i].lat = freePointsObj.Points[i].lat;
        }
        getSingPoints();
    }
    var feature = event.feature;
    selectedLineAddSingPoint = feature;
    selectedCableLineId = CableLineEdtInfo[feature.id]['cableLineId'];
    coor = feature.geometry.getVertices();
    $.get(
            'getLayers_edt.php?mode=GetFreeLinePoints&id=' + selectedCableLineId,
            fillArr );
}