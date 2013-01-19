<?php
require_once("backend/FS.php");
require_once("backend/CableType.php");
require_once("backend/OpticalFiberJoin.php");
require_once("backend/OpticalFiber.php");
require_once("backend/OpticalFiberSplice.php");

/*function FiberSplice_Check() {
}*/

function FiberSplice_Mod($OFJ_id, $CableLine, $fiber, $FiberSpliceOrganizer) {
	$wr['id'] = $OFJ_id;
	$res = OpticalFiberJoin_SELECT( 1, $wr );
	$OpticalFiberSplice = $res['rows'][0]['OpticalFiberSplice'];
	unset($wr);
	$wr['fiber']     = $fiber;
	$wr['CableLine'] = $CableLine;
	$res = OpticalFiber_SELECT( 1, $wr );
	unset($wr);
	$upd['OpticalFiber'] = $res['rows'][0]['id'];
	$wr['id']            = $OFJ_id;
	$res = OpticalFiberJoin_UPDATE( $upd, $wr );
	if (isset($res['error'])) {
  		return $res;
  	}
	unset($wr);
	unset($upd);
	$wr['id']                    = $OpticalFiberSplice;
	$upd['FiberSpliceOrganizer'] = $FiberSpliceOrganizer;
	$res = OpticalFiberSplice_UPDATE( $upd, $wr );
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function FiberSplice_Add($CableLineA, $fiberA, $CableLineB, $fiberB, $FiberSpliceOrganizer, $NetworkNodeId) {
	$ins['NetworkNode']          = $NetworkNodeId;
	$ins['FiberSpliceOrganizer'] = $FiberSpliceOrganizer;
	$res = OpticalFiberSplice_INSERT( $ins );
	$OFS_id = $res['rows'][0]['id'];
	$res = addOpticalFiberJoin( $CableLineA, $fiberA, $OFS_id );
	if (isset($res['error'])) {
  		return $res;
  	}
	$res = addOpticalFiberJoin( $CableLineB, $fiberB, $OFS_id );	
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

/*---------------*/
function getFiberTable($nodeID) {
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
		$CableLines[$elem['clid']] = $i++;
	}
	// Buiding array of fiber splices
	$fs_array = getNodeFibers($nodeID);
	if ( $fs_array['count'] > 0 ) {
		$rows = $fs_array['rows'];
		$i = 0;
		while ( $i < count($rows) ) {
			if ( $rows[$i]['OpticalFiberSplice'] == $rows[$i + 1]['OpticalFiberSplice'] ) {
				$ClA = $CableLines[$rows[$i]['CableLine']];
				$ClB = $CableLines[$rows[$i + 1]['CableLine']];
				$fA = $rows[$i]['fiber'];
				$fB = $rows[$i + 1]['fiber'];
				$FSO = $rows[$i]['FiberSpliceOrganizer'];
				$spliceArray[$ClA][$fA] = array($ClB, $fB, $rows[$i + 1]['OFJ_id'], $FSO);
				$spliceArray[$ClB][$fB] = array($ClA, $fA, $rows[$i]['OFJ_id'], $FSO);
				$i = $i + 2;
			} else {
				$i++;
			}
		}
	} else {
		$spliceArray = array();
	}
	$res['maxfiber'] = $maxfiber;
	$res['CableLines'] = $CableLines;
	$res['SpliceArray'] = $spliceArray;
	$res['cl_array'] = $cl_array;
	return $res;
}

/*---------------*/

function getFibers($networkNodeId, $CableLine, $fiber) {
	$res = getFiberTable($networkNodeId);
	$j = $res['CableLines'][$CableLine];
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

function deleteSplice($OFJ_id) {
	$wr['id'] = $OFJ_id;
	$res = OpticalFiberJoin_SELECT( 1, $wr );
	$OFS_id = $res['rows'][0]['OpticalFiberSplice'];
	$query = 'DELETE FROM "OpticalFiberJoin" WHERE "OpticalFiberSplice"='.$OFS_id;
	$res = PQuery( $query );
	$query = 'DELETE FROM "OpticalFiberSplice" WHERE id='.$OFS_id;
	$res = PQuery( $query );
	return $res;
}
?>