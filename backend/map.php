<?php

function updCableLinePoints( $coors, $CableLine, $seqStart, $seqEnd )
{
    $query = 'SELECT * FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' ORDER BY "sequence"';
    $res = PQuery( $query );
    if ( $res[ 'rows' ][ $seqEnd ][ 'meterSign' ] != "" )
    {
        $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" < '.$seqEnd;
        PQuery( $query );
        if ( count( $coors ) != $res[ 'count' ] )
        {
            $seqDiff = count( $coors ) - ( $seqEnd - $seqStart );
            $query = 'UPDATE "CableLinePoint" SET "sequence" = ("sequence" + '.$seqDiff.')*-1 WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqEnd;
            PQuery( $query );
            //$query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqEnd;
            $query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine.' AND "sequence" < 0';
            PQuery( $query );
            $seq = $seqStart;
        }
        else
        {
            $seq = 0;
        }
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
    else if ( $res[ 'rows' ][ $seqStart ][ 'meterSign' ] != "" )
    {
        /* $seqDiff = count( $coors ) - ( $seqEnd - $seqStart );
          $query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" + '.$seqDiff.' WHERE "CableLine" = '.$CableLine;
          PQuery( $query );
          $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqStart.' AND "sequence" <= '.$seqEnd;
          PQuery( $query );
          $seq = $seqStart; */
        $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqStart.' AND "sequence" <= '.$seqEnd;
        PQuery( $query );
        if ( count( $coors ) != $res[ 'count' ] )
        {
            $seqDiff = count( $coors ) - ( $seqEnd - $seqStart );
            $query = 'UPDATE "CableLinePoint" SET "sequence" = ("sequence" + '.$seqDiff.')*-1 WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqEnd;
            PQuery( $query );
            //$query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqEnd;
            $query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine.' AND "sequence" < 0';
            PQuery( $query );
            $seq = $seqStart + 1;
        }
        else
        {
            $seq = 0;
        }
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
    else
    {
        $query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" <= '.$seqEnd;
        PQuery( $query );
        $seq = 0;
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
}

function addCableLinePoint( $coors, $CableType, $length, $name, $comment )
{
    require_once 'func/CableType.php';
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
        error_log( $query );
        PQuery( $query );
    }
}
?>