<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function FSO_SELECT($ob, $wr, $linesPerPage = -1, $skip = -1) {
	$query = 'SELECT * FROM "FiberSpliceOrganizer"';
	if ($wr != '') {
		$query .= genWhere($wr);
 	}
	if ($ob != '') {
		$query .= ' ORDER BY '.$ob;
	} 	
	if (($linesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizer"';
		$res = PQuery($query2);
		$allPages = $res['rows'][0]['count'];
	}
 	$result = PQuery($query);
	$result['allPages'] = $allPages;
 	return $result;
}

function FSO_INSERT($ins) {
	$query = 'INSERT INTO "FiberSpliceOrganizer"';
	$query .= genInsert($ins);
	$result = PQuery($query);
	loggingIs(2, 'FiberSpliceOrganizer', $ins, '');
	return $result;
}

function FSO_UPDATE($upd, $wr) {
	$query = 'UPDATE "FiberSpliceOrganizer" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'FiberSpliceOrganizer', $upd, $wr['id']);
	return $result;
}

function FSOT_SELECT($sort, $wr, $linesPerPage = -1, $skip = -1) {
	$query = 'SELECT * FROM "FiberSpliceOrganizerType"';
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
		$query2 = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizerType"';
		$res = PQuery($query2);
		$allPages = $res['rows'][0]['count'];
	}
	$result = PQuery($query);
	$result['allPages'] = $allPages;
 	return $result;
}

function FSOT_INSERT($ins) {
	$query = 'INSERT INTO "FiberSpliceOrganizerType"';
	$query .= genInsert($ins);
	$result = PQuery($query);
	loggingIs(2, 'FiberSpliceOrganizerType', $ins, '');
	return $result;
}

function FSOT_UPDATE($upd, $wr) {
	$query = 'UPDATE "FiberSpliceOrganizerType" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'FiberSpliceOrganizerType', $upd, $wr['id']);
	return $result;
}

function FSOT_DELETE($wr) {
	$query = 'DELETE FROM "FiberSpliceOrganizerType"';
	$query .= genWhere($wr);
	$result = PQuery($query);
	loggingIs(3, 'FiberSpliceOrganizerType', '', $wr['id']);
	return $result;
}

function FiberSplice_SELECT($ob, $wr, $orAnd) {
	$query = 'SELECT * FROM "FiberSplice"';
	if ($ob != '') {
			$query .= ' ORDER BY '.$ob;
	}
 	if ($wr != '') {
			$query .= genWhereAndOr($wr, $orAnd);
	}
 	$result = PQuery($query);
 	return $result;
}

function FiberSplice_INSERT($ins) {
	$query = 'INSERT INTO "FiberSplice"';
	$query .= genInsert($ins);
	$result = PQuery($query);
	loggingIs(2, 'FiberSplice', $ins, '');
	return $result;
}

function FiberSplice_UPDATE($upd, $wr) {
	$query = 'UPDATE "FiberSplice" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'FiberSplice', $upd, $wr['id']);
	return $result;
}

function FiberSplice_DELETE($wr) {
	$query = 'DELETE FROM "FiberSplice"';
	$query .= genWhere($wr);
	$result = PQuery($query);
	loggingIs(3, 'FiberSplice', '', $wr['id']);
	return $result;
}

function getDirection($cableLinePoint, $networkNodeId) {	$query = 'SELECT * FROM "CableLinePoint" WHERE id='.$cableLinePoint;
	$res = PQuery($query);
	$cableLine = $res['rows'][0]['CableLine'];
	$query = 'SELECT * FROM "CableLinePoint" AS "clp" ';
	$query .= 'LEFT JOIN "NetworkNode" AS "NN" ON "NN".id="clp"."NetworkNode" ';
	$query .= 'WHERE "clp"."CableLine"='.$cableLine.'AND "clp"."NetworkNode" IS NOT NULL AND "clp"."NetworkNode"!='.$networkNodeId;
	$res = PQuery($query);
	if ($res['count'] == 1) {
		$result['name'] = $res['rows'][0]['name'];
		$result['NetworkNode'] = $res['rows'][0]['NetworkNode'];
	}
	else {
		$result['name'] = '-';
	}
	return $result;
}

function giberInfo($fiber) {	$query = 'SELECT * FROM "FiberSplice" WHERE "fiberA"='.$fiber.' OR "fiberB"='.$fiber;
	$result = PQuery($query);
    return $result;
}

function getCableLineInfo($nodeId) {
	$query = 'SELECT "CableType"."tubeQuantity"*"CableType"."fiberPerTube" AS "fiber", "CableLinePoint".id AS "clpid", "CableLine"."name", "CableType"."marking", "CableLinePoint"."NetworkNode", "CableType".id AS "ctid", "CableLine".id AS "clid", "CableType"."manufacturer" FROM "NetworkNode"
		LEFT JOIN "CableLinePoint" ON "CableLinePoint"."NetworkNode"="NetworkNode"."id"
		LEFT JOIN "CableLine" ON "CableLine".id="CableLinePoint"."CableLine"
		LEFT JOIN "CableType" ON "CableType".id="CableLine"."CableType" WHERE "NetworkNode".id='.$nodeId;
	$result = PQuery($query);
	return $result;
}

function getNodeFibers($nodeId) {
	$query = 'SELECT * FROM "FiberSplice" WHERE
		"CableLinePointA" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$nodeId.')
		OR "CableLinePointB" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$nodeId.')';
	$result = PQuery($query);
	return $result;
}

function getFiberSpliceCount_NetworkNode($networkNode = -1) {
	if ($networkNode != -1) {
		$wr = ' WHERE "NetworkNode"='.$networkNode;
	} else {
		$wr = '';
	}	
	$query = 'SELECT COUNT(id) AS "count" FROM "FiberSplice" WHERE "CableLinePointA" in (SELECT id FROM "CableLinePoint"'.$wr.') OR "CableLinePointB" in (SELECT id FROM "CableLinePoint"'.$wr.')';
	$res = PQuery($query);
	$result = $res['rows'][0]['count'];
	return $result;
}

function getFiberSpliceOrganizerInfo($linesPerPage = -1, $skip = -1, $networkNode = -1) {
	$query = 'SELECT DISTINCT "fso".id, "fso"."FiberSpliceOrganizationType" AS "FiberSpliceOrganizationTypeId", "fsot"."marking" AS "FiberSpliceOrganizationTypeMarking", "fsot"."manufacturer" AS "FiberSpliceOrganizationTypeManufacturer", "nn".id AS "NetworkNodeId", "nn"."name" AS "NetworkNodeName" ';
	$query .= 'FROM "FiberSpliceOrganizer" AS "fso" ';
	$query .= 'LEFT JOIN "FiberSplice" AS "fs" ON "fs"."FiberSpliceOrganizer"="fso".id ';
	$query .= 'LEFT JOIN "CableLinePoint" AS "clp" ON "clp".id="fs"."CableLinePointA" OR "clp".id="fs"."CableLinePointB" ';
	$query .= 'LEFT JOIN "NetworkNode" AS "nn" ON "nn".id="clp"."NetworkNode"';
	$query .= 'LEFT JOIN "FiberSpliceOrganizerType" AS "fsot" ON "fsot".id="fso"."FiberSpliceOrganizationType"';
	if ($networkNode != -1) {
		$query .= ' WHERE "nn".id='.$networkNode.' OR "nn".id IS NULL';
	}
	if (($linesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "FiberSpliceOrganizer"';
		$res = PQuery($query2);
		$allPages = $res['rows'][0]['count'];
	}
 	$result = PQuery($query);
	$result['allPages'] = $allPages;
	return $result;
}
?>