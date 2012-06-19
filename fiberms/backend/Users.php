<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function Users_SELECT($ob, $wr) {
	$query = 'SELECT * FROM "Users"';
	if ($ob != '') {
		$query .= ' ORDER BY '.$ob;
	}
 	if ($wr != '') {
		$query .= genWhere($wr);
 	}
 	$result = PQuery($query);
 	return $result;
}

function Users_INSERT($ins) {
	$query = 'INSERT INTO "Users"';
	$query .= genInsert($ins);
	$result = PQuery($query);
	return $result;
}

function Users_UPDATE($upd, $wr) {
	$query = 'UPDATE "Users" SET ';
    $query .= genUpdate($upd);
	if ($wr != ''){
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	return $result;
}

function Users_DELETE($wr) {
	$query = 'DELETE FROM "Users"';
	$query .= genWhere($wr);
	$result = PQuery($query);
	return $result;
}
?>