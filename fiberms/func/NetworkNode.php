<?php
require_once("backend/NetworkNode.php");
require_once("backend/NetworkBoxType.php");
require_once("backend/CableType.php");
require_once("backend/FS.php");

function NetworkNode_Check($name,$NetworkBox,$note,$OpenGIS,$SettlementGeoSpatial,$building,$apartment) {	$result = 1;
	/* здесь проверка */
	return $result;
}

function NetworkNode_Mod($id,$name,$NetworkBox,$note,$OpenGIS,$SettlementGeoSpatial,$building,$apartment) {	if (NetworkNode_Check($name,$NetworkBox,$note,$OpenGIS,$SettlementGeoSpatial,$building,$apartment) == 0) {		return 0;
	}
	$upd['name'] = $name;
    $upd['NetworkBox'] = $NetworkBox;
    $upd['note'] = $note;
    $upd['OpenGIS'] = $OpenGIS;
    $upd['SettlementGeoSpatial'] = $SettlementGeoSpatial;
    $upd['Building'] = $building;
    $upd['Apartment'] = $apartment;
    $wr['id'] = $id;
   	NetworkNode_UPDATE($upd,$wr);
   	return 1;
}

function NetworkNode_Add($name,$NetworkBox,$note,$OpenGIS,$SettlementGeoSpatial,$building,$apartment) {	if (NetworkNode_Check($name,$NetworkBox,$note,$OpenGIS,$SettlementGeoSpatial,$building,$apartment) == 0) {
		return 0;
	}
	$ins['name'] = $name;
	$ins['NetworkBox'] = $NetworkBox;
    $ins['note'] = $note;
    $ins['OpenGIS'] = $OpenGIS;
    $ins['SettlementGeoSpatial'] = $SettlementGeoSpatial;
    $ins['Building'] = $building;
    $ins['Apartment'] = $apartment;
    NetworkNode_INSERT($ins);
    return 1;
}

function GetNetworkNodeInfo($NetworkNodeId) {	$res = GetNetworkNode_NetworkBoxName($NetworkNodeId);
	$result['NetworkNode'] = $res;
	$wr['NetworkNode'] = $NetworkNodeId;
    $res2 = CableLinePoint_SELECT($wr);
    $result['NetworkNode']['CableLinePoints'] = $res2;
    unset($wr);
    $ClpRows = $result['NetworkNode']['CableLinePoints']['rows'];
    for ($i = 0; $i < count($ClpRows); $i++) {    	$wr['CableLinePointA'] = $ClpRows[$i]['id'];
    	$wr['CableLinePointB'] = $ClpRows[$i]['id'];
    	$res3 = FiberSplice_SELECT('',$wr,1);
    	$result['NetworkNode']['CableLinePoints']['rows'][$i]['FiberSpliceCount'] = $res3['count'];
    }
	return $result;
}

?>