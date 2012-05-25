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
 			/*foreach ($wr as $field => $value)
			 {
			 	if (strlen($where) > 0) $where .= ' AND ';
			 	$where .= ' "'.$field.'"='.$value;
			 }
			 $query .= ' WHERE '.$where; */
			$query .= GenWhere($wr);
 		}
 	$res = PQuery($query);
 	$result['count'] = pg_num_rows($res);
 	$i = 0;
 	while ($row = pg_fetch_array($res))
	{
		$rowarr[$i++] = $row;
	}
	pg_free_result($res);
	$result['rows']=$rowarr;
 	return $result;
}

function FSOT_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "FiberSpliceOrganizerType"';
	if ($ob != '')
		{
			$query .= ' ORDER BY '.$ob;
		}
 	if ($wr != '')
 		{
/* 			foreach ($wr as $field => $value)
			 {
			 	if (strlen($where) > 0) $where .= ' AND ';			 	$where .= ' "'.$field.'"='.$value;
			 }
			 $query .= ' WHERE '.$where;*/
			 $query .= GenWhere($wr);
 		}
 	$res = PQuery($query);
 	$result['count'] = pg_num_rows($res);
 	$i = 0;
 	while ($row = pg_fetch_array($res))
	{
		$rowarr[$i++] = $row;
	}
	pg_free_result($res);
	$result['rows']=$rowarr;
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
/*		foreach ($wr as $field => $value)
	    {
    		if (strlen($where) > 0) $where .= ' AND ';
    		$where .= ' "'.$field.'"='.$value;
	    }
		$query .= ' WHERE '.$where;   */
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function FSOT_DELETE($wr)
{
/*	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}              */
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
 	$res = PQuery($query);
 	$result['count'] = pg_num_rows($res);
 	$i = 0;
 	while ($row = pg_fetch_array($res))	{
		$rowarr[$i++] = $row;
	}
	pg_free_result($res);
	$result['rows']=$rowarr;
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
/*		foreach ($wr as $field => $value)
	    {
    		if (strlen($where) > 0) $where .= ' AND ';
    		$where .= ' "'.$field.'"='.$value;
	    }
		$query .= ' WHERE '.$where;*/
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function FiberSplice_DELETE($wr)
{
/*	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}             */
	$query = 'DELETE FROM "FiberSplice"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}

function GetDirection($CableLinePoint,$NetworkNodeId) {	$query = 'SELECT * FROM "CableLinePoint" WHERE id='.$CableLinePoint;
	$res = PQuery($query);
 	while ($row = pg_fetch_array($res)) {
		$CableLine = $row['CableLine'];
	}
	$query = 'SELECT * FROM "CableLinePoint" WHERE "CableLine"='.$CableLine.'AND "NetworkNode"!=NULL AND "NetworkNode"!='.$NetworkNodeId;
	$res = PQuery($query);
	if (pg_num_rows($res) == 1) {		while ($row = pg_fetch_array($res)) {			return $row['NetworkNode'];
		}
	}
	else {		return '-';
	}
}

function FiberInfo($fiber)
{	$query = 'SELECT * FROM "FiberSplice" WHERE "fiberA"='.$fiber.' OR "fiberB"='.$fiber;
	$res = PQuery($query);
	$result['count'] = pg_num_rows($res);
	if (pg_num_rows($res) > 0)
	{
	 	while ($row = pg_fetch_array($res))
		{
			$rowarr[] = $row;
		}
		$result['rows'] = $rowarr;
	}
    return $result;
}

function GetCableLineInfo($NodeId)
{
	$query = 'SELECT "CableType"."tubeQuantity"*"CableType"."fiberPerTube" AS "fiber", "CableLinePoint".id AS "clpid", "CableLine"."name", "CableType"."marking", "CableLinePoint"."NetworkNode" FROM "NetworkNode"
		LEFT JOIN "CableLinePoint" ON "CableLinePoint"."NetworkNode"="NetworkNode"."id"
		LEFT JOIN "CableLine" ON "CableLine".id="CableLinePoint"."CableLine"
		LEFT JOIN "CableType" ON "CableType".id="CableLine"."CableType" WHERE "NetworkNode".id='.$NodeId;
	$res = PQuery($query);
	$result['count'] = pg_num_rows($res);
	while ($row = pg_fetch_array($res))
	{
		$rowarr[] = $row;
	}
	$result['rows'] = $rowarr;
	pg_free_result($res);
	return $result;
}

function GetNodeFibers($NodeId)
{
	$query = 'SELECT * FROM "FiberSplice" WHERE
		"CableLinePointA" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeId.')
		OR "CableLinePointB" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeId.')';
	$res = PQuery($query);
	$result['count'] = pg_num_rows($res);
	while ($row = pg_fetch_array($res))
	{
		$rowarr[] = $row;
	}
	$result['rows'] = $rowarr;
	pg_free_result($res);
	return $result;
}

/*---------------*/
function GetFiberTable($NodeID)
{
	$cl_array = GetCableLineInfo($NodeID);
	$i = 0;
	$maxfiber = 0;
	if ($cl_array['count'] == 0)
	{
		// TODO: exit and return zero table
		return;
	}
	// Array of cableline points
	foreach ($cl_array['rows'] as $elem) {
		if ($maxfiber < $elem['fiber'])
			$maxfiber = $elem['fiber'];
		$CableLinePoints[$elem['clpid']] = $i++;
	}
	// Buiding array of fiber splices
	$fs_array = GetNodeFibers($NodeID);
	foreach ($fs_array['rows'] as $elem) {
		$ColA = $CableLinePoints[$elem['CableLinePointA']];
		$ColB = $CableLinePoints[$elem['CableLinePointB']];
		$RowA = $elem['fiberA'];
		$RowB = $elem['fiberB'];
		$SpliceArray[$ColA][$RowA] = array($elem['id'], $ColB, $RowB, 0);
		$SpliceArray[$ColB][$RowB] = array($elem['id'], $ColA, $RowA, 1);
	}
	$res['maxfiber'] = $maxfiber;
	$res['CableLinePoints'] = $CableLinePoints;
	$res['SpliceArray'] = $SpliceArray;
	$res['cl_array'] = $cl_array;
	return $res;
}

/*---------------*/

function GetFibers($CableLinePoint, $NetworkNodeId, $fiber)
{
	//$NetworkNodeId = $_GET['networknodeid'];
    $res = GetFiberTable($NetworkNodeId);
    $j = $res['CableLinePoints'][$CableLinePoint];
    for ($i = 1; $i <= $res['cl_array']['rows'][$j]['fiber']; $i++)
	{
		$arr = $res['SpliceArray'][$j][$i];
		if ((!isset($arr)) or ($i == $fiber))
		{
			$fibers[] = $i;
		}
	}
    return $fibers;
}

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