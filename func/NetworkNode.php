<?php

require_once("backend/NetworkNode.php");
require_once("backend/NetworkBoxType.php");
require_once("backend/CableType.php");
//require_once("backend/FS.php");
require_once("backend/OpticalFiberSplice.php");

function NetworkNode_Check( $name, $networkBox, $note, $OpenGIS,
        $SettlementGeoSpatial, $building, $apartment )
{
    $result = 1;
    /* здесь проверка */
    if ( ($name == '' ) )
    {
        $result = 0;
    }
    return $result;
}

function NetworkNode_Mod( $id, $name, $networkBox, $note, $OpenGIS,
        $SettlementGeoSpatial, $building, $apartment )
{
    if ( NetworkNode_Check( $name, $networkBox, $note, $OpenGIS,
                    $SettlementGeoSpatial, $building, $apartment ) == 0 )
    {
        return 0;
    }
    $upd[ 'name' ] = $name;
    $upd[ 'NetworkBox' ] = $networkBox;
    $upd[ 'note' ] = $note;
    $upd[ 'OpenGIS' ] = $OpenGIS;
    $upd[ 'SettlementGeoSpatial' ] = $SettlementGeoSpatial;
    $upd[ 'Building' ] = $building;
    $upd[ 'Apartment' ] = $apartment;
    $wr[ 'id' ] = $id;
    $res = NetworkNode_UPDATE( $upd, $wr );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

function NetworkNode_Add( $name, $networkBox, $note, $OpenGIS,
        $SettlementGeoSpatial, $building, $apartment )
{
    if ( NetworkNode_Check( $name, $networkBox, $note, $OpenGIS,
                    $SettlementGeoSpatial, $building, $apartment ) == 0 )
    {
        return 0;
    }
    $ins[ 'name' ] = $name;
    $ins[ 'NetworkBox' ] = $networkBox;
    $ins[ 'note' ] = $note;
    $ins[ 'OpenGIS' ] = $OpenGIS;
    $ins[ 'SettlementGeoSpatial' ] = $SettlementGeoSpatial;
    $ins[ 'Building' ] = $building;
    $ins[ 'Apartment' ] = $apartment;
    $res = NetworkNode_INSERT( $ins );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

function getNetworkNodeInfo( $networkNodeId )
{
    $res = getNetworkNode_NetworkBoxName( $networkNodeId );
    $result[ 'NetworkNode' ] = $res;
    $query = 'SELECT "clp".id, "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign", "clp"."NetworkNode", "clp"."note", "clp"."Apartment", "clp"."Building", "clp"."SettlementGeoSpatial", "cl"."name" AS "clname", COUNT("OFJ"."OpticalFiberSplice") AS "fiberSpliceCount"
		FROM "CableLinePoint" AS "clp"
		LEFT JOIN "CableLine" AS "cl" ON "cl".id="clp"."CableLine"
		LEFT JOIN "OpticalFiber" AS "OF" ON "OF"."CableLine" = "cl".id
		LEFT JOIN "OpticalFiberJoin" AS "OFJ" ON "OFJ"."OpticalFiber" = "OF".id
		WHERE "clp"."NetworkNode"='.pg_escape_string( $networkNodeId ).'
		GROUP BY "clp".id, "cl"."name"';
    $res2 = PQuery( $query );
    $result[ 'NetworkNode' ][ 'CableLinePoints' ] = $res2;
    unset( $wr );
    $res = getFiberSpliceOrganizerInfo( -1, -1, $networkNodeId, 0 );
    $result[ 'NetworkNode' ][ 'FSO' ] = $res;
    return $result;
}

/* function GetFreeNetworkBoxs($networkBox) {
  $res = NetworkBox_SELECT('', '');
  $rows = $res['rows'];
  $i2 = 0;
  for ($i = 0; $i < $rows['count']; $i++) {
  $wr['NetworkNode'] = $rows[$i]['id'];
  $res2 = NetworkNode_SELECT(0, '', $wr);
  if (($res2['count'] == 0) or ($networkBox == $rows[$i]['id'])) {
  $result['rows'][$i2]['id'] = $rows[$i]['id'];
  $result['rows'][$i2]['NetworkBoxType'] = $rows[$i]['NetworkBoxType'];
  $result['rows'][$i2]['inventoryNumber'] = $rows[$i]['inventoryNumber'];
  $i2++;
  }
  }
  $result['count'] = count($result['rows']);
  return $result;
  } */
?>