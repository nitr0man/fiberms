<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function CableLine_SELECT( $sort, $wr )
{
    $query = 'SELECT * FROM "CableLine"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "name"';
    }
    else
    {
        $query .= ' ORDER BY "name"';
    }
    $result = PQuery( $query );
    return $result;
}

function CableLine_INSERT( $ins )
{
    $query = 'INSERT INTO "CableLine"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'CableLine', $ins, '' );
    return $result;
}

function CableLine_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "CableLine" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'CableLine', $upd, $wr[ 'id' ] );
    return $result;
}

function CableLine_DELETE( $wr )
{
    $query = 'DELETE FROM "CableLine"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'CableLine', '', $wr[ 'id' ] );
    return $result;
}

function CableType_SELECT( $sort, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT * FROM "CableType"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "marking"';
    }
    else
    {
        $query .= ' ORDER BY "marking"';
    }
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "CableType"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    unset( $field, $value );
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

function CableType_INSERT( $ins )
{
    $query = 'INSERT INTO "CableType"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'CableType', $ins, '' );
    return $result;
}

function CableType_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "CableType" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'CableLine', $upd, $wr[ 'id' ] );
    return $result;
}

function CableType_DELETE( $wr )
{
    $query = 'DELETE FROM "CableType"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'CableType', '', $wr[ 'id' ] );
    return $result;
}

function CableLinePoint_SELECT( $wr )
{
    $query = 'SELECT * FROM "CableLinePoint"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $result = PQuery( $query );
    return $result;
}

function CableLinePoint_INSERT( $ins )
{
    $query = 'INSERT INTO "CableLinePoint"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'CableLinePoint', $ins, '' );
    return $result;
}

function CableLinePoint_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "CableLinePoint" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $result = PQuery( $query );
    loggingIs( 1, 'CableLinePoint', $upd, $wr[ 'id' ] );
    return $result;
}

function CableLinePoint_DELETE( $wr )
{
    $query = 'DELETE FROM "CableLinePoint"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'CableTypePoint', '', $wr[ 'id' ] );
    return $result;
}

function getCableLinePoint_NetworkNodeName( $cableLineId )
{
    $query = 'SELECT "clp".id, "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign", "clp"."NetworkNode", "clp"."note", 
       "clp"."Apartment", "clp"."Building", "clp"."SettlementGeoSpatial", "NN"."name"
	FROM "CableLinePoint" AS "clp"  LEFT JOIN "NetworkNode" AS "NN" ON "NN".id = "clp"."NetworkNode" WHERE "CableLine"='.$cableLineId.' ORDER BY "clp"."meterSign"';
    $result = PQuery( $query );
    return $result;
}

function getCableLineList( $sort, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", "cl"."length", "cl"."comment", "cl"."name", "ct"."marking", "ct"."manufacturer", 	"ct"."fiberPerTube"*"ct"."tubeQuantity" AS "fibers", "ct"."fiberPerTube", "ct"."tubeQuantity", COUNT(DISTINCT "OFJ"."OpticalFiberSplice") AS 	"FiberSpliceCount" FROM "CableLine" AS "cl"
		LEFT JOIN "CableLinePoint" AS "clp" ON "clp"."CableLine" = "cl"."id" 
		LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"
		LEFT JOIN "OpticalFiber" AS "OF" ON "OF"."CableLine" = "cl".id
		LEFT JOIN "OpticalFiberJoin" AS "OFJ" ON "OFJ"."OpticalFiber" = "OF".id';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $query .= ' GROUP BY "cl"."id", "ct"."marking", "ct"."manufacturer", "ct"."fiberPerTube", "ct"."tubeQuantity"';
    $query .= ' ORDER BY "name"';
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "name"';
    }
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "CableLine" ';
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

function getCopperCableLines()
{
    $query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", "cl".length, "cl".comment, "cl".name, "ct"."fiberPerTube"
			  FROM "CableLine" AS "cl"
			  LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"
			  WHERE "ct"."fiberPerTube"=0 AND "OpenGIS" IS NOT NULL';
    $result = PQuery( $query );
    return $result;
}

function getNormalCableLines()
{
    $query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", "cl".length, "cl".comment, "cl".name, "ct"."fiberPerTube"
			  FROM "CableLine" AS "cl"
			  LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"
			  WHERE "ct"."fiberPerTube"!=0 AND "OpenGIS" IS NOT NULL';
    $result = PQuery( $query );
    return $result;
}

function getSingularCableLinePoints( $OpenGIS = -1 )
{
    $query = 'SELECT "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign", "clp"."NetworkNode", "clp"."note", "cl"."name" AS "CableLineName" FROM "CableLinePoint" AS "clp"
			  LEFT JOIN "CableLine" AS "cl" ON "cl".id = "clp"."CableLine"
			  WHERE "clp"."meterSign" IS NOT NULL OR "clp"."note" IS NOT NULL';
    if ( $OpenGIS != -1 )
    {
        $query .= ' AND "clp"."OpenGIS" IS NOT NULL';
    }
    $result = PQuery( $query );
    return $result;
}

function getCableLinePoints( $cableLine )
{
    $wr[ 'CableLine' ] = $cableLine;
    $query = 'SELECT id, "OpenGIS", "meterSign", "note", "sequence" FROM "CableLinePoint"'.genWhere( $wr ).' ORDER BY "sequence"';
    $result = PQuery( $query );
    return $result;
}

function getCableLinesFrag( $cableLines )
{
    $resFrags = array( );
    for ( $i = 0; $i < count( $cableLines ); $i++ )
    {
        $cableLine = $cableLines[ $i ][ 'id' ];
        $cableLinePoints = getCableLinePoints( $cableLine );
        $rows = $cableLinePoints[ 'rows' ];
        $b = 0;
        $n = 0;
        for ( $j = 0; $j < count( $rows ); $j++ )
        {
            if ( ( $rows[ $j ][ 'note' ] != '' ) || ( $rows[ $j ][ 'meterSign' ] != '' ) )
            {
                $OpenGIS = $rows[ $j ][ 'OpenGIS' ];
                if ( preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/',
                                $OpenGIS, $matches ) )
                {
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'lat' ] = $matches[ 'lat' ][ 0 ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'lon' ] = $matches[ 'lon' ][ 0 ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'id' ] = $rows[ $j ][ 'id' ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'sequence' ] = $rows[ $j ][ 'sequence' ];
                    $n++;
                }
                $b++;
                $n = 0;
                $OpenGIS = $rows[ $j ][ 'OpenGIS' ];
                if ( preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/',
                                $OpenGIS, $matches ) )
                {
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'lat' ] = $matches[ 'lat' ][ 0 ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'lon' ] = $matches[ 'lon' ][ 0 ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'id' ] = $rows[ $j ][ 'id' ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'sequence' ] = $rows[ $j ][ 'sequence' ];
                    $n++;
                }
                continue;
            }
            else
            {
                $OpenGIS = $rows[ $j ][ 'OpenGIS' ];
                if ( preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/',
                                $OpenGIS, $matches ) )
                {
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'lat' ] = $matches[ 'lat' ][ 0 ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'lon' ] = $matches[ 'lon' ][ 0 ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'id' ] = $rows[ $j ][ 'id' ];
                    $resFrags[ $cableLine ][ $b ][ $n ][ 'sequence' ] = $rows[ $j ][ 'sequence' ];
                    $n++;
                }
            }
        }
    }
    return $resFrags;
}

?>