<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function CableLine_SELECT( $sort, $wr, $tmpT = FALSE )
{
    $query = 'SELECT * FROM "'.tmpTable( 'CableLine', $tmpT ).'"';
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

function CableLinePoint_UPDATE( $upd, $wr, $tmpT = FALSE )
{
    $query = 'UPDATE "'.tmpTable( 'CableLinePoint', $tmpT ).'" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $result = PQuery( $query );
    loggingIs( 1, tmpTable( 'CableLinePoint', $tmpT ), $upd, $wr[ 'id' ] );
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

function getCableLineList( $sort, $wr, $linesPerPage = -1, $skip = -1,
        $tmpT = FALSE )
{
    $query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", "cl"."length", "cl"."comment",
                "cl"."name", "ct"."marking", "ct"."manufacturer",
                "ct"."fiberPerTube"*"ct"."tubeQuantity" AS "fibers", "ct"."fiberPerTube",
                "ct"."tubeQuantity", "NN"."OpenGIS" AS "NNOpenGIS",
                COUNT(DISTINCT "OFJ"."OpticalFiberSplice") AS "FiberSpliceCount"                
                FROM "'.tmpTable( 'CableLine',
                    $tmpT ).'" AS "cl"
		LEFT JOIN "'.tmpTable( 'CableLinePoint',
                    $tmpT ).'" AS "clp" ON "clp"."CableLine" = "cl"."id" 
		LEFT JOIN "'.tmpTable( 'CableType',
                    $tmpT ).'" AS "ct" ON "ct".id="cl"."CableType"
		LEFT JOIN "'.tmpTable( 'OpticalFiber',
                    $tmpT ).'" AS "OF" ON "OF"."CableLine" = "cl".id
		LEFT JOIN "'.tmpTable( 'OpticalFiberJoin',
                    $tmpT ).'" AS "OFJ" ON "OFJ"."OpticalFiber" = "OF".id
                LEFT JOIN "'.tmpTable( 'NetworkNode',
                    $tmpT ).'" AS "NN" ON "NN"."id" = "clp"."NetworkNode"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $query .= ' GROUP BY "cl"."id", "ct"."marking", "ct"."manufacturer", "ct"."fiberPerTube",
                "ct"."tubeQuantity", "NN"."id"';
    $query .= ' ORDER BY "name"';
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "name"';
    }
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "'.tmpTable( 'CableLine',
                        $tmpT ).'" ';
        if ( $wr != '' )
        {
            $query2 .= genWhere( $wr );
        }
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    error_log( $query );
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

function getSingularCableLinePoints( $OpenGIS = -1, $tmpT = FALSE )
{
    $query = 'SELECT "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign",
              "clp"."NetworkNode", "clp"."note", "cl"."name" AS "CableLineName"
              FROM "'.tmpTable( 'CableLinePoint',
                    $tmpT ).'" AS "clp"
              LEFT JOIN "'.tmpTable( 'CableLine',
                    $tmpT ).'" AS "cl" ON "cl".id = "clp"."CableLine"
              WHERE "clp"."meterSign" IS NOT NULL OR "clp"."note" IS NOT NULL';
    if ( $OpenGIS != -1 )
    {
        $query .= ' AND "clp"."OpenGIS" IS NOT NULL';
    }
    $result = PQuery( $query );
    return $result;
}

function getCableLinePoints( $cableLine, $onlyFree = FALSE, $tmpT = FALSE )
{
    $wr[ 'CableLine' ] = $cableLine;
    $query = 'SELECT "clp".id, "clp"."OpenGIS", "clp"."meterSign", "clp"."note", "clp"."sequence",
              "NN"."OpenGIS" AS "NNOpenGIS"
              FROM "'.tmpTable( 'CableLinePoint',
                    $tmpT ).'" AS "clp"
              LEFT JOIN "'.tmpTable( 'NetworkNode',
                    $tmpT ).'" AS "NN" ON "NN".id = "clp"."NetworkNode"'.genWhere( $wr );
    if ( $onlyFree )
    {
        $query .= ' AND "clp"."OpenGIS" IS NOT NULL';
    }
    $query .= ' ORDER BY "sequence"';
    $result = PQuery( $query );
    return $result;
}

function retCable( $matches, $row, $superSeqEnd )
{
    $cable[ 'lat' ] = $matches[ 'lat' ][ 0 ];
    $cable[ 'lon' ] = $matches[ 'lon' ][ 0 ];
    $cable[ 'id' ] = $row[ 'id' ];
    $cable[ 'sequence' ] = $row[ 'sequence' ];
    $cable[ 'superSequenceEnd' ] = $superSeqEnd;
    return $cable;
}

function getCableLinesFrag( $cableLines )
{
    $resFrags = array( );
    for ( $i = 0; $i < count( $cableLines ); $i++ )
    {
        $cableLine = $cableLines[ $i ][ 'id' ];
        $cableLinePoints = getCableLinePoints( $cableLine, FALSE, TRUE );
        $rows = $cableLinePoints[ 'rows' ];
        $b = 0;
        $n = 0;
        for ( $j = 0; $j < count( $rows ); $j++ )
        {
            $OpenGIS = $rows[ $j ][ 'OpenGIS' ];
            $NNOpenGis = $rows[ $j ][ 'NNOpenGIS' ];
            if ( !preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/', $OpenGIS,
                            $matches ) )
            {
                preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/', $NNOpenGis,
                        $matches );
            }
            if ( ( $rows[ $j ][ 'note' ] != '' ) || ( $rows[ $j ][ 'meterSign' ] != '' ) )
            {
                $resFrags[ $cableLine ][ $b ][ $n ] = retCable( $matches,
                        $rows[ $j ], $rows[ count( $rows ) - 1 ][ 'sequence' ] );
                //$n++;
                $b++;
                $n = 0;
                $OpenGIS = $rows[ $j ][ 'OpenGIS' ];
                $NNOpenGis = $rows[ $j ][ 'NNOpenGIS' ];
                if ( !preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/',
                                $OpenGIS, $matches ) )
                {
                    preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/',
                            $NNOpenGis, $matches );
                }
                $resFrags[ $cableLine ][ $b ][ $n ] = retCable( $matches,
                        $rows[ $j ], $rows[ count( $rows ) - 1 ][ 'sequence' ] );
                $n++;
            }
            else
            {
                $resFrags[ $cableLine ][ $b ][ $n ] = retCable( $matches,
                        $rows[ $j ], $rows[ count( $rows ) - 1 ][ 'sequence' ] );
                $n++;
            }
        }
    }
    return $resFrags;
}

?>