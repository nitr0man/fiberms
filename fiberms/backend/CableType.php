<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function CableLine_SELECT($sort,$wr) {
	$query = 'SELECT * FROM "CableLine"';
	if ($wr != '') {
 		$query .= GenWhere($wr);
 	}
	if ($sort == 1) {
		$query .= ' ORDER BY "name"';
	} else {
		$query .= ' ORDER BY "name"';
	}
 	$result = PQuery($query);
 	return $result;
}

function CableLine_INSERT($ins) {
	$query = 'INSERT INTO "CableLine"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	LoggingIs(2,'CableLine',$ins,'');
	return $result;
}

function CableLine_UPDATE($upd,$wr) {
	$query = 'UPDATE "CableLine" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '') {
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'CableLine',$upd,$wr['id']);
	return $result;
}

function CableLine_DELETE($wr) {
	$query = 'DELETE FROM "CableLine"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'CableLine','',$wr['id']);
	return $result;
}

function CableType_SELECT($sort,$wr,$LinesPerPage = -1,$skip = -1) {
	$query = 'SELECT * FROM "CableType"';
	if ($wr != '') {
			$query .= GenWhere($wr);
 	}
	if ($sort == 1) {
		$query .= ' ORDER BY "marking"';
	} else {
		$query .= ' ORDER BY "marking"';
	}
	if (($LinesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$LinesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "CableType"';
		$res = PQuery($query2);
		$AllPages = $res['rows'][0]['count'];
	}
 	unset($field,$value);
 	$result = PQuery($query);
	$result['AllPages'] = $AllPages;
 	return $result;
}

function CableType_INSERT($ins) {
	$query = 'INSERT INTO "CableType"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	LoggingIs(2,'CableType',$ins,'');
	return $result;
}

function CableType_UPDATE($upd,$wr) {
	$query = 'UPDATE "CableType" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '') {
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'CableLine',$upd,$wr['id']);
	return $result;
}

function CableType_DELETE($wr) {
	$query = 'DELETE FROM "CableType"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'CableType','',$wr['id']);
	return $result;
}

function CableLinePoint_SELECT($wr) {
	$query = 'SELECT * FROM "CableLinePoint"';
 	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
 	$result = PQuery($query);
 	return $result;
}

function CableLinePoint_INSERT($ins) {
	$query = 'INSERT INTO "CableLinePoint"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	LoggingIs(2,'CableLinePoint',$ins,'');
	return $result;
}

function CableLinePoint_UPDATE($upd,$wr) {
	$query = 'UPDATE "CableLinePoint" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '') {
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'CableLinePoint',$upd,$wr['id']);
	return $result;
}

function CableLinePoint_DELETE($wr) {
	$query = 'DELETE FROM "CableLinePoint"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'CableTypePoint','',$wr['id']);
	return $result;
}

function GetCableLinePoint_NetworkNodeName($CableLineId) {	$query = 'SELECT "clp".id, "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign", "clp"."NetworkNode", "clp"."note",
       "clp"."Apartment", "clp"."Building", "clp"."SettlementGeoSpatial", "NN"."name"
	FROM "CableLinePoint" AS "clp"  LEFT JOIN "NetworkNode" AS "NN" ON "NN".id = "clp"."NetworkNode" WHERE "CableLine"='.$CableLineId;
  	$result = PQuery($query);
  	return $result;
}

function GetCableLineList($sort,$wr,$LinesPerPage = -1,$skip = -1) {
	$query = 'SELECT "cl".id,"cl"."OpenGIS","cl"."CableType","cl"."length","cl"."comment","cl"."name","ct"."marking" FROM "CableLine" AS "cl"';
	$query .= ' LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"';
	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
	if ($sort == 1)	{
		$query .= ' ORDER BY "name"';
	}
	if (($LinesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$LinesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "CableLine"';
		$res = PQuery($query2);
		$AllPages = $res['rows'][0]['count'];
	}
	$result = PQuery($query);
	$result['AllPages'] = $AllPages;
	return $result;
}

function GetFiberSpliceCount($CableLinePoint) {
	$query = 'SELECT COUNT(*) AS "count" FROM "FiberSplice" WHERE "CableLinePointA"='.$CableLinePoint.' OR "CableLinePointB"='.$CableLinePoint;
	$res = PQuery($query);
	$result = $res['rows'][0]['count'];
	return $result;
}
?>