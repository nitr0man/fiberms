function addNodeMsg( event ) {
    var jsonNodeCoor = {
        name: "",
        NetworkBoxId: "",
/*        apartment: "",
        building: "",*/
        note: "",
        coorArr: [ ]
    };
    /*if ( networkBoxesArr.length < 1 ) {
     addNodeLayer.destroyFeatures();
     showError( 'topCenter', 'Нет свободных ящиков!' );
     return;
     }*/
    var feature = event.feature;
    var coorNode = feature.geometry.getVertices();
    var firstId = -1;
    if ( !!networkBoxesArr[0] ) {
        firstId = networkBoxesArr[0].id;
    }

    Ext.define( 'NetworkBoxesModel', {
        extend: 'Ext.data.Model',
        fields: [
            'value',
            'text'
        ]
    } );

    boxCombo = Ext.form.ComboBox( {
        xtype: 'combo',
        flex: 1,
        editable: false,
        name: 'networkBox',
        valueField: 'value',
        displayField: 'text',
        store: new Ext.data.SimpleStore( {
            id: firstId,
            fields:
                    [
                        'value',
                        'text'
                    ],
            data: networkBoxesArr
        } )
    } );

    nodeForm = Ext.create( 'Ext.form.Panel', {
        bodyPadding: 10,
        defaultType: 'textfield',
        items: [
            {
                xtype: 'fieldcontainer',
                layout: 'hbox',
                fieldLabel: 'Ящик',
                items: [
                    Ext.form.ComboBox( boxCombo ),
                    {
                        xtype: 'button',
                        text: '+',
                        handler: function() {
                            addNetworkBox();
                        }
                    } ]
            },
            {
                fieldLabel: 'Имя',
                name: 'name',
                value: ''
            },
/*            {
                fieldLabel: 'Квартира',
                name: 'apartment',
                value: ''
            },
            {
                fieldLabel: 'Здание',
                name: 'building',
                value: ''
            },*/
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
                    jsonNodeCoor.name = form.getValues().name;
                    jsonNodeCoor.NetworkBoxId = form.getValues().networkBox;
/*                    jsonNodeCoor.building = form.getValues().building;
                    jsonNodeCoor.apartment = form.getValues().apartment;*/
                    jsonNodeCoor.note = form.getValues().note;
                    if ( jsonNodeCoor.name == "" || jsonNodeCoor.NetworkBoxId == "" ) {
                        alert( 'Заполните поля!' );
                    } else {
                        addNode( coorNode,
                                jsonNodeCoor );
                        nodeDialog.destroy();
                    }
                }
            }
        ]
    } );

    nodeDialog = new Ext.Window( {
        title: "Добавить узел",
        layout: "fit",
        height: 220, width: 330,
        plain: true,
        items: [ nodeForm ]
    } );
    nodeDialog.on( 'close', function() {
        addNodeLayer.destroyFeatures();
    } );
    nodeDialog.show();
}

function addNetworkBox() {
    var networkBoxForm = Ext.create( 'Ext.form.Panel', {
        bodyPadding: 10,
        defaultType: 'textfield',
        items: [
            {
                xtype: 'combobox',
                fieldLabel: 'Тип',
                name: 'networkBoxType',
                valueField: 'value',
                displayField: 'text',
                store: new Ext.data.SimpleStore( {
                    fields:
                            [
                                'value',
                                'text'
                            ],
                    data: networkBoxTypesArr
                } )
            },
            {
                fieldLabel: 'Инв. номер',
                name: 'invNum',
                value: ''
            }
        ],
        buttons: [
            {
                text: 'Добавить',
                handler: function() {
                    var form = this.up( 'form' ).getForm();
                    var jsonNodeCoor = { };
                    jsonNodeCoor.networkBoxType = form.getValues().networkBoxType;
                    jsonNodeCoor.invNum = form.getValues().invNum;
                    json = JSON.stringify( jsonNodeCoor );
                    $.post( "map_post.php",
                            { coors: json, mode: "addNetworkBox", userId: userId },
                    function( data )
                    {
                        var invNum = jsonNodeCoor.invNum.toString();
                        if ( invNum == "" ) {
                            invNum = "---";
                        }
                        networkBoxObj = JSON.parse( data );
                        if (networkBoxObj.error) {
                            alert(networkBoxObj.error);
                        } else if (networkBoxObj.NetworkBoxId) {
                            var el = Ext.create( 'NetworkBoxesModel',
                                [ parseInt( networkBoxObj.NetworkBoxId ),
                                    invNum ] );
                            boxCombo.store.add( el );
                        };
                        dialog.destroy( );
                    } );
                }
            }
        ]
    } );
    dialog = new Ext.Window( {
        title: "Добавить ящик",
        layout: "fit",
        height: 150, width: 330,
        plain: true,
        items: [ networkBoxForm ]
    } );
    dialog.show();
}

function addNode( coor, jsonNodeCoor ) {
    var ll = new OpenLayers.LonLat( coor[ 0 ].x,
            coor[ 0 ].y ).transform(
            new OpenLayers.Projection( "EPSG:900913" ),
            new OpenLayers.Projection( "EPSG:4326" ) );
    jsonNodeCoor.coorArr[ 0 ] = { };
    jsonNodeCoor.coorArr[ 0 ]["lon"] = ll.lon;
    jsonNodeCoor.coorArr[ 0 ]["lat"] = ll.lat;
    json = JSON.stringify( jsonNodeCoor );
    $.post( "map_post.php", { coors: json, mode: "addNode", userId: userId },
    function() {
        addNodeLayer.destroyFeatures();
        refreshAllLayers();
    } );
}

function selectDeleteNode( event, del ) {
    del = ( typeof del === "undefined" ) ? false : del;
    if ( selectDeleteNodeMode && del ) {
        notyInformation.close();
        var jsonCoor = {
            coorArr: [ ]
        };
        var feature = event.feature;
        var coorNode = feature.geometry.getVertices();
        var ll = new OpenLayers.LonLat( coorNode[ 0 ].x,
                coorNode[ 0 ].y ).transform(
                new OpenLayers.Projection( "EPSG:900913" ),
                new OpenLayers.Projection( "EPSG:4326" ) );
        jsonCoor.coorArr[0] = { };
        jsonCoor.coorArr[ 0 ]["lon"] = ll.lon;
        jsonCoor.coorArr[ 0 ]["lat"] = ll.lat;
        json = JSON.stringify( jsonCoor );
        $.post( "map_post.php",
                { coors: json, mode: "deleteNode", userId: userId },
        function() {
            refreshAllLayers();
        } );
    }
    else if ( selectDeleteNodeMode && !del ) {
        notyInformation.close();
        showDeleteCableLineQuestion( 'center',
                'Вы действительно хотите удалить узел?',
                function() {
                    selectDeleteNode( event, true );
                } );
    }
}

function moveFeature( event ) {
    var jsonCoor = {
        coorArr: [ ]
    };
    var feature = event.feature;
    var coorNode = feature.geometry.getVertices();
    var ll = new OpenLayers.LonLat( coorNode[ 0 ].x,
            coorNode[ 0 ].y ).transform(
            new OpenLayers.Projection( "EPSG:900913" ),
            new OpenLayers.Projection( "EPSG:4326" ) );
    jsonCoor.coorArr[0] = { };
    jsonCoor.coorArr[ 0 ]["lon"] = ll.lon;
    jsonCoor.coorArr[ 0 ]["lat"] = ll.lat;
    jsonCoor.coorArr[ 0 ]["id"] = feature.attributes.description;
    json = JSON.stringify( jsonCoor );
    $.post( "map_post.php",
            { coors: json, mode: "moveNode", userId: userId },
    function() {
        refreshAllLayers();
    } );
}