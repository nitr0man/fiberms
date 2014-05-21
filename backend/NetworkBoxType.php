<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function NetworkBox_SELECT( $sort, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT * FROM "NetworkBox"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "inventoryNumber"';
    }
    else
    {
        $query .= ' ORDER BY "inventoryNumber"';
    }
    $allPages = 0;
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "NetworkBox"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

function NetworkBox_INSERT( $ins )
{
    $query = 'INSERT INTO "NetworkBox"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'NetworkBox', $ins, '' );
    return $result;
}

function NetworkBox_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "NetworkBox" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'NetworkBox', $upd, $wr[ 'id' ] );
    return $result;
}

function NetworkBox_DELETE( $wr )
{
    $query = 'DELETE FROM "NetworkBox"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'NetworkBox', '', $wr[ 'id' ] );
    return $result;
}

function NetworkBoxType_SELECT( $ob, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT * FROM "NetworkBoxType"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $ob != '' )
    {
        $query .= ' ORDER BY '.$ob;
    }
    $allPages = 0;
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "NetworkBoxType"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

function NetworkBoxType_INSERT( $ins )
{
    $query = 'INSERT INTO "NetworkBoxType"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'NetworkBoxType', $ins, '' );
    return $result;
}

function NetworkBoxType_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "NetworkBoxType" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'NetworkBoxType', $upd, $wr[ 'id' ] );
    return $result;
}

function NetworkBoxType_DELETE( $wr )
{
    $query = 'DELETE FROM "NetworkBoxType"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'NetworkBoxType', '', $wr[ 'id' ] );
    return $result;
}

function getNetworkBoxList( $sort, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT "NB".id, "NB"."NetworkBoxType", "NB"."inventoryNumber", "NBT"."marking", "NN"."name" AS "NNname", "NN".id AS "NNid" FROM "NetworkBox" AS "NB"';
    $query .= ' LEFT JOIN "NetworkBoxType" AS "NBT" ON "NBT".id="NB"."NetworkBoxType"';
    $query .= ' LEFT JOIN "NetworkNode" AS "NN" ON "NN"."NetworkBox"="NB".id';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $query .= ' ORDER BY "inventoryNumber"';
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "NB"."inventoryNumber" ';
    }
    $allPages = 0;
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "NetworkBox"';
        if ( $wr != '' )
        {
            $query2 .= genWhere( $wr );
        }
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

?>