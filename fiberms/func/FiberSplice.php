<?php
require_once("/backend/FS.php");
require_once("/backend/CableType.php");

/*function FiberSplice_Check() {
}*/

function FiberSplice_Mod($id,$CableLinePointA,$fiberA,$CableLinePointB,$fiberB,$FiberSpliceOrganizer,$IsA) {	if ($IsA == 0) {		$upd['CableLinePointA'] = $CableLinePointA;
   		$upd['fiberA'] = $fiberA;
	}
	else {		$upd['CableLinePointB'] = $CableLinePointB;
   		$upd['fiberB'] = $fiberB;
	}
	$upd['FiberSpliceOrganizer'] = $FiberSpliceOrganizer;
	$wr['id'] = $id;
	$res = FiberSplice_UPDATE($upd,$wr);
	return 1;
}

function FiberSplice_Add($CableLinePointA,$fiberA,$CableLinePointB,$fiberB,$FiberSpliceOrganizer) {	$ins['CableLinePointA'] = $CableLinePointA;
	$ins['fiberA'] = $fiberA;
	$ins['CableLinePointB'] = $CableLinePointB;
	$ins['fiberB'] = $fiberB;
	$ins['FiberSpliceOrganizer'] = $FiberSpliceOrganizer;
	$res = FiberSplice_INSERT($ins);
	return 1;
}

/*---------------*/
function GetFiberTable($NodeID)
{
	$cl_array = GetCableLineInfo($NodeID);
	$i = 0;
	$maxfiber = 0;
	if ($cl_array['count'] == 0)
	{
		// TODO: exit and return zero table
		return;
	}
	// Array of cableline points
	foreach ($cl_array['rows'] as $elem) {
		if ($maxfiber < $elem['fiber'])
			$maxfiber = $elem['fiber'];
		$CableLinePoints[$elem['clpid']] = $i++;
	}
	// Buiding array of fiber splices
	$fs_array = GetNodeFibers($NodeID);
	foreach ($fs_array['rows'] as $elem) {
		$ColA = $CableLinePoints[$elem['CableLinePointA']];
		$ColB = $CableLinePoints[$elem['CableLinePointB']];
		$RowA = $elem['fiberA'];
		$RowB = $elem['fiberB'];
		$SpliceArray[$ColA][$RowA] = array($elem['id'], $ColB, $RowB, 0);
		$SpliceArray[$ColB][$RowB] = array($elem['id'], $ColA, $RowA, 1);
	}
	$res['maxfiber'] = $maxfiber;
	$res['CableLinePoints'] = $CableLinePoints;
	$res['SpliceArray'] = $SpliceArray;
	$res['cl_array'] = $cl_array;
	return $res;
}

/*---------------*/

function GetFibers($CableLinePoint, $NetworkNodeId, $fiber)
{
	//$NetworkNodeId = $_GET['networknodeid'];
    $res = GetFiberTable($NetworkNodeId);
    $j = $res['CableLinePoints'][$CableLinePoint];
    for ($i = 1; $i <= $res['cl_array']['rows'][$j]['fiber']; $i++)
	{
		$arr = $res['SpliceArray'][$j][$i];
		if ((!isset($arr)) or ($i == $fiber))
		{
			$fibers[] = $i;
		}
	}
    return $fibers;
}

function FSOT_Check($marking,$manufacturer,$note) {	$result = 1;
	/* здесь проверка */
	return 1;
}

function FSOT_Mod($id,$marking,$manufacturer,$note) {	if (FSOT_Check($marking,$manufacturer,$note) == 0) {		return 0;
	}
	$upd['marking'] = $marking;
	$upd['manufacturer'] = $manufacturer;
	$upd['note'] = $note;
	$wr['id'] = $id;
	FSOT_UPDATE($upd,$wr);
	return 1;
}

function FSOT_Add($marking,$manufacturer,$note) {	if (FSOT_Check($marking,$manufacturer,$note) == 0) {
		return 0;
	}
	$ins['marking'] = $marking;
	$ins['manufacturer'] = $manufacturer;
	$ins['note'] = $note;
	FSOT_INSERT($ins);
	return 1;
}

function GetFSOTsInfo($sort) {	$res = FSOT_SELECT($sort,'');
	$result['FSOTs'] = $res;
	unset($wr);
	for ($i = 0; $i < $res['count']; $i++) {		$wr['FiberSpliceOrganizationType'] = $res['rows'][$i]['id'];
		$res2 = FSO_SELECT('',$wr);
		$result['FSOTs']['rows'][$i]['FSOCount'] = $res2['count'];
	}
	return $result;
}
?>