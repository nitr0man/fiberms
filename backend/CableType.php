<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function CableLine_AddOpticalFiber( $cableLine, $tmpT = FALSE )
{
    $query = 'SELECT "CableType" FROM "'.tmpTable( 'CableLine', $tmpT ).'" WHERE id='.$cableLine;
    $res = PQuery( $query );
    $CableType = $res[ 'rows' ][ 0 ][ 'CableType' ];
    $query = 'SELECT "tubeQuantity" * "fiberPerTube" AS "fibers" FROM "'.tmpTable( 'CableType',
                    $tmpT ).'" WHERE id='.$CableType;
    $res2 = PQuery( $query );
    $fibers = $res2[ 'rows' ][ 0 ][ 'fibers' ];
    for ( $fiber = 1; $fiber <= $fibers; $fiber++ )
    {
        $ins[ 'CableLine' ] = $cableLine;
        $ins[ 'fiber' ] = $fiber;
        $query = 'INSERT INTO "'.tmpTable( 'OpticalFiber', $tmpT ).'" '.genInsert( $ins );
        PQuery( $query );
    }
}

function CableLine_AddOpticalFiberForAll()
{
    $query = 'SELECT "id" FROM "CableLine"';
    $res = PQuery( $query );
    $rows = $res[ 'rows' ];
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $wr[ 'CableLine' ] = $rows[ $i ][ 'id' ];
        $query = 'SELECT COUNT(id) AS "count" FROM "OpticalFiber"'.genWhere( $wr );
        $res2 = PQuery( $query );
        if ( $res2[ 'rows' ][ 0 ][ 'count' ] == 0 )
        {
            CableLine_AddOpticalFiber( $rows[ $i ][ 'id' ] );
        }
    }

    $query = 'SELECT "id" FROM "CableLine_tmp"';
    $res = PQuery( $query );
    $rows = $res[ 'rows' ];
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $wr[ 'CableLine' ] = $rows[ $i ][ 'id' ];
        $query = 'SELECT COUNT(id) AS "count" FROM "OpticalFiber_tmp"'.genWhere( $wr );
        $res2 = PQuery( $query );
        if ( $res2[ 'rows' ][ 0 ][ 'count' ] == 0 )
        {
            CableLine_AddOpticalFiber( $rows[ $i ][ 'id' ], true );
        }
    }
}

function CableLine_SELECT( $sort, $wr, $tmpT = FALSE )
{
    $query = 'SELECT id, "OpenGIS", "CableType", round(length / 100.0, 2) AS length, comment, name FROM "'.tmpTable( 'CableLine', $tmpT ).'"';
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

function CableLine_INSERT( $ins, $tmpT = FALSE )
{
    if ( $ins[ 'length' ] ) {
        $len = str_replace(',', '.', $ins[ 'length' ]);
        if ( is_numeric( $len ) )
            $ins[ 'length' ] = floatval($len) * 100;
    }
    $query = 'INSERT INTO "'.tmpTable( 'CableLine', $tmpT ).'"';
    $query .= genInsert( $ins )." RETURNING id";
    $result = PQuery( $query );
    loggingIs( 2, 'CableLine', $ins, '' );
    if (isset($result['rows']))
	CableLine_AddOpticalFiber($result['rows'][0]['id'], $tmpT);
    return $result;
}

function CableLine_UPDATE( $upd, $wr, $tmpT = FALSE  )
{
    if ( $upd[ 'length' ] ) {
        $len = str_replace(',', '.', $upd[ 'length' ]);
        if ( is_numeric( $len ) )
            $upd[ 'length' ] = floatval($len) * 100;
    }
    $query = 'UPDATE "'.tmpTable( 'CableLine', $tmpT ).'" SET ';
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

function CableLine_DELETE( $wr, $tmpT = FALSE  )
{
    $wr2[ 'CableLine' ] = $wr[ 'id' ];
    $query = 'DELETE FROM "'.tmpTable( 'OpticalFiberSplice', $tmpT ).'" WHERE id IN (SELECT "OpticalFiberSplice" FROM "'.
	tmpTable( 'OpticalFiberJoin', $tmpT ).'" AS ofj LEFT JOIN "'.tmpTable( 'OpticalFiber', $tmpT ).'" AS of ON '.
	'ofj."OpticalFiber" = of.id '.genWhere( $wr2 ).')';
    $result = PQuery( $query );
    $query = 'DELETE FROM "'.tmpTable( 'OpticalFiberJoin', $tmpT ).'" WHERE id IN (SELECT ofj.id FROM "'.
	tmpTable( 'OpticalFiberJoin', $tmpT ).'" AS ofj LEFT JOIN "'.tmpTable( 'OpticalFiberSplice', $tmpT ).'" AS ofs ON '.
	'ofj."OpticalFiberSplice" = ofs.id WHERE ofs.id IS NULL)';
    $result = PQuery( $query );
    $query = 'DELETE FROM "'.tmpTable( 'OpticalFiberJoin', $tmpT ).'" WHERE "OpticalFiber" IN (SELECT id FROM "'.
	tmpTable( 'OpticalFiber', $tmpT ).'"'.genWhere( $wr2 ).')';
    $result = PQuery( $query );
    $query = 'DELETE FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'"'.genWhere( $wr2 );
    $result = PQuery( $query );
    $query = 'DELETE FROM "'.tmpTable( 'OpticalFiber', $tmpT ).'"'.genWhere( $wr2 );
    $result = PQuery( $query );
    $query = 'DELETE FROM "'.tmpTable( 'CableLine', $tmpT ).'"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, 'CableLine', '', $wr[ 'id' ] );
    return $result;
}

function CableType_SELECT( $sort, $wr, $linesPerPage = -1, $skip = -1 )
{
    $allPages = 0;
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

function CableLinePoint_SELECT( $wr, $tmpT = FALSE )
{
    $query = 'SELECT * FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $query .= ' ORDER BY sequence';
    $result = PQuery( $query );
    return $result;
}

function CableLinePoint_INSERT( $ins, $tmpT = FALSE )
{
    $query = 'INSERT INTO "'.tmpTable( 'CableLinePoint', $tmpT ).'"';
    $query .= genInsert( $ins );
    $query .= ' RETURNING id';
    $result = PQuery( $query );
    loggingIs( 2, 'CableLinePoint', $ins, '' );
    return $result;
}

function CableLinePoint_UPDATE( $upd, $wr, $tmpT = FALSE )
{
    $query = 'UPDATE "'.tmpTable( 'CableLinePoint', $tmpT ).'" SET ';
    $query .= genUpdate( $upd );
    $where = '';
    if ( $wr != '' )
    {
        $where = genWhere( $wr );
    }
    $val = '';
    if (! isset($wr[ 'id' ])) {
        if ( $wr != '' )
        {
            $query1 = 'SELECT id FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'" '.$where;
            $result = PQuery( $query1 );
            $wr[ 'id' ] = $result['rows'][0]['id'];
            if ($result['count'] > 1) {
                $wr[ 'id' ] = '';
                $val = $where;
            }
        } else
            $wr[ 'id' ] = '';
    }
    $result = PQuery( $query.$where );
    loggingIs( 1, tmpTable( 'CableLinePoint', $tmpT ), $upd, $wr[ 'id' ] );
    return $result;
}

function CableLinePoint_DELETE( $wr, $tmpT = FALSE )
{
    $query = 'DELETE FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'"';
    $where = genWhere( $wr );
    $val = '';
    if (! isset($wr[ 'id' ])) {
        if ( $wr != '' )
        {
            $query1 = 'SELECT id FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'" '.$where;
            $result = PQuery( $query1 );
            $wr[ 'id' ] = $result['rows'][0]['id'];
            if ($result['count'] > 1) {
                $wr[ 'id' ] = '';
                $val = $where;
            }
        } else
            $wr[ 'id' ] = '';
    }
    $result = PQuery( $query.$where );
    loggingIs( 3, 'CableLinePoint', $val, $wr[ 'id' ] );
    return $result;
}

function getCableLinePoint_NetworkNodeName( $cableLineId )
{
    $query = 'SELECT "clp".id, "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign", "clp"."NetworkNode", "clp"."note", 
       "clp"."Apartment", "clp"."Building", "clp"."SettlementGeoSpatial", "NN"."name"
	FROM "CableLinePoint" AS "clp"  LEFT JOIN "NetworkNode" AS "NN" ON "NN".id = "clp"."NetworkNode" WHERE "CableLine"='.$cableLineId.' ORDER BY "clp"."sequence"';
    $result = PQuery( $query );
    return $result;
}

function getCableLinesSpliceCount( $tmpT = FALSE )
{
    $result = array();
    $query = 'SELECT "cl".id, COUNT(DISTINCT "of"."id") AS "FiberSpliceCount"
        FROM "CableLine" AS "cl"
        LEFT JOIN "'.tmpTable( 'OpticalFiber', $tmpT ).'" AS "of" ON "of"."CableLine" = "cl".id
        LEFT JOIN "'.tmpTable( 'OpticalFiberJoin', $tmpT ).'" AS "ofj" ON "ofj"."OpticalFiber" = "of".id        
        GROUP BY "cl".id';
    $res = PQuery( $query );
    $rows = $res[ 'rows' ];
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $cableLine = $rows[ $i ][ 'id' ];
        $result[ $cableLine ][ 'FiberSpliceCount' ] = $rows[ $i ][ 'FiberSpliceCount' ];
    }
    return $result;
}

function getCableLineList( $sort, $wr, $linesPerPage = -1, $skip = -1,
        $tmpT = FALSE )
{
    $query = 'SELECT DISTINCT ON ("cl".id, cl."name") "cl".id, "cl"."OpenGIS", "cl"."CableType", round("cl"."length" / 100.0, 2) AS "length", "cl"."comment",
                "cl"."name", "ct"."marking", "ct"."manufacturer",
                "ct"."fiberPerTube"*"ct"."tubeQuantity" AS "fibers", "ct"."fiberPerTube",
                "ct"."tubeQuantity", "NN"."OpenGIS" AS "NNOpenGIS"                                
                FROM "'.tmpTable( 'CableLine', $tmpT ).'" AS "cl"
		LEFT JOIN "'.tmpTable( 'CableLinePoint', $tmpT ).'" AS "clp" ON "clp"."CableLine" = "cl"."id" 
		LEFT JOIN "'.tmpTable( 'CableType', $tmpT ).'" AS "ct" ON "ct".id="cl"."CableType"
		LEFT JOIN "'.tmpTable( 'OpticalFiber', $tmpT ).'" AS "OF" ON "OF"."CableLine" = "cl".id
		LEFT JOIN "'.tmpTable( 'OpticalFiberJoin', $tmpT ).'" AS "OFJ" ON "OFJ"."OpticalFiber" = "OF".id
                LEFT JOIN "'.tmpTable( 'NetworkNode', $tmpT ).'" AS "NN" ON "NN"."id" = "clp"."NetworkNode"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "name"';
    }
    $allPages = 0;
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
    $result = PQuery( $query );

    $splices = getCableLinesSpliceCount( $tmpT );
    for ( $i = 0; $i < $result[ 'count' ]; $i++ )
    {
        $id = $result[ 'rows' ][ $i ][ 'id' ];
        $result[ 'rows' ][ $i ][ 'FiberSpliceCount' ] = (isset($splices[ $id ])) ? $splices[ $id ][ 'FiberSpliceCount' ] : 0;
    }

    $result[ 'allPages' ] = $allPages;
    return $result;
}

function getCopperCableLines()
{
    $query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", round("cl".length / 100.0, 2) AS "length", "cl".comment, "cl".name, "ct"."fiberPerTube"
			  FROM "CableLine" AS "cl"
			  LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"
			  WHERE "ct"."fiberPerTube"=0 AND "OpenGIS" IS NOT NULL';
    $result = PQuery( $query );
    return $result;
}

function getNormalCableLines()
{
    $query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", round("cl".length / 100.0, 2) AS "length", "cl".comment, "cl".name, "ct"."fiberPerTube"
			  FROM "CableLine" AS "cl"
			  LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"
			  WHERE "ct"."fiberPerTube"!=0 AND "OpenGIS" IS NOT NULL';
    $result = PQuery( $query );
    return $result;
}

function getSingularCableLinePoints( $OpenGIS = -1, $tmpT = FALSE )
{
    $query = 'SELECT "clp"."id" AS "CLPId", "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign",
              "clp"."NetworkNode", "clp"."note", "cl"."name" AS "CableLineName"
              FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'" AS "clp"
              LEFT JOIN "'.tmpTable( 'CableLine', $tmpT ).'" AS "cl" ON "cl".id = "clp"."CableLine"
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
              FROM "'.tmpTable( 'CableLinePoint', $tmpT ).'" AS "clp"
              LEFT JOIN "'.tmpTable( 'NetworkNode', $tmpT ).'" AS "NN" ON "NN".id = "clp"."NetworkNode"'.genWhere( $wr );
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

function getCableLinesFrag( $cableLines, $tmpT = FALSE )
{
    $resFrags = array();
    for ( $i = 0; $i < count( $cableLines ); $i++ )
    {
        $cableLine = $cableLines[ $i ][ 'id' ];
        $cableLinePoints = getCableLinePoints( $cableLine, FALSE, $tmpT );
        $rows = $cableLinePoints[ 'rows' ];
        $b = 0;
        $n = 0;
        for ( $j = 0; $j < count( $rows ); $j++ )
        {
            $rows[ $j ][ 'sequence' ] = $j + 1;
        }
        for ( $j = 0; $j < count( $rows ); $j++ )
        {
            $OpenGIS = $rows[ $j ][ 'OpenGIS' ];
            $NNOpenGis = $rows[ $j ][ 'NNOpenGIS' ];
            $rows[ $j ][ 'sequence' ] = $j + 1;
            if ( !preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/', $OpenGIS,
                            $matches ) )
            {
                if (!preg_match_all( '/(?<lon>[0-9.]+),(?<lat>[0-9.]+)/', $NNOpenGis,
                    $matches )) {
                    error_log("Line $cableLine, point ".$rows[$j]['id'].": no coordinates!!!");
                    continue;
                }
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