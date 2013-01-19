<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function OpticalFiberSplice_SELECT($sort, $wr) {
	$query = 'SELECT * FROM "OpticalFiberSplice"';
	if ($wr != '') {
 		$query .= genWhere($wr);
 	}
	if ($sort == 1) {
		$query .= ' ORDER BY "fiber"';
	} else {
		$query .= ' ORDER BY "CableLine"';
	}
 	$result = PQuery($query);
 	return $result;
}

function OpticalFiberSplice_INSERT($ins) {
	$query = 'INSERT INTO "OpticalFiberSplice"';
	$query .= genInsert($ins);
	$query .= ' RETURNING id';
	$result = PQuery($query);
	loggingIs(2, 'OpticalFiberSplice', $ins, '');
	return $result;
}

function OpticalFiberSplice_UPDATE($upd, $wr) {
	$query = 'UPDATE "OpticalFiberSplice" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'OpticalFiberSplice', $upd, $wr['id']);
	return $result;
}

function OpticalFiberSplice_DELETE($wr, $sign = '=') {
	$query = 'DELETE FROM "OpticalFiberSplice"';
	$query .= genWhere($wr, $sign);
	$result = PQuery($query);
	loggingIs(3, 'OpticalFiberSplice', '', $wr['id']);
	return $result;
}
?>