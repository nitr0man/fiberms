<?php

require_once("auth.php");
require_once("backend/NetworkNode.php");
require_once("backend/CableType.php");
require_once("design_func.php");

header('charset=utf-8');

function die_hdr($text) {
    header('Content-Type: text/html; charset=utf-8');
    die($text);

}

if (!isset($_GET['format'])) {
    die_hdr('Не выбран формат экспорта!');
}

if (!isset($_GET[ 'data' ])) {
    die_hdr('Не выбраны объекты!');
}

$res = ['count' => 0];
$fields = array();

if ($_GET[ 'data' ] == 'nodes') {
    $fields = ['id' => 'id', 'name' => 'name', 'lon' => 'longitude', 'lat' => 'lattitude', 'fiberSpliceCount' => 'fiberSpliceCount', 'place' => 'place', 'NBTmarking' => 'marking', 'note' => 'note'];
    $res = getNetworkNodeList_NetworkBoxName('name', '');
    $i = -1;
    while (++$i < $res['count']) {
	if (preg_match('/\(([0-9\.]+)\,([0-9\.]+)\)/', $res['rows'][$i]['OpenGIS'], $matches)) {
	    $res['rows'][$i]['lon'] = $matches[1];
	    $res['rows'][$i]['lat'] = $matches[2];
	} else {
	    $res['rows'][$i]['lon'] = '';
	    $res['rows'][$i]['lat'] = '';
	}
	$res['rows'][$i]['place'] = str_replace([';', '"'], [',', '\''], $res['rows'][$i]['place']);
	$res['rows'][$i]['note'] = str_replace([';', '"'], [',', '\''], $res['rows'][$i]['note']);
    }
}
elseif ($_GET[ 'data' ] == 'lines') {
    $fields = ['id' => 'id', 'name' => 'name', 'coords' => 'coordinates', 'fibers' => 'fibers', 'marking' => 'marking', 'manufacturer' => 'manufacturer', 'length' => 'length', 'comment' => 'comment'];
    $res = getCableLineList(1, '');
    $i = -1;
    while (++$i < $res['count']) {
	$coords = '';
	$clp = getCableLinePoint_NetworkNodeName($res['rows'][$i]['id']);
	if ($clp['count']) {
	    foreach ($clp['rows'] as $point) {
		if (preg_match('/\(([0-9\.]+)\,([0-9\.]+)\)/', $point['OpenGIS'], $matches)) {
		    $coords .= $matches[1] . ',' . $matches[2] . ',0 ';
		} elseif (preg_match('/\(([0-9\.]+)\,([0-9\.]+)\)/', $point['NNOpenGIS'], $matches)) {
		    $coords .= $matches[1] . ',' . $matches[2] . ',0 ';
		}
	    }
	}
	$res['rows'][$i]['coords'] = trim($coords);
	$res['rows'][$i]['comment'] = str_replace([';', '"'], [',', '\''], $res['rows'][$i]['comment']);
    }
}

if (!$res['count']) {
    die_hdr('Не найдены объекты!');
} else {
    if ($_GET[ 'format' ] == 'csv') {
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=export.csv');
	print(gen_csv($res['rows'], $fields, ';'));
    } else
	die_hdr('Неверный формат экспорта!');
}

?>
