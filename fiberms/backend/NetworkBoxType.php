<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function NetworkBox_SELECT($sort,$wr,$LinesPerPage = -1,$skip = -1) {
	$query = 'SELECT * FROM "NetworkBox"';
	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
	if ($sort == 1)	{
		$query .= ' ORDER BY "inventoryNumber"';
	} else {
		$query .= ' ORDER BY "inventoryNumber"';
	}
	if (($LinesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$LinesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "NetworkBox"';
		$res = PQuery($query2);
		$AllPages = $res['rows'][0]['count'];
	}
 	$result = PQuery($query);
	$result['AllPages'] = $AllPages;
 	return $result;
}

function NetworkBox_INSERT($ins) {
	$query = 'INSERT INTO "NetworkBox"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	LoggingIs(2,'NetworkBox',$ins,'');
	return $result;
}

function NetworkBox_UPDATE($upd,$wr) {
	$query = 'UPDATE "NetworkBox" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '') {
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'NetworkBox',$upd,$wr['id']);
	return $result;
}

function NetworkBox_DELETE($wr) {
	$query = 'DELETE FROM "NetworkBox"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'NetworkBox','',$wr['id']);
	return $result;
}

function NetworkBoxType_SELECT($ob,$wr,$LinesPerPage = -1,$skip = -1) {
	$query = 'SELECT * FROM "NetworkBoxType"';
	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
	if ($ob != '') {
		$query .= ' ORDER BY '.$ob;
	}
 	if (($LinesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$LinesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "NetworkBoxType"';
		$res = PQuery($query2);
		$AllPages = $res['rows'][0]['count'];
	} 	
 	$result = PQuery($query);
	$result['AllPages'] = $AllPages;
 	return $result;
}

function NetworkBoxType_INSERT($ins) {
	$query = 'INSERT INTO "NetworkBoxType"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	LoggingIs(2,'NetworkBoxType',$ins,'');
	return $result;
}

function NetworkBoxType_UPDATE($upd,$wr) {
	$query = 'UPDATE "NetworkBoxType" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '') {
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'NetworkBoxType',$upd,$wr['id']);
	return $result;
}

function NetworkBoxType_DELETE($wr) {
	$query = 'DELETE FROM "NetworkBoxType"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'NetworkBoxType','',$wr['id']);
	return $result;
}

function GetNetworkBoxList($sort,$wr,$LinesPerPage = -1,$skip = -1) {
	$query = 'SELECT "NB".id,"NB"."NetworkBoxType","NB"."inventoryNumber","NBT"."marking","NN"."name" AS "NNname","NN".id AS "NNid" FROM "NetworkBox" AS "NB"';
	$query .= ' LEFT JOIN "NetworkBoxType" AS "NBT" ON "NBT".id="NB"."NetworkBoxType"';
	$query .= ' LEFT JOIN "NetworkNode" AS "NN" ON "NN"."NetworkBox"="NB".id';
	$query .= ' ORDER BY "inventoryNumber"';
	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
	if ($sort == 1)	{
		$query .= ' ORDER BY "NB"."inventoryNumber" ';
	}
	if (($LinesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$LinesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "NetworkBox"';
		$res = PQuery($query2);
		$AllPages = $res['rows'][0]['count'];
	}	
	$result = PQuery($query);
	$result['AllPages'] = $AllPages;
	return $result;
}
?>