<?php

require_once "backend/functions.php";
require_once "backend/map.php";

ini_set('display_errors', false);

if ( $_SERVER[ "REQUEST_METHOD" ] == 'POST' )
{
    $obj = json_decode( $_POST[ 'coors' ] );
    $coors = $obj->{'coorArr'};
    $CableLineId = (int)$obj->{'CableLineId'};
    $uId = (int)$_POST[ 'userId' ];
    $_SESSION[ 'user_id' ] = $uId;
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
        require_once ( "func/CableType.php" );

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
    elseif ( $_POST[ 'mode' ] == "moveNode" )
    {
        moveNode( $coors, TRUE );
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
    elseif ( $_POST[ 'mode' ] == "addNetworkBox" )
    {
        $networkBoxType = $obj->{'networkBoxType'};
        $invNum = $obj->{'invNum'};
        $boxId = addNetworkBox( $networkBoxType, $invNum, TRUE );
        if (defined($boxId['id'])) {
           $result = array( "NetworkBoxId" => $boxId['id'] );
        } else {
           $result = array( "error" => $boxId['error'] );
        }
        setTmpMapLastEdit();
        setMapUserActivity( $uId );
        print json_encode( $result );
        die();
    }
    elseif ( $_POST[ 'mode' ] == "save" )
    {
        $result = saveTmpData();
        if (defined($result['error'])) {
            print json_encode( array( "error" => $result['error'] ) );
        }
    }
    elseif ( $_POST[ 'mode' ] == "cancel" )
    {
        setMapLastEdit();
        checkData();
    }
    setMapUserActivity( $uId );
}
?>