<?php

require_once( "backend/functions.php" );
require_once( "backend/map.php" );

if ( $_SERVER[ "REQUEST_METHOD" ] == 'POST' )
{
    $obj = json_decode( $_POST[ 'coors' ] );
    $coors = $obj->{'coorArr'};
    $CableLine = $obj->{'CableLineId'};
    if ( $CableLine != -1 )
    {
        $seqStart = $obj->{'seqStart'};
        $seqEnd = $obj->{'seqEnd'};
        updCableLinePoints( $coors, $CableLine, $seqStart, $seqEnd );
    }
    else
    {
        $length = $obj->{'length'};
        $name = $obj->{'name'};
        $comment = $obj->{'comment'};
        $CableType = $obj->{'CableType'};
        addCableLinePoint( $coors, $CableType, $length, $name, $comment );
    }
}
?>