<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function NetworkNode_SELECT( $sort, $FSort, $wr, $tmpT = FALSE )
{
    $query = 'SELECT * FROM "'.tmpTable( 'NetworkNode', $tmpT ).'"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "'.$FSort.'"';
    }
    else
    {
        $query .= ' ORDER BY "name"';
    }
    $result = PQuery( $query );
    return $result;
}

function NetworkNode_INSERT( $ins, $tmpT = FALSE )
{
    $query = 'INSERT INTO "'.tmpTable( 'NetworkNode', $tmpT ).'"';
    $query .= genInsert( $ins );
    $query .= " RETURNING id";
    $result = PQuery( $query );
    loggingIs( 2, tmpTable( 'NetworkNode', $tmpT ), $ins, '' );
    return $result;
}

function NetworkNode_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "NetworkNode" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'NetworkNode', $upd, $wr[ 'id' ] );
    return $result;
}

function NetworkNode_DELETE( $wr, $tmpT = FALSE )
{
    require_once 'backend/CableType.php';

    $NetworkNodeId = $wr[ 'id' ];
    $res = NetworkNode_SELECT( '', '', $wr );
    $upd[ 'NetworkNode' ] = 'NULL';
    $upd[ 'OpenGIS' ] = $res[ 'rows' ][ 0 ][ 'OpenGIS' ];
    $query = 'UPDATE "'.tmpTable( 'CableLinePoint', $tmpT ).'" SET '.genUpdate( $upd ).' WHERE "NetworkNode"='.$NetworkNodeId;
    PQuery( $query );
    $query = 'DELETE FROM "'.tmpTable( 'NetworkNode', $tmpT ).'"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, ''.tmpTable( 'NetworkNode', $tmpT ).'', '', $NetworkNodeId );
    return $result;
}

function getNetworkNode_NetworkBoxName( $networkNodeId )
{
    $query = 'SELECT "NN".id, "NN"."OpenGIS", "NN"."name", "NN"."NetworkBox", "NN"."note", "NN"."SettlementGeoSpatial", 
        "NN"."Building", "NN"."Apartment", "NB"."inventoryNumber", COUNT("OFS".id) AS "fiberSpliceCount"
  		FROM "NetworkNode" AS "NN"
		LEFT JOIN "NetworkBox" AS "NB" ON "NB".id="NN"."NetworkBox" 
		LEFT JOIN "OpticalFiberSplice" AS "OFS" ON "OFS"."NetworkNode" = "NN".id
		WHERE "NN".id='.pg_escape_string( $networkNodeId ).'
		GROUP BY "NN".id, "NB"."inventoryNumber"';
    $result = PQuery( $query );
    return $result;
}

function getNetworkNodeList_NetworkBoxName( $sort, $FSort, $wr,
        $linesPerPage = -1, $skip = -1, $tmpT = FALSE )
{
    $query = 'SELECT "NN".id, "NN"."OpenGIS", "NN"."name", "NN"."NetworkBox", "NN"."note", "NN"."SettlementGeoSpatial", 
        "NN"."Building", "NN"."Apartment", "NB"."inventoryNumber", "NB"."NetworkBoxType", "NBT"."marking" AS "NBTmarking", COUNT("OFS".id) AS "fiberSpliceCount"
  		FROM "'.tmpTable( 'NetworkNode',
                    $tmpT ).'" AS "NN"
  		LEFT JOIN "'.tmpTable( 'NetworkBox',
                    $tmpT ).'" AS "NB" ON "NB".id="NN"."NetworkBox"
  		LEFT JOIN "'.tmpTable( 'NetworkBoxType',
                    $tmpT ).'" AS "NBT" ON "NBT".id="NB"."NetworkBoxType"
  		LEFT JOIN "'.tmpTable( 'OpticalFiberSplice',
                    $tmpT ).'" AS "OFS" ON "OFS"."NetworkNode" = "NN".id';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "NN"."'.$FSort.'" LIMIT 0,2';
    }
    $query .= ' GROUP BY "NN".id, "NB"."inventoryNumber", "NB"."NetworkBoxType", "NBT"."marking"';
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "'.tmpTable( 'NetworkNode',
                        $tmpT ).'"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );
    $result[ 'allPages' ] = $allPages;
    return $result;
}

function getFreeNetworkBoxes( $networkBox )
{
    $query = 'SELECT "NB".id, "NB"."NetworkBoxType", "NB"."inventoryNumber", "NN".id AS "nnid" FROM "NetworkBox" AS "NB" LEFT JOIN "NetworkNode" AS "NN" ON "NN"."NetworkBox"="NB".id WHERE "NN".id IS NULL OR "NB".id='.$networkBox;
    $result = PQuery( $query );
    return $result;
}

function getFiberSpliceCount( $networkNode = -1 )
{
    $where = '';
    if ( $networkNode != -1 )
    {
        $wr[ 'id' ] = $networkNode;
        $where = GenWhere( $wr );
    }
    $query = 'SELECT COUNT(id) AS "count" FROM "OpticalFiberSplice"'.$where;
    $result[ 'fiberSpliceCount' ] = PQuery( $query )[ 'rows' ][ 0 ][ 'count' ];
    if ( $networkNode == -1 )
    {
        $query = 'SELECT COUNT(DISTINCT "NetworkNode") AS "count" FROM "OpticalFiberSplice"';
        $result[ 'NetworkNodesCountInFiberSplice' ] = PQuery( $query )[ 'rows' ][ 0 ][ 'count' ];
    }
    return $result;
}

?>
