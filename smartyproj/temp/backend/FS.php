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
	/*print_r($res);
	die();
 	while ($row = pg_fetch_array($res)) {
		$CableLine = $row['CableLine'];
	}*/
	$CableLine = $res['rows'][0]['CableLine'];
	$query = 'SELECT * FROM "CableLinePoint" WHERE "CableLine"='.$CableLine.'AND "NetworkNode"!=NULL AND "NetworkNode"!='.$NetworkNodeId;
	$res = PQuery($query);
	if ($res['count'] == 1) {
		return $res['rows'][0]['NetworkNode'];
	}
	else {
		return '-';
	}
	/*if (pg_num_rows($res) == 1) {		while ($row = pg_fetch_array($res)) {			return $row['NetworkNode'];
		}
	}
	else {		return '-';
	}*/
}

function FiberInfo($fiber)
{	$query = 'SELECT * FROM "FiberSplice" WHERE "fiberA"='.$fiber.' OR "fiberB"='.$fiber;
	$result = PQuery($query);
	/*$result['count'] = pg_num_rows($res);
	if (pg_num_rows($res) > 0)
	{
	 	while ($row = pg_fetch_array($res))
		{
			$rowarr[] = $row;
		}
		$result['rows'] = $rowarr;
	}*/
    return $result;
}

function GetCableLineInfo($NodeId)
{
	$query = 'SELECT "CableType"."tubeQuantity"*"CableType"."fiberPerTube" AS "fiber", "CableLinePoint".id AS "clpid", "CableLine"."name", "CableType"."marking", "CableLinePoint"."NetworkNode" FROM "NetworkNode"
		LEFT JOIN "CableLinePoint" ON "CableLinePoint"."NetworkNode"="NetworkNode"."id"
		LEFT JOIN "CableLine" ON "CableLine".id="CableLinePoint"."CableLine"
		LEFT JOIN "CableType" ON "CableType".id="CableLine"."CableType" WHERE "NetworkNode".id='.$NodeId;
	$result = PQuery($query);
	/*$result['count'] = pg_num_rows($res);
	while ($row = pg_fetch_array($res))
	{
		$rowarr[] = $row;
	}
	$result['rows'] = $rowarr;
	pg_free_result($res);*/
	return $result;
}

function GetNodeFibers($NodeId)
{
	$query = 'SELECT * FROM "FiberSplice" WHERE
		"CableLinePointA" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeId.')
		OR "CableLinePointB" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeId.')';
	$result = PQuery($query);
	/*$result['count'] = pg_num_rows($res);
	while ($row = pg_fetch_array($res))
	{
		$rowarr[] = $row;
	}
	$result['rows'] = $rowarr;
	pg_free_result($res);*/
	return $result;
}

/*function GetFSOTInfo($FSOTId) {
	$query = 
}*/

/*function CableLinePoint_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "CableLinePoint"';
	if ($ob != '')
		{
			$query .= ' ORDER BY '.$ob;
		}
 	if ($wr != '')
 		{
 			foreach ($wr as $field => $value)
			 {
			 	if (strlen($where) > 0) $where .= ' AND ';
			 	$where .= ' "'.$field.'"='.$value;
			 }
			 $query .= ' WHERE '.$where;
 		}
 	$res = PQuery($query);
 	$result['count'] = pg_num_rows($res);
 	$i = 0;
 	while ($row = pg_fetch_array($res))
	{
		$rowarr[$i++] = $row;
	}
	pg_free_result($res);
	$result['rows'] = $rowarr;
 	return $result;
}

function CableLinePoint_INSERT($ins)
{
	$query = 'INSERT INTO "CableLinePoint" (';
	foreach ($ins as $field => $value)
	{
		if (strlen($fields) > 0) $fields .= ', ';
		if (strlen($values) > 0) $values .= ', ';
		$fields .= '"'.$field.'"';
		$values .= $value;
	}
	unset($field,$value);
	$query .= $fields.') VALUES ('.$values.')';
	$result = PQuery($query);
	return $result;
}

function CableLinePoint_UPDATE($upd,$wr)
{
	$query = 'UPDATE "CableLinePoint" SET ';
    foreach ($upd as $field => $value)
    {
    	if (strlen($set) > 0) $set .= ', ';
    	$set .= ' "'.$field.'"='.$value;
    }
    $query .= $set;
    unset($field,$value);
	if ($wr != '')
	{
		foreach ($wr as $field => $value)
	    {
    		if (strlen($where) > 0) $where .= ' AND ';
    		$where .= ' "'.$field.'"='.$value;
	    }
		$query .= ' WHERE '.$where;
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function CableLinePoint_DELETE($wr)
{
	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}
	$query = 'DELETE FROM "CableLinePoint" WHERE '.$where;
	$result = PQuery($query);
	return $result;
} */
?>