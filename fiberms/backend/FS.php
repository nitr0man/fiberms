<?php
require_once("functions.php");

function FSO_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "FiberSpliceOrganizer"';
	if ($ob != '')
		{
			$query .= ' ORDER BY '.$ob;
		}
 	if ($wr != '')
 		{
			$query .= GenWhere($wr);
 		}
 	$result = PQuery($query);
 	return $result;
}

function FSOT_SELECT($sort,$wr)
{
	$query = 'SELECT * FROM "FiberSpliceOrganizerType"';
	if ($sort == 1)
		{
			$query .= ' ORDER BY "marking"';
		}
 	if ($wr != '')
 		{
			 $query .= GenWhere($wr);
 		}
 	$result = PQuery($query);
 	return $result;
}

function FSOT_INSERT($ins)
{
	$query = 'INSERT INTO "FiberSpliceOrganizerType"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function FSOT_UPDATE($upd,$wr)
{
	$query = 'UPDATE "FiberSpliceOrganizerType" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function FSOT_DELETE($wr)
{
	$query = 'DELETE FROM "FiberSpliceOrganizerType"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}

function FiberSplice_SELECT($ob,$wr,$OrAnd)
{
	$query = 'SELECT * FROM "FiberSplice"';
	if ($ob != '') {
			$query .= ' ORDER BY '.$ob;
	}
 	if ($wr != '') {
			$query .= GenWhereAndOr($wr,$OrAnd);
	}
 	$result = PQuery($query);
 	return $result;
}

function FiberSplice_INSERT($ins)
{
	$query = 'INSERT INTO "FiberSplice"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function FiberSplice_UPDATE($upd,$wr)
{
	$query = 'UPDATE "FiberSplice" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function FiberSplice_DELETE($wr)
{
	$query = 'DELETE FROM "FiberSplice"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}

function GetDirection($CableLinePoint,$NetworkNodeId) {	$query = 'SELECT * FROM "CableLinePoint" WHERE id='.$CableLinePoint;
	$res = PQuery($query);
	$CableLine = $res['rows'][0]['CableLine'];
	$query = 'SELECT * FROM "CableLinePoint" WHERE "CableLine"='.$CableLine.'AND "NetworkNode"!=NULL AND "NetworkNode"!='.$NetworkNodeId;
	$res = PQuery($query);
	if ($res['count'] == 1) {
		return $res['rows'][0]['NetworkNode'];
	}
	else {
		return '-';
	}
}

function FiberInfo($fiber)
{	$query = 'SELECT * FROM "FiberSplice" WHERE "fiberA"='.$fiber.' OR "fiberB"='.$fiber;
	$result = PQuery($query);
    return $result;
}

function GetCableLineInfo($NodeId)
{
	$query = 'SELECT "CableType"."tubeQuantity"*"CableType"."fiberPerTube" AS "fiber", "CableLinePoint".id AS "clpid", "CableLine"."name", "CableType"."marking", "CableLinePoint"."NetworkNode" FROM "NetworkNode"
		LEFT JOIN "CableLinePoint" ON "CableLinePoint"."NetworkNode"="NetworkNode"."id"
		LEFT JOIN "CableLine" ON "CableLine".id="CableLinePoint"."CableLine"
		LEFT JOIN "CableType" ON "CableType".id="CableLine"."CableType" WHERE "NetworkNode".id='.$NodeId;
	$result = PQuery($query);
	return $result;
}

function GetNodeFibers($NodeId)
{
	$query = 'SELECT * FROM "FiberSplice" WHERE
		"CableLinePointA" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeId.')
		OR "CableLinePointB" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeId.')';
	$result = PQuery($query);
	return $result;
}
?>