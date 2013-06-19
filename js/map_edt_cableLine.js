function onCableLineAddedPopup( event ) {
    var jsonInsertCoor = {
        CableType: "",
        length: "",
        name: "",
        comment: "",
        CableLineId: "",
        coorArr: [ ]
    };
    var feature = event.feature;
    form = Ext.create( 'Ext.form.Panel', {
        bodyPadding: 10,
        defaultType: 'textfield',
        items: [
            {
                xtype: 'combobox',
                fieldLabel: 'Тип кабеля',
                name: 'cableType',
                valueField: 'value',
                displayField: 'text',
                store: new Ext.data.SimpleStore( {
                    id: 0,
                    fields:
                            [
                                'value',
                                'text'
                            ],
                    data: cableTypeArr
                } )
            },
            {
                fieldLabel: 'Длина',
                name: 'length',
                value: ''
            },
            {
                fieldLabel: 'Имя',
                name: 'name',
                value: ''
            },
            {
                fieldLabel: 'Примечание',
                name: 'note',
                value: ''//feature.attributes.name
            }
        ],
        buttons: [
            {
                text: 'Добавить',
                handler: function() {
                    var form = this.up( 'form' ).getForm();
                    jsonInsertCoor.CableLineId = -1;
                    jsonInsertCoor.CableType = form.getValues().cableType;
                    jsonInsertCoor.length = form.getValues().length;
                    jsonInsertCoor.name = form.getValues().name;
                    jsonInsertCoor.comment = form.getValues().note;
                    saveCableLine( feature,
                            jsonInsertCoor );
                    dialog.destroy();
                }
            }
        ]
    } );
    dialog = new Ext.Window( {
        title: "Добавить линию", //+ feature.layer.name,
        layout: "fit",
        height: 180, width: 330,
        plain: true,
        items: [ form ]
    } );
    dialog.show();
}

function saveCableLine( feature, jsonInsertCoor ) {
    coor = feature.geometry.getVertices();
    for ( var i = 0; i < coor.length; i++ )
    {
        var ll = new OpenLayers.LonLat( coor[ i ].x,
                coor[ i ].y ).transform(
                new OpenLayers.Projection( "EPSG:900913" ),
                new OpenLayers.Projection( "EPSG:4326" ) );
        jsonInsertCoor.coorArr[ i ] = { };
        jsonInsertCoor.coorArr[ i ]["lon"] = ll.lon;
        jsonInsertCoor.coorArr[ i ]["lat"] = ll.lat;
    }
    json = JSON.stringify( jsonInsertCoor );
    addCableLineLayer.destroyFeatures();
    $.post( "map_post.php", { coors: json, mode: "addCableLine" },
    function() {
        refreshAllLayers();
    } );
}

function updCableLine(
        event ) {
    jsonCoor = {
        seqStart: "",
        seqEnd: "",
        CableLineId: "",
        coorArr: [ ]
    };
    coor = event.feature.geometry.getVertices();
    for ( var i = 0; i < coor.length; i++ )
    {
        var ll = new OpenLayers.LonLat(
                coor[ i ].x,
                coor[ i ].y ).transform(
                new OpenLayers.Projection(
                "EPSG:900913" ),
                new OpenLayers.Projection(
                "EPSG:4326" ) );
        jsonCoor.coorArr[ i ] = { };
        jsonCoor.coorArr[ i ]["lon"] = ll.lon;
        jsonCoor.coorArr[ i ]["lat"] = ll.lat;
    }
    jsonCoor.seqStart = CableLineEdtInfo[event.feature.id]['seqStart'];
    jsonCoor.seqEnd = CableLineEdtInfo[event.feature.id]['seqEnd'];
    jsonCoor.CableLineId = CableLineEdtInfo[event.feature.id]['cableLineId'];
    json = JSON.stringify(
            jsonCoor );
    $.post( "map_post.php",
            { coors: json, mode: "updCableLine" }, function() {
        refreshAllLayers();
    } );
}

function addCableLine(
        event ) {
    jsonCoor = {
        seqStart: "",
        seqEnd: "",
        CableLineId: "",
        coorArr: [ ]
    };
    onCableLineAddedPopup(
            event );
}

