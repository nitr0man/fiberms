<?php

require_once( "backend/functions.php" );
require_once( "backend/map.php" );

if ( $_SERVER[ "REQUEST_METHOD" ] == 'POST' )
{
    checkData();
    $obj = json_decode( $_POST[ 'coors' ] );
    $coors = $obj->{'coorArr'};
    $CableLineId = (int)$obj->{'CableLineId'};
    if ( $_POST[ 'mode' ] == "updCableLine" )
    {
        $seqStart = $obj->{'seqStart'};
        $seqEnd = $obj->{'seqEnd'};
        updCableLinePoints( $coors, $CableLineId, $seqStart, $seqEnd, TRUE );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "addCableLine" )
    {
        $length = $obj->{'length'};
        $name = $obj->{'name'};
        $comment = $obj->{'comment'};
        $CableType = $obj->{'CableType'};
        addCableLinePoint( $coors, $CableType, $length, $name, $comment, TRUE );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "addSingPoint" )
    {
        require_once("func/CableType.php");

        $apartment = $obj->{'apartment'};
        $building = $obj->{'building'};
        $meterSign = $obj->{'meterSign'};
        $note = $obj->{'note'};
        $networkNode = $obj->{'networkNode'};
        addSingPoint( $coors, $CableLineId, $networkNode, "NULL", "NULL",
                $meterSign, $note );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "deleteSingPoint" )
    {
        deleteSingPoint( $coors, TRUE );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "deleteCableLine" )
    {
        deleteCableLine( $CableLineId, TRUE );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "addNode" )
    {
        $NetworkBoxId = $obj->{'NetworkBoxId'};
        $apartment = $obj->{'apartment'};
        $building = $obj->{'building'};
        $note = $obj->{'note'};
        $name = $obj->{'name'};
        addNode( $coors, $name, $NetworkBoxId, $note, $SettlementGeoSpatial,
                $building, $apartment, TRUE );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "deleteNode" )
    {
        deleteNode( $coors, TRUE );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "divCableLine" )
    {
        $nodeInfo[ 'name' ] = $obj->{'name'};
        $nodeInfo[ 'NetworkBoxId' ] = $obj->{'NetworkBoxId'};
        $nodeInfo[ 'apartment' ] = $obj->{'apartment'};
        $nodeInfo[ 'building' ] = $obj->{'building'};
        $nodeInfo[ 'note' ] = $obj->{'note'};
        divCableLine( $coors, $CableLineId, $nodeInfo, TRUE );
        setTmpMapLastEdit();
    }
    elseif ( $_POST[ 'mode' ] == "save" )
    {
        saveTmpData();
    }
    elseif ( $_POST[ 'mode' ] == "cancel" )
    {
        dropTmpTables();
        setMapLastEdit();
    }
    setMapUserActivity();
}
print( "OK" );
?>