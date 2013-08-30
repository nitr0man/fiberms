<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function FSO_SELECT( $ob, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT * FROM "FiberSpliceOrganizer"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $ob != '' )
    {
        $query .= ' ORDER BY '.$ob;
    }
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizer"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

function FSO_INSERT( $ins )
{
    $query = 'INSERT INTO "FiberSpliceOrganizer"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'FiberSpliceOrganizer', $ins, '' );
    return $result;
}

function FSO_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "FiberSpliceOrganizer" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'FiberSpliceOrganizer', $upd, $wr[ 'id' ] );
    return $result;
}

function FSO_DELETE( $wr )
{
    $query = 'DELETE FROM "FiberSpliceOrganizer"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'FiberSpliceOrganizer', '', $wr[ 'id' ] );
    return $result;
}

function FSOT_SELECT( $sort, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT * FROM "FiberSpliceOrganizerType"';
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
        $query2 = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizerType"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

function FSOT_INSERT( $ins )
{
    $query = 'INSERT INTO "FiberSpliceOrganizerType"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'FiberSpliceOrganizerType', $ins, '' );
    return $result;
}

function FSOT_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "FiberSpliceOrganizerType" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'FiberSpliceOrganizerType', $upd, $wr[ 'id' ] );
    return $result;
}

function FSOT_DELETE( $wr )
{
    $query = 'DELETE FROM "FiberSpliceOrganizerType"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'FiberSpliceOrganizerType', '', $wr[ 'id' ] );
    return $result;
}

function getCableLineDirection( $cableLine, $cableLinePoint, $networkNodeId,
        $tmpT = FALSE )
{
    if ( $cableLine == -1 )
    {
        $query = 'SELECT * FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'" WHERE id='.$cableLinePoint;
        $res = PQuery( $query );
        $cableLine = $res[ 'rows' ][ 0 ][ 'CableLine' ];
    }
    $query = 'SELECT * FROM "CableLinePoint" AS "clp" ';
    $query .= 'LEFT JOIN "NetworkNode" AS "NN" ON "NN".id="clp"."NetworkNode" ';
    $query .= 'WHERE "clp"."CableLine"='.$cableLine.'AND "clp"."NetworkNode" IS NOT NULL';
    if ( $networkNodeId != -1 )
    {
        $query .= ' AND "clp"."NetworkNode"!='.$networkNodeId;
    }
    $res = PQuery( $query );
    if ( ($res[ 'count' ] >= 1) and ($res[ 'count' ] <= 2) )
    {
        /* $result['name'] = $res['rows'][0]['name'];
          $result['NetworkNode'] = $res['rows'][0]['NetworkNode']; */
        $result = $res[ 'rows' ];
    }
    else
    {
        $result[ 0 ][ 'name' ] = '-';
    }
    return $result;
}

function getSplices( $spliceId = -1, $fiberId = -1 )
{
    if ( $spliceId != -1 && $fiberId != -1 )
    {
        $query = 'SELECT "CableLine" FROM "OpticalFiber"
                WHERE id = '.$fiberId;
        $res_cl = PQuery( $query );
        $cableLineId = $res_cl[ 'rows' ][ 0 ][ 'CableLine' ];
        $query = 'SELECT "OpticalFiberSplice", "OpticalFiber"
                FROM "OpticalFiberJoin"
                WHERE "OpticalFiber" IN (SELECT id FROM "OpticalFiber" WHERE "CableLine" = '.$cableLineId.')
                    AND "OpticalFiberSplice" != '.$spliceId;
        //error_log( $query );
        $res = PQuery( $query );
    }
    elseif ( $spliceId != -1 )
    {
        $query = 'SELECT "OpticalFiberSplice", "OpticalFiber"
                FROM "OpticalFiberJoin"
                WHERE "OpticalFiberSplice" != '.$spliceId;
        //error_log( $query );
        $res = PQuery( $query );
    }
    else
    {
        $query = 'SELECT id, "OpticalFiber", "OpticalFiberSplice"
                    FROM "OpticalFiberJoin"
                    WHERE "OpticalFiber" = '.$fiberId;
        $res = PQuery( $query );
    }
    return $res[ 'rows' ];
}

function getFibs( $spliceIds = -1, $fiberId = -1 )
{
    $result = array( );
    if ( $spliceIds != -1 && $fiberId != -1 )
    {
        $query = 'SELECT "CableLine" FROM "OpticalFiber"
                WHERE id = '.$fiberId;
        $res_cl = PQuery( $query );
        $cableLineId = $res_cl[ 'rows' ][ 0 ][ 'CableLine' ];
        for ( $i = 0; $i < count( $spliceIds ); $i++ )
        {
            $sId = $spliceIds[ $i ][ 'OpticalFiberSplice' ];
            $query = 'SELECT "of"."CableLine", "of"."fiber", "ofj"."OpticalFiberSplice", "ofj"."OpticalFiber", "of"."note",
                        "ofs"."NetworkNode", "ofs"."FiberSpliceOrganizer", 
                        "cl"."name" AS "cl_name", "nn"."name" AS "nn_name"
                    FROM "OpticalFiber" AS "of"
                    LEFT JOIN "OpticalFiberJoin" AS "ofj" ON "ofj"."OpticalFiber" = "of".id
                    LEFT JOIN "OpticalFiberSplice" AS "ofs" ON "ofs".id = '.$sId.'
                    LEFT JOIN "CableLine" AS "cl" ON "cl".id = "of"."CableLine"
                    LEFT JOIN "NetworkNode" AS "nn" ON "nn".id = "ofs"."NetworkNode"
                    WHERE "ofj"."OpticalFiberSplice" = '.$sId.' AND "of"."CableLine" != '.$cableLineId;
            //error_log( $query );
            $res = PQuery( $query );
            $result = array_merge( $result, $res[ 'rows' ] );
        }
    }
    elseif ( $fiberId == -1 && $spliceIds != -1 )
    {
        for ( $i = 0; $i < count( $spliceIds ); $i++ )
        {
            $sId = $spliceIds[ $i ][ 'OpticalFiberSplice' ];
            $query = 'SELECT "CableLine", "fiber", "OpticalFiberSplice", "OpticalFiber"
                    FROM "OpticalFiber" AS "of"
                    LEFT JOIN "OpticalFiberJoin" AS "ofj" ON "ofj"."OpticalFiber" = "of".id
                    WHERE "ofj"."OpticalFiberSplice" = '.$sId;
            //error_log( $query );
            $res = PQuery( $query );
            $result = array_merge( $result, $res[ 'rows' ] );
        }
    }
    elseif ( $fiberId != -1 && $spliceIds == -1 )
    {
        $query = 'SELECT "CableLine" FROM "OpticalFiber"
                WHERE id = '.$fiberId;
        $res_cl = PQuery( $query );
        $cableLineId = $res_cl[ 'rows' ][ 0 ][ 'CableLine' ];
        $query = 'SELECT "CableLine", "fiber", "OpticalFiberSplice", "OpticalFiber"
                    FROM "OpticalFiber" AS "of"
                    LEFT JOIN "OpticalFiberJoin" AS "ofj" ON "ofj"."OpticalFiber" = "of".id
                    WHERE "of"."CableLine" != '.$cableLineId;
        //error_log( $query );
        $res = PQuery( $query );
        $result = array_merge( $result, $res[ 'rows' ] );
    }
    return $result;
}

function getAllInfoBySpliceId( $spliceId )
{
    $query = 'SELECT "of"."CableLine", "of"."fiber", "of"."note", "ofs"."NetworkNode",
            "ofs"."FiberSpliceOrganizer", "cl"."name" AS "cl_name", "nn"."name" AS "nn_name"
            FROM "OpticalFiberJoin" AS "ofj"
            LEFT JOIN "OpticalFiber" AS "of" ON "of".id = "ofj"."OpticalFiber"
            LEFT JOIN "OpticalFiberSplice" AS "ofs" ON "ofs".id = '.$spliceId.'
            LEFT JOIN "CableLine" AS "cl" ON "cl".id = "of"."CableLine"
            LEFT JOIN "NetworkNode" AS "nn" ON "nn".id = "ofs"."NetworkNode"
            WHERE "ofj"."OpticalFiberSplice" = '.$spliceId;
    $res = PQuery( $query );
    return $res[ 'rows' ];
}

function getLineByFiberId( $fiberId )
{
    $query = 'SELECT "of"."CableLine", "of".fiber, "of".note, "cl"."name" AS "cl_name"
                FROM "OpticalFiber" AS "of"
                LEFT JOIN "CableLine" AS "cl" ON "cl".id = "of"."CableLine"
                WHERE "of".id = '.$fiberId;
    $res = PQuery( $query );
    return $res[ 'rows' ][ 0 ];
}

function getCableLineInfo( $nodeId, $zeroFibers = -1, $tmpT = FALSE )
{
    $query = 'SELECT "ct"."tubeQuantity"*"ct"."fiberPerTube" AS "fiber",
                "clp".id AS "clpid", "cl"."name", "ct"."marking",
                "clp"."NetworkNode", "ct".id AS "ctid", "cl".id AS "clid",
                "ct"."manufacturer", "ct"."fiberPerTube"
                FROM "'.tmpTable( 'NetworkNode',
                    $tmpT ).'" AS "NN"
		LEFT JOIN "'.tmpTable( 'CableLinePoint',
                    $tmpT ).'" AS "clp" ON "clp"."NetworkNode"="NN"."id"
		LEFT JOIN "'.tmpTable( 'CableLine',
                    $tmpT ).'" AS "cl" ON "cl".id="clp"."CableLine"
		LEFT JOIN "'.tmpTable( 'CableType',
                    $tmpT ).'" AS "ct" ON "ct".id="cl"."CableType" WHERE "NN".id='.$nodeId;
    if ( $zeroFibers == -1 )
    {
        $query .= ' AND "ct"."tubeQuantity"*"ct"."fiberPerTube" != 0';
    }
    $result = PQuery( $query );
    return $result;
}

function getFiberSpliceOrganizerInfo( $linesPerPage = -1, $skip = -1,
        $networkNode = -1, $free = 1 )
{
    $query = 'SELECT DISTINCT "fso".id, "fso"."FiberSpliceOrganizationType" AS "FiberSpliceOrganizationTypeId", "fsot"."marking" AS "FiberSpliceOrganizationTypeMarking", "fsot"."manufacturer" AS "FiberSpliceOrganizationTypeManufacturer", "nn".id AS "NetworkNodeId", "nn"."name" AS "NetworkNodeName", COUNT(DISTINCT "fs".id) AS "FiberSpliceCount" FROM "FiberSpliceOrganizer" AS "fso" LEFT JOIN "FiberSplice" AS "fs" ON "fs"."FiberSpliceOrganizer"="fso".id LEFT JOIN "CableLinePoint" AS "clp" ON "clp".id="fs"."CableLinePointA" OR "clp".id="fs"."CableLinePointB" LEFT JOIN "NetworkNode" AS "nn" ON "nn".id="clp"."NetworkNode" LEFT JOIN "FiberSpliceOrganizerType" AS "fsot" ON "fsot".id="fso"."FiberSpliceOrganizationType" WHERE "fs"."FiberSpliceOrganizer"="fso".id';
    if ( $networkNode != -1 )
    {
        $query .= ' AND "nn".id='.$networkNode;
    }
    if ( $free == 1 )
    {
        $query .= ' OR "nn".id IS NULL';
    }
    $query .= ' GROUP BY "fso".id, "fsot"."marking", "fsot"."manufacturer", "nn".id';
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizer"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

?>