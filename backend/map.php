<?php

require_once 'backend/NetworkNode.php';
require_once 'backend/CableType.php';
require_once 'func/CableType.php';
require_once 'func/NetworkNode.php';

function isSingPoint( $point )
{
    $res = FALSE;
    if ( $point[ 'meterSign' ] != "" || $point[ 'note' ] != "" )
    {
        $res = TRUE;
    }
    return $res;
}

function updCableLinePoints( $coors, $CableLine, $seqStart, $seqEnd )
{
    $query = 'SELECT * FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' ORDER BY "sequence"';
    $res = PQuery( $query );
    // error_log( print_r( $res, true ) );
    error_log( "seqStart=".$seqStart );
    error_log( "seqEnd=".$seqEnd );
    if ( isSingPoint( $res[ 'rows' ][ $seqStart ] ) && isSingPoint( $res[ 'rows' ][ $seqEnd ] ) )
    {
        error_log( "1" );
        $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqStart.' AND "sequence" < '.$seqEnd;
        error_log( "delete=".$query );
        PQuery( $query );
        if ( count( $coors ) != $res[ 'count' ] )
        {
            $seqDiff = count( $coors ) - ( $seqEnd - $seqStart ) - 1;
            $query = 'UPDATE "CableLinePoint" SET "sequence" = ("sequence" + '.$seqDiff.')*-1 WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqEnd;
            error_log( "update=".$query );
            PQuery( $query );
            $query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine.' AND "sequence" < 0';
            error_log( "update=".$query );
            PQuery( $query );
            $seq = $seqStart + 1;
        }
        else
        {
            $seq = 1;
        }
        $iSt = 1;
        $toMin = 1;
    }
    elseif ( isSingPoint( $res[ 'rows' ][ $seqEnd ] ) )
    {
        //error_log( "2" );
        $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" < '.$seqEnd;
        PQuery( $query );
        if ( count( $coors ) != $res[ 'count' ] )
        {
            $seqDiff = count( $coors ) - ( $seqEnd - $seqStart );
            $query = 'UPDATE "CableLinePoint" SET "sequence" = ("sequence" + '.$seqDiff.')*-1 WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqEnd;
            PQuery( $query );
            $query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine.' AND "sequence" < 0';
            PQuery( $query );
            $seq = $seqStart;
        }
        else
        {
            $seq = 0;
        }
        $iSt = 0;
        $toMin = 1;
    }
    else if ( isSingPoint( $res[ 'rows' ][ $seqStart ] ) )
    {
        //error_log( "3" );
        $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqStart.' AND "sequence" <= '.$seqEnd;
        //error_log( "delete=".$query );
        PQuery( $query );
        if ( count( $coors ) != $res[ 'count' ] )
        {
            $seqDiff = count( $coors ) - ( $seqEnd - $seqStart );
            $query = 'UPDATE "CableLinePoint" SET "sequence" = ("sequence" + '.$seqDiff.')*-1 WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqEnd;
            //error_log( "update=".$query );
            PQuery( $query );
            $query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine.' AND "sequence" < 0';
            //error_log( "update=".$query );
            PQuery( $query );
            $seq = $seqStart + 1;
        }
        else
        {
            $seq = 1;
        }
        $iSt = 1;
        $toMin = 0;
    }
    else
    {
        $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" <= '.$seqEnd;
        PQuery( $query );
        $seq = 0;
        $iSt = 0;
        $toMin = 0;
    }
    for ( $i = $iSt; $i < count( $coors ) - $toMin; $i++ )
    {
        $coor = "(".$coors[ $i ]->lon.",".$coors[ $i ]->lat.")";
        $ins[ 'OpenGIS' ] = $coor;
        $ins[ 'sequence' ] = $seq++;
        $ins[ 'CableLine' ] = $CableLine;
        $query = 'INSERT INTO "CableLinePoint"'.genInsert( $ins );
        //error_log( "ins=".$query );
        PQuery( $query );
    }
}

function addCableLinePoint( $coors, $CableType, $length, $name, $comment )
{
    $ins[ 'CableType' ] = $CableType;
    $ins[ 'length' ] = $length;
    $ins[ 'name' ] = $name;
    $ins[ 'comment' ] = $comment;
    $query = 'INSERT INTO "CableLine"'.genInsert( $ins ).' RETURNING id';
    $res = PQuery( $query );
    $CableLine = $res[ 'rows' ][ 0 ][ 'id' ];
    $seq = 0;
    unset( $ins );
    for ( $i = 0; $i < count( $coors ); $i++ )
    {
        $coor = "(".$coors[ $i ]->lon.",".$coors[ $i ]->lat.")";
        $ins[ 'OpenGIS' ] = $coor;
        $ins[ 'sequence' ] = $seq++;
        $ins[ 'CableLine' ] = $CableLine;
        $query = 'INSERT INTO "CableLinePoint"'.genInsert( $ins );
        PQuery( $query );
    }
}

function addSingPoint( $coors, $CableLineId, $networkNode, $apartment,
        $building, $meterSign, $note )
{
    $OpenGIS = "(".$coors[ 0 ]->lon.",".$coors[ 0 ]->lat.")";
    $wr[ 'CableLine' ] = $CableLineId;
    $wr[ 'OpenGIS' ] = $OpenGIS;
    if ( $meterSign == "" )
    {
        $meterSign = "NULL";
    }
    if ( $note == "" )
    {
        $note = "NULL";
    }
    $upd[ 'meterSign' ] = $meterSign;
    $upd[ 'note' ] = $note;
    $upd[ 'Apartment' ] = $apartment;
    $upd[ 'Building' ] = $building;
    $upd[ 'SettlementGeoSpatial' ] = "NULL";
    CableLinePoint_UPDATE( $upd, $wr );
}

function deleteSingPoint( $coors )
{
    $OpenGIS = "(".$coors[ 0 ]->lon.",".$coors[ 0 ]->lat.")";
    $upd[ 'meterSign' ] = "NULL";
    $upd[ 'note' ] = "NULL";
    $wr[ 'OpenGIS' ] = $OpenGIS;
    $query = 'UPDATE "CableLinePoint" SET '.genUpdate( $upd ).genWhere( $wr );
    PQuery( $query );
}

function deleteCableLine( $CableLineId )
{
    $wr[ 'CableLine' ] = $CableLineId;
    $query = 'DELETE FROM "CableLinePoint"'.genWhere( $wr );
    PQuery( $query );
    unset( $wr );
    $wr[ 'id' ] = $CableLineId;
    $query = 'DELETE FROM "CableLine"'.genWhere( $wr );
    PQuery( $query );
}

function addNode( $coors, $name, $NetworkBoxId, $note, $SettlementGeoSpatial,
        $building, $apartment )
{
    $OpenGIS = "(".$coors[ 0 ]->lon.",".$coors[ 0 ]->lat.")";
    $apartment = "NULL";
    $building = "NULL";
    $SettlementGeoSpatial = "NULL";
    NetworkNode_Add( $name, $NetworkBoxId, $note, $OpenGIS,
            $SettlementGeoSpatial, $building, $apartment );
}

function deleteNode( $coors )
{
    $OpenGIS = "(".$coors[ 0 ]->lon.",".$coors[ 0 ]->lat.")";
    $wr[ 'OpenGIS' ] = $OpenGIS;
    $query = 'SELECT id FROM "NetworkNode"'.genWhere( $wr );
    $res = PQuery( $query );
    $NetworkNodeId = $res[ 'rows' ][ 0 ][ 'id' ];
    unset( $wr );
    $wr[ 'id' ] = $NetworkNodeId;
    NetworkNode_DELETE( $wr );
}

function divCableLine( $coors, $CableLineId )
{

    $OpenGIS = "(".$coors[ 0 ]->lon.",".$coors[ 0 ]->lat.")";
    $wr[ 'id' ] = $CableLineId;
    $res = CableLine_SELECT( 0, $wr );
    $CableLine = $res[ 'rows' ][ 0 ];
    unset( $wr );
    $wr[ 'CableLine' ] = $CableLineId;
    $query = 'SELECT * FROM "CableLinePoint"'.genWhere( $wr ).
            'ORDER BY "sequence"';
    $res2 = PQuery( $query );
    $CableLinePoints = $res2[ 'rows' ];
    for ( $i = 0; $i < count( $CableLinePoints ); $i++ )
    {
        $point = $CableLinePoints[ $i ];
        if ( $point[ 'OpenGIS' ] == $OpenGIS )
        {
            $seq = $point[ 'sequence' ];
            $query = 'DELETE FROM "CableLinePoint" WHERE "sequence" > '.$seq.
                    ' AND "CableLine" = '.$CableLineId;
            PQuery( $query );
            $name = "nodeName";
            $NetworkBoxId = 4597;
            $note = "lolo";
            $res3 = NetworkNode_Add( $name, $NetworkBoxId, $note, $OpenGIS,
                    "NULL", "NULL", "NULL" );
            $NetworkNodeId = $res3[ 'rows' ][ 0 ][ 'id' ];
            $wr[ 'sequence' ] = $seq;
            $upd[ 'OpenGIS' ] = "NULL";
            $upd[ 'NetworkNode' ] = $NetworkNodeId;
            CableLinePoint_UPDATE( $upd, $wr );
            break;
        }
    }
    $ins[ 'CableType' ] = $CableLine [ 'CableType' ];
    $ins[ 'length' ] = $CableLine[ 'length' ];
    $ins[ 'name' ] = $CableLine[ 'name' ]."_div";
    $ins[ 'comment' ] = $CableLine[ 'comment' ];
    $query = 'INSERT INTO "CableLine"'.genInsert( $ins ).' RETURNING id';
    $res4 = PQuery( $query );
    $NCableLineId = $res4[ 'rows' ][ 0 ][ 'id' ];
    $seq = 0;
    unset( $ins );
    for ( $j = $i; $j < count( $CableLinePoints ); $j++ )
    {
        $point = $CableLinePoints[ $j ];
        foreach ( $point as $key => $value )
        {
            if ( $key != "id" && $key != "sequence" )
            {
                if ( $value != "" )
                {
                    $ins[ $key ] = $value;
                }
                else
                {
                    $ins[ $key ] = "NULL";
                }
            }
        }
        $ins[ 'CableLine' ] = $NCableLineId;
        $ins[ 'sequence' ] = $seq++;
        if ( $j == $i )
        {
            $ins[ 'NetworkNode' ] = $NetworkNodeId;
            $ins[ 'OpenGIS' ] = "NULL";
        }
        $query = 'INSERT INTO "CableLinePoint"'.genInsert( $ins );
        PQuery( $query );
    }
}
?>