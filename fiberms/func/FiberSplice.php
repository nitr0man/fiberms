<?php
require_once("backend/FS.php");
require_once("backend/CableType.php");

/*function FiberSplice_Check() {
}*/

function FiberSplice_Mod($id, $CableLinePointA, $fiberA, $CableLinePointB, $fiberB, $FiberSpliceOrganizer, $IsA) {	if ($IsA == 0) {		$upd['CableLinePointA'] = $CableLinePointA;
   		$upd['fiberA'] = $fiberA;
	}
	else {		$upd['CableLinePointB'] = $CableLinePointB;
   		$upd['fiberB'] = $fiberB;
	}
	$upd['FiberSpliceOrganizer'] = $FiberSpliceOrganizer;
	$wr['id'] = $id;
	$res = FiberSplice_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function FiberSplice_Add($CableLinePointA, $fiberA, $CableLinePointB, $fiberB, $FiberSpliceOrganizer) {	$ins['CableLinePointA'] = $CableLinePointA;
	$ins['fiberA'] = $fiberA;
	$ins['CableLinePointB'] = $CableLinePointB;
	$ins['fiberB'] = $fiberB;
	$ins['FiberSpliceOrganizer'] = $FiberSpliceOrganizer;
	$res = FiberSplice_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

/*---------------*/
function getFiberTable($nodeID)
{
	$cl_array = getCableLineInfo($nodeID);
	$i = 0;
	$maxfiber = 0;
	if ($cl_array['count'] == 0) {
		// TODO: exit and return zero table
		return;
	}
	// Array of cableline points
	foreach ($cl_array['rows'] as $elem) {
		if ($maxfiber < $elem['fiber']) {
			$maxfiber = $elem['fiber'];
		}
		$CableLinePoints[$elem['clpid']] = $i++;
	}
	// Buiding array of fiber splices
	$fs_array = getNodeFibers($nodeID);
	if ($fs_array['count'] > 0) {
		foreach ($fs_array['rows'] as $elem) {
			$ColA = $CableLinePoints[$elem['CableLinePointA']];
			$ColB = $CableLinePoints[$elem['CableLinePointB']];
			$RowA = $elem['fiberA'];
			$RowB = $elem['fiberB'];
			$spliceArray[$ColA][$RowA] = array($elem['id'], $ColB, $RowB, 0);
			$spliceArray[$ColB][$RowB] = array($elem['id'], $ColA, $RowA, 1);
		}
	} else {
		$spliceArray = array();
	}
	$res['maxfiber'] = $maxfiber;
	$res['CableLinePoints'] = $CableLinePoints;
	$res['SpliceArray'] = $spliceArray;
	$res['cl_array'] = $cl_array;
	return $res;
}

/*---------------*/

function getFibers($CableLinePoint, $networkNodeId, $fiber)
{
    $res = getFiberTable($networkNodeId);
    $j = $res['CableLinePoints'][$CableLinePoint];
    for ($i = 1; $i <= $res['cl_array']['rows'][$j]['fiber']; $i++) {
		$arr = $res['SpliceArray'][$j][$i];
		if ((!isset($arr)) or ($i == $fiber)) {
			$fibers[] = $i;
		}
	}
    return $fibers;
}

function FSOT_Check($marking, $manufacturer, $note) {	$result = 1;
	/* здесь проверка */
	if ($marking == '') {
		$result = 0;
	}
	return $result;
}

function FSOT_Mod($id, $marking, $manufacturer, $note) {	if (FSOT_Check($marking, $manufacturer, $note) == 0) {		return 0;
	}
	$upd['marking'] = $marking;
	$upd['manufacturer'] = $manufacturer;
	$upd['note'] = $note;
	$wr['id'] = $id;
	$res = FSOT_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function FSOT_Add($marking, $manufacturer, $note) {	if (FSOT_Check($marking, $manufacturer, $note) == 0) {
		return 0;
	}
	$ins['marking'] = $marking;
	$ins['manufacturer'] = $manufacturer;
	$ins['note'] = $note;
	$res = FSOT_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function FSO_Check($FSOT) {
	$result = 1;
	/* здесь проверка */
	return $result;
}

function FSO_Mod($id, $FSOT) {
	if (FSO_Check($FSOT) == 0) {
		return 0;
	}
	$upd['FiberSpliceOrganizationType'] = $FSOT;
	$wr['id'] = $id;
	$res = FSO_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function FSO_Add($FSOT) {
	if (FSO_Check($FSOT) == 0) {
		return 0;
	}
	$ins['FiberSpliceOrganizationType'] = $FSOT;
	$res = FSO_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function getFSOTsInfo($sort, $linesPerPage = -1, $skip = -1) {	$res = FSOT_SELECT($sort, '', $linesPerPage, $skip);
	$result['FSOTs'] = $res;
	unset($wr);
	for ($i = 0; $i < $res['count']; $i++) {		$wr['FiberSpliceOrganizationType'] = $res['rows'][$i]['id'];
		$res2 = FSO_SELECT('', $wr);
		$result['FSOTs']['rows'][$i]['FSOCount'] = $res2['count'];
	}	
	return $result;
}
?>