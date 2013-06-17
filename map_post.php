<?php

require_once( "backend/functions.php" );
require_once( "backend/map.php" );

if ( $_SERVER[ "REQUEST_METHOD" ] == 'POST' )
{
    $obj = json_decode( $_POST[ 'coors' ] );
    $coors = $obj->{'coorArr'};
    $CableLineId = $obj->{'CableLineId'};
    if ( $_POST[ 'mode' ] == "updCableLine" )
    {
        $seqStart = $obj->{'seqStart'};
        $seqEnd = $obj->{'seqEnd'};
        updCableLinePoints( $coors, $CableLineId, $seqStart, $seqEnd );
    }
    elseif ( $_POST[ 'mode' ] == "addCableLine" )
    {
        $length = $obj->{'length'};
        $name = $obj->{'name'};
        $comment = $obj->{'comment'};
        $CableType = $obj->{'CableType'};
        addCableLinePoint( $coors, $CableType, $length, $name, $comment );
    }
    elseif ( $_POST[ 'mode' ] == "addSingPoint" )
    {
        require_once("func/CableType.php");

        $apartment = $obj->{'apartment'};
        $building = $obj->{'building'};
        $meterSign = $obj->{'meterSign'};
        $note = $obj->{'note'};
        $networkNode = $obj->{'networkNode'};
        addSingPoint( $coors, $CableLineId, $networkNode, $apartment, $building,
                $meterSign, $note );
    }
}
?>