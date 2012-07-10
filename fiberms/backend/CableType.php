<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function CableLine_SELECT($sort, $wr) {
	$query = 'SELECT * FROM "CableLine"';
	if ($wr != '') {
 		$query .= genWhere($wr);
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
	$query .= genInsert($ins);
	$result = PQuery($query);
	loggingIs(2, 'CableLine', $ins, '');
	return $result;
}

function CableLine_UPDATE($upd, $wr) {
	$query = 'UPDATE "CableLine" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'CableLine', $upd, $wr['id']);
	return $result;
}

function CableLine_DELETE($wr) {
	$query = 'DELETE FROM "CableLine"';
	$query .= genWhere($wr);
	$result = PQuery($query);
	loggingIs(3, 'CableLine', '', $wr['id']);
	return $result;
}

function CableType_SELECT($sort, $wr, $linesPerPage = -1, $skip = -1) {
	$query = 'SELECT * FROM "CableType"';
	if ($wr != '') {
			$query .= genWhere($wr);
 	}
	if ($sort == 1) {
		$query .= ' ORDER BY "marking"';
	} else {
		$query .= ' ORDER BY "marking"';
	}
	if (($linesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "CableType"';
		$res = PQuery($query2);
		$allPages = $res['rows'][0]['count'];
	}
 	unset($field, $value);
 	$result = PQuery($query);
	$result['allPages'] = $allPages;
 	return $result;
}

function CableType_INSERT($ins) {
	$query = 'INSERT INTO "CableType"';
	$query .= genInsert($ins);
	$result = PQuery($query);
	loggingIs(2, 'CableType', $ins, '');
	return $result;
}

function CableType_UPDATE($upd, $wr) {
	$query = 'UPDATE "CableType" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'CableLine', $upd, $wr['id']);
	return $result;
}

function CableType_DELETE($wr) {
	$query = 'DELETE FROM "CableType"';
	$query .= genWhere($wr);
	$result = PQuery($query);
	loggingIs(3, 'CableType', '', $wr['id']);
	return $result;
}

function CableLinePoint_SELECT($wr) {
	$query = 'SELECT * FROM "CableLinePoint"';
 	if ($wr != '') {
		$query .= genWhere($wr);
 	}
 	$result = PQuery($query);
 	return $result;
}

function CableLinePoint_INSERT($ins) {
	$query = 'INSERT INTO "CableLinePoint"';
	$query .= genInsert($ins);
	$result = PQuery($query);
	loggingIs(2, 'CableLinePoint', $ins, '');
	return $result;
}

function CableLinePoint_UPDATE($upd, $wr) {
	$query = 'UPDATE "CableLinePoint" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'CableLinePoint', $upd, $wr['id']);
	return $result;
}

function CableLinePoint_DELETE($wr) {
	$query = 'DELETE FROM "CableLinePoint"';
	$query .= genWhere($wr);
	$result = PQuery($query);
	loggingIs(3, 'CableTypePoint', '', $wr['id']);
	return $result;
}

function getCableLinePoint_NetworkNodeName($cableLineId) {	$query = 'SELECT "clp".id, "clp"."OpenGIS", "clp"."CableLine", "clp"."meterSign", "clp"."NetworkNode", "clp"."note", 
       "clp"."Apartment", "clp"."Building", "clp"."SettlementGeoSpatial", "NN"."name"
	FROM "CableLinePoint" AS "clp"  LEFT JOIN "NetworkNode" AS "NN" ON "NN".id = "clp"."NetworkNode" WHERE "CableLine"='.$cableLineId.' ORDER BY "clp"."meterSign"';
  	$result = PQuery($query);
  	return $result;
}

function getCableLineList($sort, $wr, $linesPerPage = -1, $skip = -1) {
	$query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", "cl"."length", "cl"."comment", "cl"."name", "ct"."marking", "ct"."manufacturer" FROM "CableLine" AS "cl"';
	$query .= ' LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"';
	if ($wr != '') {
		$query .= genWhere($wr);
 	}
	if ($sort == 1)	{
		$query .= ' ORDER BY "name"';
	}
	if (($linesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "CableLine"';
		$res = PQuery($query2);
		$allPages = $res['rows'][0]['count'];
	}
	$result = PQuery($query);
	$result['allPages'] = $allPages;
	return $result;
}

function getFiberSpliceCount($CableLinePoint) {
	$query = 'SELECT COUNT(*) AS "count" FROM "FiberSplice" WHERE "CableLinePointA"='.$CableLinePoint.' OR "CableLinePointB"='.$CableLinePoint;
	$res = PQuery($query);
	$result = $res['rows'][0]['count'];
<<<<<<< HEAD
	return $result;
}

function getCopperCableLines() {
	$query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", "cl".length, "cl".comment, "cl".name, "ct"."fiberPerTube"
			  FROM "CableLine" AS "cl"
			  LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"
			  WHERE "ct"."fiberPerTube"=0 AND "OpenGIS" IS NOT NULL';
	$result = PQuery($query);
	return $result;
}

function getNormalCableLines() {
	$query = 'SELECT "cl".id, "cl"."OpenGIS", "cl"."CableType", "cl".length, "cl".comment, "cl".name, "ct"."fiberPerTube"
			  FROM "CableLine" AS "cl"
			  LEFT JOIN "CableType" AS "ct" ON "ct".id="cl"."CableType"
			  WHERE "ct"."fiberPerTube"!=0 AND "OpenGIS" IS NOT NULL';
	$result = PQuery($query);
=======
>>>>>>> ee883030f9528400cb5f81530d52c452930fb06b
	return $result;
}
?>