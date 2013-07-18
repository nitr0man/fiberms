function parseCableLineXML(
        Response ) {
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
                case "sequenceStart":
                    CableLine_arr[i]['sequenceStart'] = f_child.firstChild.nodeValue;
                    break;
                case "sequenceEnd":
                    CableLine_arr[i]['sequenceEnd'] = f_child.firstChild.nodeValue;
                    break;
                case "superSequenceEnd":
                    CableLine_arr[i]['superSeqEnd'] = f_child.firstChild.nodeValue;
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
    /*GetXMLFile(
     "get_layers.php?mode=GetNetworkNodesDescription",
     parseNetworkNodesDescriptionXML ); // получаем описание для узлов*/
    getData();
    GetXMLFile(
            "getLayers_edt.php?mode=GetNodesLabels",
            parseNodesLabelsXML ); // получаем надписи для узлов
}

function parseNetworkNodesDescriptionXML(
        Response ) {
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

    GetXMLFile(
            "getLayers_edt.php?mode=GetNodesLabels",
            parseNodesLabelsXML ); // получаем надписи для узлов
}

function parseNodesLabelsXML(
        Response ) {
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
    if ( mapCr ) {
        init();
    } else {
        drawFeatures();
    }
}