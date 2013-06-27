<?php

require_once('backend/functions.php');
require_once('backend/CableType.php');
require_once('backend/NetworkNode.php');
require_once('backend/FS.php');

if ( $_GET[ 'mode' ] == 'GetCableLines' )
{ // кабельные линии
    $res = getCableLineList( 0, '' );
    if ( $res[ 'count' ] == 0 )
    {
        die();
    }
    $rows = $res[ 'rows' ];

    $dom = new DomDocument( '1.0', 'UTF-8' );
    $cableLines = $dom->appendChild( $dom->createElement( 'cableLines' ) );
    $cableLinesFrag = getCableLinesFrag( $rows );
    //print_r($cableLinesFrag);
    foreach ( $cableLinesFrag as $key => $value )
    {
        //print_r($value);
        //print_r($key);
        $cableLineId = $key;
        for ( $i = 0; $i < count( $value ); $i++ )
        {
            $cableLine = $cableLines->appendChild( $dom->createElement( 'cableLine' ) );
            for ( $j = 0; $j < count( $value[ $i ] ); $j++ )
            {
                $node = $cableLine->appendChild( $dom->createElement( 'node' ) );

                $node_attr = $dom->createAttribute( 'lat' );
                $node_attr->value = $value[ $i ][ $j ][ 'lat' ];
                $node->appendChild( $node_attr );

                $node_attr = $dom->createAttribute( 'lon' );
                $node_attr->value = $value[ $i ][ $j ][ 'lon' ];
                $node->appendChild( $node_attr );

                $node_attr = $dom->createAttribute( 'id' );
                $node_attr->value = $value[ $i ][ $j ][ 'id' ];
                $node->appendChild( $node_attr );
            }
            $direction_row = getCableLineDirection( $cableLineId, -1, -1 );
            if ( $direction_row[ 0 ][ 'name' ] != '-' )
            {
                $direction_href = '<a href="NetworkNodes.php?mode=charac&nodeid='.$direction_row[ 0 ][ 'NetworkNode' ].'">'.$direction_row[ 0 ][ 'name' ].'</a> - <a href="NetworkNodes.php?mode=charac&nodeid='.$direction_row[ 1 ][ 'NetworkNode' ].'">'.$direction_row[ 1 ][ 'name' ].'</a>';
            }
            else
            {
                $direction_href = '-';
            }

            $cableId = $cableLine->appendChild( $dom->createElement( 'cableLineId' ) );
            $cableId = $cableId->appendChild( $dom->createTextNode( $cableLineId ) );

            $name = $cableLine->appendChild( $dom->createElement( 'name' ) );
            $name = $name->appendChild( $dom->createTextNode( $rows[ $i ][ 'name' ] ) );

            $cableTypeId = $cableLine->appendChild( $dom->createElement( 'cableTypeId' ) );
            if ( isset( $rows[ $i ][ 'CableType' ] ) )
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( $rows[ $i ][ 'CableType' ] ) );
            }
            else
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( 'NULL' ) );
            }

            $cableTypeId = $cableLine->appendChild( $dom->createElement( 'cableTypeMarking' ) );
            if ( isset( $rows[ $i ][ 'marking' ] ) )
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( $rows[ $i ][ 'marking' ] ) );
            }
            else
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( 'NULL' ) );
            }
            $direction = $cableLine->appendChild( $dom->createElement( 'direction' ) );
            $direction = $direction->appendChild( $dom->createTextNode( $direction_href ) );

            $modules = $cableLine->appendChild( $dom->createElement( 'modules' ) );
            if ( $rows[ $i ][ 'fiberPerTube' ] != 0 )
            {
                $modules = $modules->appendChild( $dom->createTextNode( (int) ( ($rows[ $i ][ 'fibers' ] - 1) / $rows[ $i ][ 'fiberPerTube' ] + 1 ) ) );
            }
            else
            {
                $modules = $modules->appendChild( $dom->createTextNode( 'NULL' ) );
            }

            $fibers = $cableLine->appendChild( $dom->createElement( 'fibers' ) );
            if ( isset( $rows[ $i ][ 'fibers' ] ) )
            {
                $fibers = $fibers->appendChild( $dom->createTextNode( $rows[ $i ][ 'fibers' ] ) );
            }
            else
            {
                $fibers = $fibers->appendChild( $dom->createTextNode( 'NULL' ) );
            }

            $free_fibers = $cableLine->appendChild( $dom->createElement( 'free_fibers' ) );
            $free_fibers = $free_fibers->appendChild( $dom->createTextNode( (int) ($rows[ $i ][ 'fibers' ] - $rows[ $i ][ 'FiberSpliceCount' ]) ) );

            $sequenceStart = $cableLine->appendChild( $dom->createElement( 'sequenceStart' ) );
            $sequenceStart = $sequenceStart->appendChild( $dom->createTextNode( $value[ $i ][ 0 ][ 'sequence' ] ) );

            $sequenceEnd = $cableLine->appendChild( $dom->createElement( 'sequenceEnd' ) );
            $sequenceEnd = $sequenceEnd->appendChild( $dom->createTextNode( $value[ $i ][ count( $value[ $i ] ) - 1 ][ 'sequence' ] ) );

            $superSequenceEnd = $cableLine->appendChild( $dom->createElement( 'superSequenceEnd' ) );
            $superSequenceEnd = $superSequenceEnd->appendChild( $dom->createTextNode( $value[ $i ][ 0 ][ 'superSequenceEnd' ] ) );
        }
    }
    $dom->formatOutput = true;
    $res = $dom->saveXML();

    header( "content-type: text/xml" );
    print($res );
    exit;

    $j = 0;
    $chng = false;
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $cableLinePoints_res = getCableLinePoints( $rows[ $i ][ 'id' ] );
        if ( $cableLinePoints_res[ 'count' ] < 1 )
        {
            continue;
        }
        $cableLine = $cableLines->appendChild( $dom->createElement( 'cableLine' ) );
        /* $work = true;
          while ( $work )
          {

          } */
        /* for ( $j = 0; $j < $cableLinePoints_res['count']; $j++ ) */ while ( $j < $cableLinePoints_res[ 'count' ] )
        {
            if ( $j == $cableLinePoints_res[ 'count' ] )
            {
                $j = 0;
                break;
            }
            $OpenGIS = $cableLinePoints_res[ 'rows' ][ $j ][ 'OpenGIS' ];
            $cableLinePointId = $cableLinePoints_res[ 'rows' ][ $j ][ 'id' ];
            if ( ( $cableLinePoints_res[ 'rows' ][ $j ][ 'note' ] != '' ) || ( $cableLinePoints_res[ 'rows' ][ $j ][ 'meterSign' ] != '' ) )
            {
                //$i--;
                $chng = true;
                $j++;
                break;
            }
            if ( preg_match_all( '/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS,
                            $matches ) )
            {
                $node = $cableLine->appendChild( $dom->createElement( 'node' ) );

                $node_attr = $dom->createAttribute( 'lat' );
                $node_attr->value = $matches[ 'y' ][ 0 ];
                $node->appendChild( $node_attr );

                $node_attr = $dom->createAttribute( 'lon' );
                $node_attr->value = $matches[ 'x' ][ 0 ];
                $node->appendChild( $node_attr );

                $node_attr = $dom->createAttribute( 'id' );
                $node_attr->value = $cableLinePointId;
                $node->appendChild( $node_attr );

                $node_attr = $dom->createAttribute( 'ms' );
                $node_attr->value = $cableLinePoints_res[ 'rows' ][ $j ][ 'meterSign' ];
                $node->appendChild( $node_attr );
            }
            $j++;
        }
        $direction_row = getCableLineDirection( $rows[ $i ][ 'id' ], -1, -1 );
        if ( $direction_row[ 0 ][ 'name' ] != '-' )
        {
            $direction_href = '<a href="NetworkNodes.php?mode=charac&nodeid='.$direction_row[ 0 ][ 'NetworkNode' ].'">'.$direction_row[ 0 ][ 'name' ].'</a> - <a href="NetworkNodes.php?mode=charac&nodeid='.$direction_row[ 1 ][ 'NetworkNode' ].'">'.$direction_row[ 1 ][ 'name' ].'</a>';
        }
        else
        {
            $direction_href = '-';
        }

        $cableId = $cableLine->appendChild( $dom->createElement( 'cableLineId' ) );
        $cableId = $cableId->appendChild( $dom->createTextNode( $rows[ $i ][ 'id' ] ) );

        $name = $cableLine->appendChild( $dom->createElement( 'name' ) );
        $name = $name->appendChild( $dom->createTextNode( $rows[ $i ][ 'name' ] ) );

        $cableTypeId = $cableLine->appendChild( $dom->createElement( 'cableTypeId' ) );
        if ( isset( $rows[ $i ][ 'CableType' ] ) )
        {
            $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( $rows[ $i ][ 'CableType' ] ) );
        }
        else
        {
            $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( 'NULL' ) );
        }

        $cableTypeId = $cableLine->appendChild( $dom->createElement( 'cableTypeMarking' ) );
        if ( isset( $rows[ $i ][ 'marking' ] ) )
        {
            $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( $rows[ $i ][ 'marking' ] ) );
        }
        else
        {
            $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( 'NULL' ) );
        }
        $direction = $cableLine->appendChild( $dom->createElement( 'direction' ) );
        $direction = $direction->appendChild( $dom->createTextNode( $direction_href ) );

        $modules = $cableLine->appendChild( $dom->createElement( 'modules' ) );
        if ( $rows[ $i ][ 'fiberPerTube' ] != 0 )
        {
            $modules = $modules->appendChild( $dom->createTextNode( (int) ( ($rows[ $i ][ 'fibers' ] - 1) / $rows[ $i ][ 'fiberPerTube' ] + 1 ) ) );
        }
        else
        {
            $modules = $modules->appendChild( $dom->createTextNode( 'NULL' ) );
        }

        $fibers = $cableLine->appendChild( $dom->createElement( 'fibers' ) );
        if ( isset( $rows[ $i ][ 'fibers' ] ) )
        {
            $fibers = $fibers->appendChild( $dom->createTextNode( $rows[ $i ][ 'fibers' ] ) );
        }
        else
        {
            $fibers = $fibers->appendChild( $dom->createTextNode( 'NULL' ) );
        }

        $free_fibers = $cableLine->appendChild( $dom->createElement( 'free_fibers' ) );
        $free_fibers = $free_fibers->appendChild( $dom->createTextNode( (int) ($rows[ $i ][ 'fibers' ] - $rows[ $i ][ 'FiberSpliceCount' ]) ) );
        if ( $chng )
        {
            $chng = false;
            $cableLine = $cableLines->appendChild( $dom->createElement( 'cableLine' ) );
            $i--;
        }
    }
    $dom->formatOutput = true;
    $res = $dom->saveXML();

    header( "content-type: text/xml" );
    print($res );
}
elseif ( $_GET[ 'mode' ] == 'GetNodesMarkers' )
{
    //header('Content-Type: text/html; charset=utf-8', true);
    $res = getNetworkNodeList_NetworkBoxName( '', '', '' );
    $rows = $res[ 'rows' ];

    $pois_text = "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $OpenGIS = $rows[ $i ][ 'OpenGIS' ];
        if ( preg_match_all( '/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches ) )
        {
            $fiberSpliceCount = $rows[ $i ][ 'fiberSpliceCount' ];
            $cableLines_row = getCableLineInfo( $rows[ $i ][ 'id' ], 1 );
            $cableLinesZeroFibers = 0;
            $cableLinesNotZeroFibers = 0;
            for ( $j = 0; $j < $cableLines_row[ 'count' ]; $j++ )
            {
                if ( $cableLines_row[ 'rows' ][ $j ][ 'fiber' ] > 0 )
                {
                    $cableLinesNotZeroFibers++;
                }
                else
                {
                    $cableLinesZeroFibers++;
                }
            }
            $lat = $matches[ 'y' ][ 0 ];
            $lon = $matches[ 'x' ][ 0 ];
            $title = '<a target="_blank" href="NetworkNodes.php?mode=charac&nodeid='.$rows[ $i ][ 'id' ].'">'.$rows[ $i ][ 'name' ].'</a>';
            /* $description = 'Ящик: <a target="_blank" href="NetworkBox.php?mode=charac&boxid='.$rows[$i]['NetworkBox'].'">'.$rows[$i]['inventoryNumber'].'</a><br>'.
              'Тип ящика: <a target="_blank" href="NetworkBoxType.php?mode=charac&boxtypeid='.$rows[$i]['NetworkBoxType'].'">'.$rows[$i]['NBTmarking'].'</a><br>'.
              //'Примечание: './*nl2br($rows[$i]['note'])str_replace(array("\r\n", "\n", "\r"), "<br>", $rows[$i]['note']).'<br>'.
              'fff<br>'.
              'Входящие линии: <ul>'.
              '<li>Всего: '.(string)($cableLinesZeroFibers + $cableLinesNotZeroFibers).'</li>'.
              '<li>0 волокон: '.$cableLinesZeroFibers.'</li>'.
              '<li>1+ волокон: '.$cableLinesNotZeroFibers.'</li>'.
              '</ul>'.
              'К-во сварок: '.$fiberSpliceCount.'<br>'.
              '[<a target="_blank" href="FiberSplice.php?networknodeid='.$rows[$i]['id'].'">Таблица сварок</a>]'; */
            //$icon        = "pic/Ol_icon_blue_example.png";
            $description = $i;
            $icon = "pic/node_pic.png";
            $iconSize = "10,10";
            $iconOffset = "-3,-3";

            $pois_text .= $lat."\t".$lon."\t".$title."\t".$description."\t".$icon."\t".$iconSize."\t".$iconOffset."\n";
        }
    }
    print($pois_text );
}
elseif ( $_GET[ 'mode' ] == 'GetNodesLabels' )
{
    $res = getNetworkNodeList_NetworkBoxName( '', '', '' );
    if ( $res[ 'count' ] == 0 )
    {
        die();
    }
    $rows = $res[ 'rows' ];

    $dom = new DomDocument( '1.0', 'UTF-8' );
    $nodesLabels = $dom->appendChild( $dom->createElement( 'nodesLabels' ) );
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $nodeLabel = $nodesLabels->appendChild( $dom->createElement( 'nodeLabel' ) );

        $OpenGIS = $rows[ $i ][ 'OpenGIS' ];
        if ( preg_match_all( '/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches ) )
        {
            $lat = $matches[ 'y' ][ 0 ];
            $lon = $matches[ 'x' ][ 0 ];

            $node = $nodeLabel->appendChild( $dom->createElement( 'node' ) );

            $node_attr = $dom->createAttribute( 'lat' );
            $node_attr->value = $matches[ 'y' ][ 0 ];
            $node->appendChild( $node_attr );

            $node_attr = $dom->createAttribute( 'lon' );
            $node_attr->value = $matches[ 'x' ][ 0 ];
            $node->appendChild( $node_attr );

            $title = $nodeLabel->appendChild( $dom->createElement( 'title' ) );
            $title = $title->appendChild( $dom->createTextNode( $rows[ $i ][ 'name' ] ) );

            $ident = $nodeLabel->appendChild( $dom->createElement( 'ident' ) );
            $ident = $ident->appendChild( $dom->createTextNode( $i ) );
        }
    }
    $dom->formatOutput = true;
    $res = $dom->saveXML();

    header( "content-type: text/xml" );
    print($res );
}
elseif ( $_GET[ 'mode' ] == 'GetSingularCableLinePoints' )
{
    $res = getSingularCableLinePoints( 1 );
    $rows = $res[ 'rows' ];

    $pois_text = "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $OpenGIS = $rows[ $i ][ 'OpenGIS' ];
        if ( preg_match_all( '/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches ) )
        {
            $lat = $matches[ 'y' ][ 0 ];
            $lon = $matches[ 'x' ][ 0 ];
            $title = '<a target="_blank" href="CableLine.php?mode=charac&cablelineid='.$rows[ $i ][ 'CableLine' ].'">'.$rows[ $i ][ 'CableLineName' ].'</a>';
            $description = '<a target="_blank" href="CableLine.php?mode=charac&cablelineid='.$rows[ $i ][ 'CableLine' ].'">Отметка: '.$rows[ $i ][ 'meterSign' ].'</a>';
            $icon = "pic/rhomb_pic.png";
            $iconSize = "7,7";
            $iconOffset = "-5,-5";

            $pois_text .= $lat."\t".$lon."\t".$title."\t".$description."\t".$icon."\t".$iconSize."\t".$iconOffset."\n";
        }
    }
    print($pois_text );
}
elseif ( $_GET[ 'mode' ] == 'GetNetworkNodesDescription' )
{
    $res = getNetworkNodeList_NetworkBoxName( '', '', '' );
    $rows = $res[ 'rows' ];

    $dom = new DomDocument( '1.0', 'UTF-8' );
    $nodesDescriptions = $dom->appendChild( $dom->createElement( 'nodesDescriptions' ) );
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $nodeDescription = $nodesDescriptions->appendChild( $dom->createElement( 'nodeDescription' ) );

        $OpenGIS = $rows[ $i ][ 'OpenGIS' ];
        if ( preg_match_all( '/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches ) )
        {
            //$fiberSpliceCount = getFiberSpliceCount_NetworkNode($rows[$i]['id']);
            $fiberSpliceCount = $rows[ $i ][ 'fiberSpliceCount' ];
            $cableLines_row = getCableLineInfo( $rows[ $i ][ 'id' ], 1 );
            $cableLinesZeroFibers = 0;
            $cableLinesNotZeroFibers = 0;
            for ( $j = 0; $j < $cableLines_row[ 'count' ]; $j++ )
            {
                if ( $cableLines_row[ 'rows' ][ $j ][ 'fiber' ] > 0 )
                {
                    $cableLinesNotZeroFibers++;
                }
                else
                {
                    $cableLinesZeroFibers++;
                }
            }
            $desc = 'Ящик: <a target="_blank" href="NetworkBox.php?mode=charac&boxid='.$rows[ $i ][ 'NetworkBox' ].'">'.$rows[ $i ][ 'inventoryNumber' ].'</a><br>'.
                    'Тип ящика: <a target="_blank" href="NetworkBoxType.php?mode=charac&boxtypeid='.$rows[ $i ][ 'NetworkBoxType' ].'">'.$rows[ $i ][ 'NBTmarking' ].'</a><br>'.
                    'Примечание: './* nl2br($rows[$i]['note']) */str_replace( array( "\r\n", "\n", "\r" ),
                            "<br>", $rows[ $i ][ 'note' ] ).'<br>'.
                    'Входящие линии: <ul>'.
                    '<li>Всего: '.(string) ($cableLinesZeroFibers + $cableLinesNotZeroFibers).'</li>'.
                    '<li>0 волокон: '.$cableLinesZeroFibers.'</li>'.
                    '<li>1+ волокон: '.$cableLinesNotZeroFibers.'</li>'.
                    '</ul>'.
                    'К-во сварок: '.$fiberSpliceCount.'<br>'.
                    '[<a target="_blank" href="FiberSplice.php?networknodeid='.$rows[ $i ][ 'id' ].'">Таблица сварок</a>]';

            $index = $nodeDescription->appendChild( $dom->createElement( 'index' ) );
            $index = $index->appendChild( $dom->createTextNode( $i ) );

            $description = $nodeDescription->appendChild( $dom->createElement( 'description' ) );
            $description = $description->appendChild( $dom->createTextNode( $desc ) );
        }
    }
    $dom->formatOutput = true;
    $res = $dom->saveXML();

    header( "content-type: text/xml" );
    print($res );
}
elseif ( $_GET[ 'mode' ] == "GetCableTypes" )
{
    $res = CableType_SELECT( '', '' );
    $rows = $res[ 'rows' ];
    $cableTypesJSON[ 'CableTypes' ] = array( );
    $i = -1;
    while ( ++$i < $res[ 'count' ] )
    {
        $cableTypesJSON[ 'CableTypes' ][ $i ][ 'id' ] = (int) $rows[ $i ][ 'id' ];
        $cableTypesJSON[ 'CableTypes' ][ $i ][ 'marking' ] = $rows[ $i ][ 'marking' ];
    }
    $res = json_encode( $cableTypesJSON );
    print( $res );
}
elseif ( $_GET[ 'mode' ] == "GetNodes" )
{
    require_once("backend/NetworkNode.php");

    $res = NetworkNode_SELECT( 0, '', '' );
    $rows = $res[ 'rows' ];
    $nodesJSON[ 'Nodes' ] = array( );
    $i = -1;
    while ( ++$i < $res[ 'count' ] )
    {
        $nodesJSON[ 'Nodes' ][ $i ][ 'id' ] = (int) $rows[ $i ][ 'id' ];
        $nodesJSON[ 'Nodes' ][ $i ][ 'name' ] = $rows[ $i ][ 'name' ];
    }
    $res = json_encode( $nodesJSON );
    print( $res );
}
elseif ( $_GET[ 'mode' ] == "GetNetworkBoxes" )
{
    require_once("backend/NetworkNode.php");

    $res = getFreeNetworkBoxes( -1 );
    $rows = $res[ 'rows' ];
    $boxesJSON[ 'Boxes' ] = array( );
    $i = -1;
    while ( ++$i < $res[ 'count' ] )
    {
        $boxesJSON[ 'Boxes' ][ $i ][ 'id' ] = (int) $rows[ $i ][ 'id' ];
        $boxesJSON[ 'Boxes' ][ $i ][ 'inventoryNumber' ] = $rows[ $i ][ 'inventoryNumber' ];
    }
    $res = json_encode( $boxesJSON );
    print( $res );
}
?>