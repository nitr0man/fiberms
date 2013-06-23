function addNodeMsg( event ) {
    var jsonNodeCoor = {
        name: "",
        NetworkBoxId: "",
        apartment: "",
        building: "",
        note: "",
        coorArr: [ ]
    };
    if ( networkBoxesArr.length < 1 ) {
        addNodeLayer.destroyFeatures();
        // ToDo: show error msg
        return;
    }
    var feature = event.feature;
    var coorNode = feature.geometry.getVertices();
    form = Ext.create( 'Ext.form.Panel', {
        bodyPadding: 10,
        defaultType: 'textfield',
        items: [
            {
                xtype: 'combobox',
                fieldLabel: 'Ящик',
                name: 'networkBox',
                valueField: 'value',
                displayField: 'text',
                store: new Ext.data.SimpleStore( {
                    id: networkBoxesArr[0].id,
                    fields:
                            [
                                'value',
                                'text'
                            ],
                    data: networkBoxesArr
                } )
            },
            {
                fieldLabel: 'Имя',
                name: 'name',
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
                    jsonNodeCoor.name = form.getValues().name;
                    jsonNodeCoor.NetworkBoxId = form.getValues().networkBox;
                    jsonNodeCoor.building = form.getValues().building;
                    jsonNodeCoor.apartment = form.getValues().apartment;
                    jsonNodeCoor.note = form.getValues().note;
                    addNode( coorNode,
                            jsonNodeCoor );
                    dialog.destroy();
                }
            }
        ]
    } );
    dialog = new Ext.Window( {
        title: "Добавить узел",
        layout: "fit",
        height: 220, width: 330,
        plain: true,
        items: [ form ]
    } );
    dialog.show();
}

function addNode( coor, jsonNodeCoor ) {
    //coor = feature.geometry.getVertices();
    var ll = new OpenLayers.LonLat( coor[ 0 ].x,
            coor[ 0 ].y ).transform(
            new OpenLayers.Projection( "EPSG:900913" ),
            new OpenLayers.Projection( "EPSG:4326" ) );
    jsonNodeCoor.coorArr[ 0 ] = { };
    jsonNodeCoor.coorArr[ 0 ]["lon"] = ll.lon;
    jsonNodeCoor.coorArr[ 0 ]["lat"] = ll.lat;
    json = JSON.stringify( jsonNodeCoor );
    $.post( "map_post.php", { coors: json, mode: "addNode" },
    function() {
        refreshAllLayers();
    } );
    addNodeLayer.destroyFeatures();
}