<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function Users_SELECT($ob,$wr) {
	$query = 'SELECT * FROM "Users"';
	if ($ob != '') {
		$query .= ' ORDER BY '.$ob;
	}
 	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
 	$result = PQuery($query);
 	return $result;
}

function Users_INSERT($ins) {
	$query = 'INSERT INTO "Users"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function Users_UPDATE($upd,$wr) {
	$query = 'UPDATE "Users" SET ';
    $query .= GenUpdate($upd);
	if ($wr != ''){
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function Users_DELETE($wr) {
	$query = 'DELETE FROM "Users"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}
?>