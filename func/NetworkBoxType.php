<?php
require_once("backend/NetworkBoxType.php");
require_once("backend/NetworkNode.php");

function NetworkBoxType_Check($marking, $manufacturer, $units, $width, $height, $length, $diameter) {
	/* ����� �������� */
	if (($marking == '') or (is_numeric($units) == false) or (is_numeric($width) == false) or (is_numeric($height) == false) or (is_numeric($length) == false) or (is_numeric($diameter) == false)) {
		$result = 0;
	}
	return $result;
}

function NetworkBoxType_Mod($id, $marking, $manufacturer, $units, $width, $height, $length, $diameter) {
	}
	$upd['marking'] = $marking;
	$upd['manufacturer'] = $manufacturer;
	$upd['units'] = $units;
	$upd['width'] = $width;
	$upd['height'] = $height;
	$upd['length'] = $length;
	$upd['diameter'] = $diameter;
	$wr['id'] = $id;
  	$res = NetworkBoxType_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
  	return 1;
}

function NetworkBoxType_Add($marking, $manufacturer, $units, $width, $height, $length, $diameter) {
		return 0;
	}
	$ins['manufacturer'] = $manufacturer;
	$ins['units'] = $units;
	$ins['width'] = $width;
	$ins['height'] = $height;
	$ins['length'] = $length;
	$ins['diameter'] = $diameter;
	$res = NetworkBoxType_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function getNetworkBoxTypeInfo($networkBoxTypeId) {
    $res = NetworkBoxType_SELECT('', $wr);
    $result['NetworkBoxType'] = $res;
    unset($wr);
    $wr['NetworkBoxType'] = $networkBoxTypeId;
    $res2 = NetworkBox_SELECT('', $wr);
    $result['NetworkBoxType']['NetworkBoxCount'] = $res2['count'];
    return $result;
}

function NetworkBox_Check($boxTypeId, $invNum) {
	/* ����� �������� */
	if (is_numeric($invNum) == false) {
		$result = 0;
	}
	return $result;
}

function NetworkBox_Mod($id, $boxTypeId, $invNum) {
	}
   	$upd['NetworkBoxType'] = $boxTypeId;
   	$wr['id'] = $id;
   	$res = NetworkBox_UPDATE($upd, $wr);
	if (isset($res['error'])) {
  		return $res;
  	}
   	return 1;
}

function NetworkBox_Add($boxTypeId, $invNum) {
		return 0;
	}
	$ins['NetworkBoxType'] = $boxTypeId;
	$ins['inventoryNumber'] = $invNum;
	$res = NetworkBox_INSERT($ins);
	if (isset($res['error'])) {
  		return $res;
  	}
	return 1;
}

function getNetworkBoxInfo($networkBoxId) {
   	$res = NetworkBox_SELECT(0, $wr);
   	$result['NetworkBox'] = $res;
   	unset($wr);
	$wr['id'] = $res['rows'][0]['NetworkBoxType'];
	$res2 = NetworkBoxType_SELECT('', $wr);
	$result['NetworkBox']['rows'][0]['NetworkBoxType'] = $res2['rows'][0];
	unset($wr);
	$wr['NetworkBox'] = $networkBoxId;
	$res3 = NetworkNode_SELECT('', '', $wr);
	$result['NetworkBox']['rows'][0]['NetworkNode'] = $res3['rows'][0];
	return $result;
}

?>