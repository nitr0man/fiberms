<?php

require_once('backend/functions.php');
require_once('backend/CableType.php');
require_once('backend/NetworkNode.php');
require_once('backend/FS.php');

if ( $_GET[ 'mode' ] == 'GetCableLines' )
{ // кабельные линии
    $res = getCableLineList( 0, '', -1, -1 );
    /* if ( $res[ 'count' ] == 0 )
      {
      die();
      } */
    $rows = $res[ 'rows' ];

    $dom = new DomDocument( '1.0', 'UTF-8' );
    $cableLines = $dom->appendChild( $dom->createElement( 'cableLines' ) );
    $cableLinesFrag = getCableLinesFrag( $rows, FALSE );
    //print_r($cableLinesFrag);
    $cableInfo = array();
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $cableInfo[ $rows[ $i ][ 'id' ] ] = $rows[ $i ];
    }
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
            $name = $name->appendChild( $dom->createTextNode( $cableInfo[ $cableLineId ][ 'name' ] ) );

            $cableTypeId = $cableLine->appendChild( $dom->createElement( 'cableTypeId' ) );
            if ( isset( $cableInfo[ $cableLineId ][ 'CableType' ] ) )
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( $cableInfo[ $cableLineId ][ 'CableType' ] ) );
            }
            else
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( 'NULL' ) );
            }

            $cableTypeId = $cableLine->appendChild( $dom->createElement( 'cableTypeMarking' ) );
            if ( isset( $cableInfo[ $cableLineId ][ 'marking' ] ) )
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( $cableInfo[ $cableLineId ][ 'marking' ] ) );
            }
            else
            {
                $cableTypeId = $cableTypeId->appendChild( $dom->createTextNode( 'NULL' ) );
            }
            $direction = $cableLine->appendChild( $dom->createElement( 'direction' ) );
            $direction = $direction->appendChild( $dom->createTextNode( $direction_href ) );

            $modules = $cableLine->appendChild( $dom->createElement( 'modules' ) );
            if ( $cableInfo[ $cableLineId ][ 'fiberPerTube' ] != 0 )
            {
                $modules = $modules->appendChild( $dom->createTextNode( (int)( ($cableInfo[ $cableLineId ][ 'fibers' ] - 1) / $cableInfo[ $cableLineId ][ 'fiberPerTube' ] + 1 ) ) );
            }
            else
            {
                $modules = $modules->appendChild( $dom->createTextNode( 'NULL' ) );
            }

            $fibers = $cableLine->appendChild( $dom->createElement( 'fibers' ) );
            if ( isset( $cableInfo[ $cableLineId ][ 'fibers' ] ) )
            {
                $fibers = $fibers->appendChild( $dom->createTextNode( $cableInfo[ $cableLineId ][ 'fibers' ] ) );
            }
            else
            {
                $fibers = $fibers->appendChild( $dom->createTextNode( 'NULL' ) );
            }

            $free_fibers = $cableLine->appendChild( $dom->createElement( 'free_fibers' ) );
            $free_fibers = $free_fibers->appendChild( $dom->createTextNode( (int)($cableInfo[ $cableLineId ][ 'fibers' ] - $cableInfo[ $cableLineId ][ 'FiberSpliceCount' ]) ) );

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
    print( $res );
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
    /* if ( $res[ 'count' ] == 0 )
      {
      die();
      } */
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
            $clpId = $rows[ $i ][ 'CLPId' ];            
            $title = '<a target="_blank" href="CableLinePoint.php?mode=change&cablelineid='.$rows[ $i ][ 'CableLine' ].'&cablelinepointid='.$clpId.'">'.$rows[ $i ][ 'CableLineName' ].'</a>';
            $description = '<a target="_blank" href="CableLinePoint.php?mode=change&cablelineid='.$rows[ $i ][ 'CableLine' ].'&cablelinepointid='.$clpId.'">Отметка: '.$rows[ $i ][ 'meterSign' ].'</a>';
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
    require_once 'func/FiberSplice.php';

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
            $cableLines_row = getCableLineInfo( $rows[ $i ][ 'id' ] );
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
                 'Примечание: './* nl2br($rows[$i]['note']) */str_replace( array(
                     "\r\n", "\n", "\r" ), "<br>", $rows[ $i ][ 'note' ] ).'<br>'.
                 'Входящие линии: <ul>'.
                 '<li>Всего: '.(string)($cableLinesZeroFibers + $cableLinesNotZeroFibers).'</li>'.
                 '<li>0 волокон: '.$cableLinesZeroFibers.'</li>'.
                 '<li>1+ волокон: '.$cableLinesNotZeroFibers.'</li>'.
                 '</ul>'.
                 'К-во сварок: '.$fiberSpliceCount;
            $fibRes = getFiberTable( $rows[ $i ][ 'id' ] );
            if ( $fibRes[ 'maxfiber' ] > 0 )
            {
                $desc .= '<br>[<a target="_blank" href="FiberSplice.php?networknodeid='.$rows[ $i ][ 'id' ].'">Таблица сварок</a>]';
            }

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
?>