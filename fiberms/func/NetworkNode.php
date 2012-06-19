<?php
require_once("backend/NetworkNode.php");
require_once("backend/NetworkBoxType.php");
require_once("backend/CableType.php");
require_once("backend/FS.php");

function NetworkNode_Check($name, $networkBox, $note, $OpenGIS, $SettlementGeoSpatial, $building, $apartment) {	$result = 1;
	/* здесь проверка */
	if (($name == '')) {
		$result = 0;
	}
	return $result;
}

function NetworkNode_Mod($id, $name, $networkBox, $note, $OpenGIS, $SettlementGeoSpatial, $building, $apartment) {	if (NetworkNode_Check($name, $networkBox, $note, $OpenGIS, $SettlementGeoSpatial, $building, $apartment) == 0) {		return 0;
	}
	$upd['name'] = $name;
    $upd['NetworkBox'] = $networkBox;
    $upd['note'] = $note;
    $upd['OpenGIS'] = $OpenGIS;
    $upd['SettlementGeoSpatial'] = $SettlementGeoSpatial;
    $upd['Building'] = $building;
    $upd['Apartment'] = $apartment;
    $wr['id'] = $id;
   	$res = NetworkNode_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
   	return 1;
}

function NetworkNode_Add($name, $networkBox, $note, $OpenGIS, $SettlementGeoSpatial, $building, $apartment) {	if (NetworkNode_Check($name, $networkBox, $note, $OpenGIS, $SettlementGeoSpatial, $building, $apartment) == 0) {
		return 0;
	}
	$ins['name'] = $name;
	$ins['NetworkBox'] = $networkBox;
    $ins['note'] = $note;
    $ins['OpenGIS'] = $OpenGIS;
    $ins['SettlementGeoSpatial'] = $SettlementGeoSpatial;
    $ins['Building'] = $building;
    $ins['Apartment'] = $apartment;
    $res = NetworkNode_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
    return 1;
}

function getNetworkNodeInfo($networkNodeId) {	$res = getNetworkNode_NetworkBoxName($networkNodeId);
	$result['NetworkNode'] = $res;
	$wr['NetworkNode'] = $networkNodeId;
	$query = 'SELECT "clp".id, "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign", "clp"."NetworkNode", "clp"."note", "clp"."Apartment", "clp"."Building", "clp"."SettlementGeoSpatial", "cl"."name" AS "clname" FROM "CableLinePoint" AS "clp" LEFT JOIN "CableLine" AS "cl" ON "cl".id="clp"."CableLine" WHERE "clp"."NetworkNode"='.$networkNodeId;
	$res2 = PQuery($query);
    $result['NetworkNode']['CableLinePoints'] = $res2;
    unset($wr);
    $clpRows = $result['NetworkNode']['CableLinePoints']['rows'];
    for ($i = 0; $i < count($clpRows); $i++) {    	$wr['CableLinePointA'] = $clpRows[$i]['id'];
    	$wr['CableLinePointB'] = $clpRows[$i]['id'];
    	$res3 = FiberSplice_SELECT('', $wr, 1);
    	$result['NetworkNode']['CableLinePoints']['rows'][$i]['FiberSpliceCount'] = $res3['count'];
    }
	$res = getFiberSpliceOrganizerInfo(-1,-1,$networkNodeId,0);
	$result['NetworkNode']['FSO'] = $res;
	return $result;
}

/*function GetFreeNetworkBoxs($networkBox) {
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
}*/

?>