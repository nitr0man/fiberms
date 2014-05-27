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
    $res = NetworkNode_SELECT( '', '', $wr, $tmpT );
    $upd[ 'NetworkNode' ] = 'NULL';
    $upd[ 'OpenGIS' ] = $res[ 'rows' ][ 0 ][ 'OpenGIS' ];
    $query = 'UPDATE "'.tmpTable( 'CableLinePoint', $tmpT ).'" SET '.genUpdate( $upd ).' WHERE "NetworkNode"='.$NetworkNodeId;
    PQuery( $query );
    $query = 'DELETE FROM "'.tmpTable( 'NetworkNode', $tmpT ).'"';
    $query .= genWhere( $wr );
    $result = PQuery( $query );
    loggingIs( 3, tmpTable( 'NetworkNode', $tmpT ), '', $NetworkNodeId );
    return $result;
}

function getNetworkNode_NetworkBoxName( $networkNodeId )
{
    $query = 'SELECT "NN".id, "NN"."name", "NN"."NetworkBox", "NN"."note", "NN"."SettlementGeoSpatial", 
        "NN"."OpenGIS", "NN"."Building", "NN"."Apartment", "NB"."inventoryNumber", "NBT"."marking" AS "NBTMarking",
        COUNT("OFS".id) AS "fiberSpliceCount"
  		FROM "NetworkNode" AS "NN"
		LEFT JOIN "NetworkBox" AS "NB" ON "NB".id="NN"."NetworkBox" 
                LEFT JOIN "NetworkBoxType" AS "NBT" ON "NBT".id="NB"."NetworkBoxType" 
		LEFT JOIN "OpticalFiberSplice" AS "OFS" ON "OFS"."NetworkNode" = "NN".id
		WHERE "NN".id='.pg_escape_string( $networkNodeId ).'
		GROUP BY "NN".id, "NB"."inventoryNumber", "NN"."name", "NN"."NetworkBox",
                  "NN"."note", "NN"."SettlementGeoSpatial", "NN"."Building", "NN"."Apartment", "NBT"."marking"';
    $result = PQuery( $query );
    return $result;
}

function getNetworkNodeList_NetworkBoxName( $sort, $FSort, $wr,
        $linesPerPage = -1, $skip = -1, $tmpT = FALSE )
{
    $query = 'SELECT "NN".id, "NN"."OpenGIS", "NN"."name", "NN"."NetworkBox", "NN"."note", "NN"."SettlementGeoSpatial", 
        "NN"."Building", "NN"."Apartment", "NB"."inventoryNumber", "NB"."NetworkBoxType", "NBT"."marking" AS "NBTmarking"
  		FROM "'.tmpTable( 'NetworkNode', $tmpT ).'" AS "NN"
  		LEFT JOIN "'.tmpTable( 'NetworkBox', $tmpT ).'" AS "NB" ON "NB".id="NN"."NetworkBox"
  		LEFT JOIN "'.tmpTable( 'NetworkBoxType', $tmpT ).'" AS "NBT" ON "NBT".id="NB"."NetworkBoxType"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "NN"."'.$FSort.'" LIMIT 0,2';
    }
    $allPages = 0;
    if ( ($linesPerPage != -1) and ($skip != -1) )
    {
        $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
        $query2 = 'SELECT COUNT(*) AS "count" FROM "'.tmpTable( 'NetworkNode',
                        $tmpT ).'"';
        $res = PQuery( $query2 );
        $allPages = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    $result = PQuery( $query );

    $splices = getSpliceCountByNetworkNode( $tmpT );
    for ( $i = 0; $i < $result[ 'count' ]; $i++ )
    {
        $id = $result[ 'rows' ][ $i ][ 'id' ];
        $result[ 'rows' ][ $i ][ 'fiberSpliceCount' ] = $splices[ $id ][ 'fiberSpliceCount' ];
    }

    $result[ 'allPages' ] = $allPages;
    return $result;
}

function getFreeNetworkBoxes( $networkBox, $tmpT = FALSE )
{
    $query = 'SELECT "NB".id, "NB"."NetworkBoxType", "NB"."inventoryNumber",
        "NN".id AS "nnid", "NBT"."marking"
        FROM "'.tmpTable( 'NetworkBox', $tmpT ).'" AS "NB"
        LEFT JOIN "'.tmpTable( 'NetworkNode', $tmpT ).'" AS "NN" ON "NN"."NetworkBox"="NB".id
        LEFT JOIN "'.tmpTable( 'NetworkBoxType', $tmpT ).'" AS "NBT" ON "NBT".id = "NB"."NetworkBoxType"
        WHERE "NN".id IS NULL OR "NB".id='.$networkBox;
    $result = PQuery( $query );
    return $result;
}

function getSpliceCountByNetworkNode( $tmpT = FALSE )
{
    $result = array();
    $query = 'SELECT "NN".id, COUNT("OFS".id) AS "fiberSpliceCount"
  		FROM "'.tmpTable( 'NetworkNode', $tmpT ).'" AS "NN"
  		LEFT JOIN "'.tmpTable( 'NetworkBox', $tmpT ).'" AS "NB" ON "NB".id="NN"."NetworkBox"
  		LEFT JOIN "'.tmpTable( 'OpticalFiberSplice', $tmpT ).'" AS "OFS" ON "OFS"."NetworkNode" = "NN".id
  		GROUP BY "NN".id';
    $res = PQuery( $query );
    $rows = $res[ 'rows' ];
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $networkNode = $rows[ $i ][ 'id' ];
        $result[ $networkNode ][ 'fiberSpliceCount' ] = $rows[ $i ][ 'fiberSpliceCount' ];
    }
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
    $res = PQuery( $query );
    if ( $res[ 'count' ] > 0 )
    {
        $result[ 'fiberSpliceCount' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    }
    else
    {
        $result[ 'fiberSpliceCount' ] = 0;
    }
    if ( $networkNode == -1 )
    {
        $query = 'SELECT COUNT(DISTINCT "NetworkNode") AS "count" FROM "OpticalFiberSplice"';
        $res2 = PQuery( $query );
        if ( $res2[ 'count' ] > 0 )
        {
            $result[ 'NetworkNodesCountInFiberSplice' ] = $res2[ 'rows' ][ 0 ][ 'count' ];
        }
        else
        {
            $result[ 'NetworkNodesCountInFiberSplice' ] = 0;
        }
    }
    return $result;
}

?>
