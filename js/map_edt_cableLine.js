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
                editable: false,
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
                    if ( jsonInsertCoor.CableType == "" || jsonInsertCoor.name == "" ) {
                        alert( 'Заполните поля!' );
                    } else {
                        saveCableLine( feature,
                                jsonInsertCoor );
                        dialog.destroy();
                    }
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
    dialog.on( 'close', function() {
        addCableLineLayer.destroyFeatures();
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
    $.post( "map_post.php",
            { coors: json, mode: "addCableLine", userId: userId },
    function() {
        addCableLineLayer.destroyFeatures();
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
    notyInformation.close();
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
            { coors: json, mode: "updCableLine", userId: userId }, function() {
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

function selectDeleteCableLine( event, del ) {
    del = ( typeof del === "undefined" ) ? false : del;
    notyInformation.close();
    if ( selectDeleteCableLineMode && del ) {
        jsonCoor = {
            CableLineId: "",
            coorArr: [ ]
        };
        var feature = event.feature;
        jsonCoor.CableLineId = CableLineEdtInfo[feature.id]['cableLineId'];
        json = JSON.stringify(
                jsonCoor );
        $.post( "map_post.php",
                { coors: json, mode: "deleteCableLine", userId: userId },
        function() {
            refreshAllLayers();
        } );
    }
    else if ( selectDeleteCableLineMode && !del ) {
        showDeleteCableLineQuestion( 'center',
                'Вы действительно хотите удалить кабельную линию?',
                function() {
                    selectDeleteCableLine( event, true );
                } );
    }
}

function isEndLine( selectedCoor ) {
    var fId = selectedLineAddSingPoint.id;
    var currSeqStart = CableLineEdtInfo[fId]['seqStart'];
    var currSeqEnd = CableLineEdtInfo[fId]['seqEnd'];
    var superSeqEnd = CableLineEdtInfo[fId]['superSeqEnd'];
    var coor = selectedLineAddSingPoint.geometry.getVertices();
    if ( currSeqStart == 0 || currSeqEnd == superSeqEnd ) {
        if ( ( coor[0].x == selectedCoor[0].x && coor[0].y == selectedCoor[0].y ) || ( coor[coor.length - 1].x == selectedCoor[0].x ) && ( coor[coor.length - 1].y == selectedCoor[0].y ) ) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}