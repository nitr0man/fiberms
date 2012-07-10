<?php
require_once("backend/CableType.php");

function CableType_Check($marking, $manufacturer, $tubeQuantity, $fiberPerTube, $tensileStrength, $diameter, $comment) {	$result = 1;
	/* здесь проверка */
	if (($marking == '') or (is_numeric($tubeQuantity) == false) or (is_numeric($fiberPerTube) == false) or (is_numeric($tensileStrength) == false) or (is_numeric($diameter) == false)) {
		$result = 0;
	}
	return $result;
}

function CableType_Mod($id, $marking, $manufacturer, $tubeQuantity, $fiberPerTube, $tensileStrength, $diameter, $comment) {	if (CableType_Check($marking, $manufacturer, $tubeQuantity, $fiberPerTube, $tensileStrength, $diameter, $comment) == 0) {		return 0;
	}
	$upd['marking'] = $marking;
	$upd['manufacturer'] = $manufacturer;
	$upd['tubeQuantity'] = $tubeQuantity;
	$upd['fiberPerTube'] = $fiberPerTube;
	$upd['tensileStrength'] = $tensileStrength;
	$upd['diameter'] = $diameter;
	$upd['comment'] = $comment;
	$wr['id'] = $id;
  	$res = CableType_UPDATE($upd, $wr);
  	if (isset($res['error'])) {  		return $res;
  	}
  	return 1;
}

function CableType_Add($marking, $manufacturer, $tubeQuantity, $fiberPerTube, $tensileStrength, $diameter, $comment) {	if (CableType_Check($marking, $manufacturer, $tubeQuantity, $fiberPerTube, $tensileStrength, $diameter, $comment) == 0) {
		return 0;
	}
	$ins['marking'] = $marking;
	$ins['manufacturer'] = $manufacturer;
	$ins['tubeQuantity'] = $tubeQuantity;
	$ins['fiberPerTube'] = $fiberPerTube;
	$ins['tensileStrength'] = $tensileStrength;
	$ins['diameter'] = $diameter;
	$ins['comment'] = $comment;
	$res = CableType_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function CableLine_Check($OpenGIS, $CableTypes, $length, $name, $comment) {	$result = 1;
	/* здесь проверка */
	if (is_numeric($length) == false) {
		$result = 0;
	}
	return $result;
}

function CableLine_Mod($id, $OpenGIS, $CableTypes, $length, $name, $comment) {	if (CableLine_Check($OpenGIS, $CableTypes, $length, $name, $comment) == 0) {		return 0;
<<<<<<< HEAD
	}
	if ($OpenGIS == '') {
		$upd['OpenGIS'] = "NULL";
	} else {
		$upd['OpenGIS'] = $OpenGIS;
=======
>>>>>>> ee883030f9528400cb5f81530d52c452930fb06b
	}
	$upd['CableType'] = $CableTypes;
	$upd['length'] = $length;
	$upd['comment'] = $comment;
	$upd['name'] = $name;
	$wr['id'] = $id;
	$res = CableLine_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function CableLine_Add($OpenGIS, $CableTypes, $length, $name, $comment) {	if (CableLine_Check($OpenGIS, $CableTypes, $length, $name, $comment) == 0) {
		return 0;
	}	if ($OpenGIS == '') {
		$upd['OpenGIS'] = "NULL";
	} else {
		$upd['OpenGIS'] = $OpenGIS;
	}
	$ins['CableType'] = $CableTypes;
	$ins['length'] = $length;
	$ins['comment'] = $comment;
	$ins['name'] = $name;
	$res = CableLine_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function CableLine_Info($cableLineId) {	$wr['id'] = $cableLineId;	$res = CableLine_SELECT(0, $wr);
	$result['CableLine'] = $res;
	$CableType = $result['CableLine']['rows'][0]['CableType'];
	$wr['id'] = $CableType;
	$res = CableType_SELECT(0, $wr);
	$result['CableLine']['rows'][0]['CableTypeMarking'] = $res['rows'][0]['marking'];
	$result['CableLine']['rows'][0]['CableTypeManufacturer'] = $res['rows'][0]['manufacturer'];
	$result['CableLine']['rows'][0]['CableTypeId'] = $res['rows'][0]['id'];
	$result['CableLinePoints'] = getCableLinePoint_NetworkNodeName($cableLineId);
	return $result;
}

function CableLinePoint_Check($OpenGIS, $CableLine, $meterSign, $networkNode, $note, $Apartment, $Building, $SettlementGeoSpatial) {	$result = 1;
	/* здесь проверка */
	if ((is_numeric($meterSign) == false)) {
		$result = 0;
	}
	return $result;
}

function CableLinePoint_Mod($id, $OpenGIS, $CableLine, $meterSign, $networkNode, $note, $Apartment, $Building, $SettlementGeoSpatial) {	if (CableLinePoint_Check($OpenGIS, $CableLine, $meterSign, $networkNode, $note, $Apartment, $Building, $SettlementGeoSpatial) == 0) {
		return 0;
	}
	if ($OpenGIS == '') {
		$OpenGIS = 'NULL';
	}
	$upd['OpenGIS'] = $OpenGIS;
	//$upd['CableLine'] = $CableLine;
	$upd['meterSign'] = $meterSign;
	//$upd['NetworkNode'] = $networkNode;
	$upd['note'] = $note;
	$upd['Apartment'] = "NULL";
	$upd['Building'] = "NULL";
	$upd['SettlementGeoSpatial'] = "NULL";
	$wr['id'] = $id;
	$res = CableLinePoint_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function CableLinePoint_Add($OpenGIS, $CableLine, $meterSign, $networkNode, $note, $Apartment, $Building, $SettlementGeoSpatial) {	if (CableLinePoint_Check($OpenGIS, $CableLine, $meterSign, $networkNode, $note, $Apartment, $Building, $SettlementGeoSpatial) == 0) {
		return 0;
	}
	if ($OpenGIS == '') {
		$OpenGIS = 'NULL';
	}
	$ins['OpenGIS'] = $OpenGIS;
	$ins['CableLine'] = $CableLine;
	$ins['meterSign'] = $meterSign;
	$ins['NetworkNode'] = $networkNode;
	$ins['note'] = $note;
	$ins['Apartment'] = "NULL";
	$ins['Building'] = "NULL";
	$ins['SettlementGeoSpatial'] = "NULL";
	$res = CableLinePoint_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

?>