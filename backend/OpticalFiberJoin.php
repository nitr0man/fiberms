<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function OpticalFiberJoin_SELECT( $sort, $wr )
{
    $query = 'SELECT * FROM "OpticalFiberJoin"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "OpticalFiber"';
    }
    else
    {
        $query .= ' ORDER BY "OpticalFiber"';
    }
    $result = PQuery( $query );
    return $result;
}

function OpticalFiberJoin_INSERT( $ins )
{
    $query = 'INSERT INTO "OpticalFiberJoin"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'OpticalFiberJoin', $ins, '' );
    return $result;
}

function OpticalFiberJoin_UPDATE( $upd, $wr, $tmpT = FALSE )
{
    $query = 'UPDATE "'.tmpTable( 'OpticalFiberJoin', $tmpT ).'" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    $result = PQuery( $query );
    loggingIs( 1, 'OpticalFiberJoin', $upd, $wr[ 'id' ] );
    return $result;
}

function OpticalFiberJoin_DELETE( $wr, $sign = '=' )
{
    $query = 'DELETE FROM "OpticalFiberJoin"';
    $query .= genWhere( $wr, $sign );
    $result = PQuery( $query );
    loggingIs( 3, 'OpticalFiberJoin', '', $wr[ 'id' ] );
    return $result;
}

function getNodeFibers( $nodeId, $OFJ_id = -1, $CableLine = -1, $tmpT = FALSE )
{
    $wr[ 'NetworkNode' ] = $nodeId;
    if ( $OFJ_id != -1 )
    {
	$wr[ 'OFJ.id' ] = $OFJ_id;
    }
    if ( $CableLine != -1 )
    {
	$wr[ 'CableLine' ] = $CableLine;
    }
    $query = 'SELECT "OFJ".id AS "OFJ_id", "OpticalFiber", "OpticalFiberSplice", "OF"."CableLine", "OF".fiber, "OFS"."FiberSpliceOrganizer", round("OFS".attenuation / 100.0, 2) AS attenuation, "OFS".note
		FROM "'.tmpTable( 'OpticalFiberJoin', $tmpT ).'" AS "OFJ"
		LEFT JOIN "'.tmpTable( 'OpticalFiber', $tmpT ).'" AS "OF" ON "OF".id = "OFJ"."OpticalFiber"
		LEFT JOIN "'.tmpTable( 'OpticalFiberSplice', $tmpT ).'" AS "OFS" ON "OFS".id = "OFJ"."OpticalFiberSplice"'.genWhere( $wr ).'
		ORDER BY "OFJ"."OpticalFiberSplice"';
    $result = PQuery( $query );
    return $result;
}

function addOpticalFiberJoin( $CableLine, $fiber, $OpticalFiberSplice )
{
    $query = 'INSERT INTO "OpticalFiberJoin"(
            "OpticalFiber", "OpticalFiberSplice")
    VALUES ((SELECT id FROM "OpticalFiber" WHERE "fiber"='.pg_escape_string( $fiber ).' AND "CableLine"='.pg_escape_string( $CableLine ).'), '.pg_escape_string( $OpticalFiberSplice ).')';
    $result = PQuery( $query );
    return $result;
}

function OpticalFiberJoin_replaceCableLine( $oldCableLine, $newCableLine, $NetworkNode, $tmpT = FALSE )
{
    $ofj = getNodeFibers( $NetworkNode, -1, $oldCableLine, $tmpT );
    if (isset($ofj['error']))
	return $ofj;
    foreach ($ofj['rows'] as $row) {
	$fiber = OpticalFiber_SELECT(0, array('CableLine' => $newCableLine, 'fiber' => $row['fiber']), $tmpT);
	OpticalFiberJoin_UPDATE( array('OpticalFiber' => $fiber['rows'][0]['id']), array('id' => $row['OFJ_id']), $tmpT );
    }
    return $ofj;
}

?>