<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function FSO_SELECT( $ob, $wr, $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT * FROM "FiberSpliceOrganizer"';
    $where = '';
    if ( $wr != '' )
    {
        $where = genWhere( $wr );
    }
    $query .= $where;
    if ( $ob != '' )
    {
        $query .= ' ORDER BY '.$ob;
    }
    if ( ($linesPerPage > 0) and ($skip >= 0) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
    }
    $result = PQuery( $query );
    $query = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizer"' . $where;
    $res = PQuery( $query );
    $result[ 'allPages' ] = $res[ 'rows' ][ 0 ][ 'count' ];
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
    $where = '';
    if ( $wr != '' )
    {
        $where = genWhere( $wr );
    }
    $query .= $where;
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "marking"';
    }
    else
    {
        $query .= ' ORDER BY "marking"';
    }
    if ( ($linesPerPage > 0) and ($skip >= 0) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
    }
    $result = PQuery( $query );
    $query2 = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizerType"' . $where;
    $res = PQuery( $query2 );
    $result[ 'allPages' ] = $res[ 'rows' ][ 0 ][ 'count' ];
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

function getSplices( $spliceId = -1, $fiberId = -1, $baseFiber = false )
{
    if ( $spliceId != -1 && $fiberId != -1 )
    {
        $op = ($baseFiber) ? ' = ' : ' != ';
        $query = 'SELECT "OpticalFiberSplice", "OpticalFiber"
                FROM "OpticalFiberJoin"
                WHERE "OpticalFiber" = '.pg_escape_string( $fiberId ).'
                    AND "OpticalFiberSplice"'.$op.pg_escape_string( $spliceId );
        $res = PQuery( $query );
    }
    elseif ( $spliceId != -1 )
    {
        $query = 'SELECT "OpticalFiberSplice", "OpticalFiber"
                FROM "OpticalFiberJoin"
                WHERE "OpticalFiberSplice" = '.pg_escape_string( $spliceId );
        $res = PQuery( $query );
    }
    else
    {
        $query = 'SELECT id, "OpticalFiber", "OpticalFiberSplice"
                    FROM "OpticalFiberJoin"
                    WHERE "OpticalFiber" = '.pg_escape_string( $fiberId );
        $res = PQuery( $query );
    }
    return $res[ 'rows' ];
}

function getSplice( $CableLineA, $fiberA, $CableLineB, $fiberB, $NetworkNode)
{
    $query = 'SELECT ofs.id FROM "OpticalFiberSplice" ofs
		    LEFT JOIN "OpticalFiberJoin" ofj1 ON ofj1."OpticalFiberSplice" = ofs.id
		    LEFT JOIN "OpticalFiber" of1 ON of1.id = ofj1."OpticalFiber"
		    LEFT JOIN "OpticalFiberJoin" ofj2 ON ofj2."OpticalFiberSplice" = ofs.id
		    LEFT JOIN "OpticalFiber" of2 ON of2.id = ofj2."OpticalFiber"
		    WHERE of1."CableLine" = ' . intval($CableLineA) .
		    ' AND of1.fiber = ' . intval($fiberA) .
		    ' AND of2."CableLine" = ' . intval($CableLineB) .
		    ' AND of2.fiber = ' . intval($fiberB) .
		    ' AND ofs."NetworkNode" = ' . intval($NetworkNode);
    return PQuery($query);
}

function getFibs( $spliceIds = -1, $fiberId = -1 )
{
    $result = array( );
    if ( $spliceIds != -1 && $fiberId != -1 )
    {
        $query = 'SELECT "CableLine" FROM "OpticalFiber"
                WHERE id = '.pg_escape_string( $fiberId );
        $res_cl = PQuery( $query );
        $cableLineId = $res_cl[ 'rows' ][ 0 ][ 'CableLine' ];
        for ( $i = 0; $i < count( $spliceIds ); $i++ )
        {
            $sId = $spliceIds[ $i ][ 'OpticalFiberSplice' ];
            $query = 'SELECT "of"."CableLine", "of"."fiber", "of"."note",
                        "ofj"."OpticalFiberSplice", "ofj"."OpticalFiber",
                        "ofs"."NetworkNode", "ofs"."FiberSpliceOrganizer", ofs.note as ofs_note,
                        "cl"."name" AS "cl_name", cl.comment as cl_note,
                        round(cl.length / 100.0, 2) AS length,
                        "nn"."name" AS "nn_name", nn.place
                    FROM "OpticalFiber" AS "of"
                    LEFT JOIN "OpticalFiberJoin" AS "ofj" ON "ofj"."OpticalFiber" = "of".id
                    LEFT JOIN "OpticalFiberSplice" AS "ofs" ON "ofs".id = '.$sId.'
                    LEFT JOIN "CableLine" AS "cl" ON "cl".id = "of"."CableLine"
                    LEFT JOIN "NetworkNode" AS "nn" ON "nn".id = "ofs"."NetworkNode"
                    WHERE "ofj"."OpticalFiberSplice" = '.$sId.' AND "of"."CableLine" != '.$cableLineId;
            $res = PQuery( $query );
            $res = fillCableLengthBySign($res);
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
            $res = PQuery( $query );
            $result = array_merge( $result, $res[ 'rows' ] );
        }
    }
    elseif ( $fiberId != -1 && $spliceIds == -1 )
    {
        $query = 'SELECT "CableLine" FROM "OpticalFiber"
                WHERE id = '.pg_escape_string( $fiberId );
        $res_cl = PQuery( $query );
        $cableLineId = $res_cl[ 'rows' ][ 0 ][ 'CableLine' ];
        $query = 'SELECT "CableLine", "fiber", "OpticalFiberSplice", "OpticalFiber"
                    FROM "OpticalFiber" AS "of"
                    LEFT JOIN "OpticalFiberJoin" AS "ofj" ON "ofj"."OpticalFiber" = "of".id
                    WHERE "of"."CableLine" != '.$cableLineId;
        $res = PQuery( $query );
        $result = array_merge( $result, $res[ 'rows' ] );
    }
    return $result;
}

function fillCableLengthBySign($res)
{
    for ($j = 0; $j < $res['count']; $j++) {
        $res2 = getCableLinePoints($res['rows'][$j]['CableLine']);
        if ($res2['count'] > 1) {
            $start = $res2['rows'][0]['meterSign'];
            $end = end($res2['rows'])['meterSign'];
            if (is_numeric($start) && is_numeric($end)) {
                $res['rows'][$j]['length2'] = abs((int)$end - (int)$start);
                if (!$res['rows'][$j]['length'])
                    $res['rows'][$j]['length'] = $res['rows'][$j]['length2'];
            } else {
                $res['rows'][$j]['length2'] = NULL;
            }
        } else {
            $res['rows'][$j]['length2'] = NULL;
        }
    }
    return $res;
}

function getAllInfoBySpliceId( $spliceId )
{
    $query = 'SELECT "of"."CableLine", "of"."fiber", "of"."note",
            "ofs"."NetworkNode", "ofs"."FiberSpliceOrganizer", ofs.note as ofs_note,
            "cl"."name" AS "cl_name", cl.comment AS cl_note, round(cl.length / 100.0, 2) AS length,
            "nn"."name" AS "nn_name", nn.place,
            "ofj"."OpticalFiber", "ofj".id AS "ofj_id"
            FROM "OpticalFiberJoin" AS "ofj"
            LEFT JOIN "OpticalFiber" AS "of" ON "of".id = "ofj"."OpticalFiber"
            LEFT JOIN "OpticalFiberSplice" AS "ofs" ON "ofs".id = '.pg_escape_string( $spliceId ).'
            LEFT JOIN "CableLine" AS "cl" ON "cl".id = "of"."CableLine"
            LEFT JOIN "NetworkNode" AS "nn" ON "nn".id = "ofs"."NetworkNode"
            WHERE "ofj"."OpticalFiberSplice" = '.pg_escape_string( $spliceId );
    $res = PQuery( $query );
    $res = fillCableLengthBySign($res);
    return $res[ 'rows' ];
}

function getLineByFiberId( $fiberId )
{
    $query = 'SELECT "of"."CableLine", "of".fiber, "of".note, "cl"."name" AS "cl_name", "of".id, round(cl.length / 100.0, 2) AS length
                FROM "OpticalFiber" AS "of"
                LEFT JOIN "CableLine" AS "cl" ON "cl".id = "of"."CableLine"
                WHERE "of".id = '.($fiberId);
    $res = PQuery( $query );
    $res = fillCableLengthBySign($res);
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
    $result = PQuery( $query.' ORDER BY fiber DESC' );
    return $result;
}

function getFiberSpliceOrganizerInfo( $linesPerPage = -1, $skip = -1,
        $networkNode = -1, $free = 1 )
{
    /* $query = 'SELECT DISTINCT "fso".id,
      "fso"."FiberSpliceOrganizationType" AS "FiberSpliceOrganizationTypeId",
      "fsot"."marking" AS "FiberSpliceOrganizationTypeMarking",
      "fsot"."manufacturer" AS "FiberSpliceOrganizationTypeManufacturer",
      "nn".id AS "NetworkNodeId", "nn"."name" AS "NetworkNodeName",
      COUNT(DISTINCT "fs".id) AS "FiberSpliceCount"
      FROM "FiberSpliceOrganizer" AS "fso"
      LEFT JOIN "FiberSplice" AS "fs" ON "fs"."FiberSpliceOrganizer"="fso".id
      LEFT JOIN "CableLinePoint" AS "clp" ON "clp".id="fs"."CableLinePointA" OR "clp".id="fs"."CableLinePointB"
      LEFT JOIN "NetworkNode" AS "nn" ON "nn".id="clp"."NetworkNode"
      LEFT JOIN "FiberSpliceOrganizerType" AS "fsot" ON "fsot".id="fso"."FiberSpliceOrganizationType"
      WHERE "fs"."FiberSpliceOrganizer"="fso".id'; */
    $query = 'SELECT DISTINCT ON ("fso".id) "fso".id,
        "fso"."FiberSpliceOrganizationType" AS "FiberSpliceOrganizationTypeId",
        "fsot"."marking" AS "FiberSpliceOrganizationTypeMarking",
        "fsot"."manufacturer" AS "FiberSpliceOrganizationTypeManufacturer",
        "nn".id AS "NetworkNodeId", "nn"."name" AS "NetworkNodeName",
        COUNT("ofs".id) AS "FiberSpliceCount"
        FROM "FiberSpliceOrganizer" AS "fso"
        LEFT JOIN "OpticalFiberSplice" AS "ofs" ON "ofs"."FiberSpliceOrganizer"="fso".id        
        LEFT JOIN "NetworkNode" AS "nn" ON "nn".id="ofs"."NetworkNode"
        LEFT JOIN "FiberSpliceOrganizerType" AS "fsot" ON "fsot".id="fso"."FiberSpliceOrganizationType"';
    if ( $networkNode != -1 )
    {
        if ( strpos( "WHERE", $query ) >= 0 )
        {
            $query .= " WHERE ";
        }
        $query .= ' "nn".id='.$networkNode;
    }
    if ( $free == 1 )
    {
        if ( strpos( "WHERE", $query ) >= 0 )
        {
            $query .= ' OR "nn".id IS NULL';
        }
        else
        {
            $query .= ' WHERE "nn".id IS NULL';
        }
    }
    $query .= ' GROUP BY "fso".id, "fsot"."marking", "fsot"."manufacturer", "nn".id,
        "fso"."FiberSpliceOrganizationType", "nn"."name"';
    if ( ($linesPerPage > 0) and ($skip >= 0) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
    }
    $result = PQuery( $query );
    $query = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizer"';
    $res = PQuery( $query );
    $result[ 'allPages' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    return $result;
}

?>