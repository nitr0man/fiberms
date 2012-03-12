<?php
require_once("functions.php");

function FSOT_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "FiberSpliceOrganizerType"';
	if ($ob != '')
		{
			$query .= ' ORDER BY '.$ob;
		}
 	if ($wr != '')
 		{
 			foreach ($wr as $field => $value)
			 {
			 	if (strlen($where) > 0) $where .= ' AND ';			 	$where .= ' "'.$field.'"='.$value;
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
	$result['rows']=$rowarr;
 	return $result;
}

function FSOT_INSERT($ins)
{
	$query = 'INSERT INTO "FiberSpliceOrganizerType" (';
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

function FSOT_UPDATE($upd,$wr)
{
	$query = 'UPDATE "FiberSpliceOrganizerType" SET ';
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

function FSOT_DELETE($wr)
{
	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}
	$query = 'DELETE FROM "FiberSpliceOrganizerType" WHERE '.$where;
	$result = PQuery($query);
	return $result;
}

function FiberSplice_SELECT($ob,$wr,$orand)
{
	$query = 'SELECT * FROM "FiberSplice"';
	if ($ob != '')
		{
			$query .= ' ORDER BY '.$ob;
		}
 	if ($wr != '')
 		{
 			foreach ($wr as $field => $value)
			 {

			 	if (strlen($where) > 0)
			 	{
			 		if ($orand==0)
			 		{
			 	  		$sl = 'AND';
					}
					elseif ($orand==1)
					{						$sl = 'OR';
					}
					$where .= ' '.$sl.' ';
				}
			 	$where .= ' "'.$field.'"='.$value;
			 }
			 $query .= ' WHERE '.$where;
 		}
 	unset($field,$value);
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

function FiberSplice_INSERT($ins)
{
	$query = 'INSERT INTO "FiberSplice" (';
	foreach ($ins as $field => $value)
	{		if (strlen($fields) > 0) $fields .= ', ';
		if (strlen($values) > 0) $values .= ', ';
		$fields .= '"'.$field.'"';
		$values .= $value;
	}
	unset($field,$value);
	$query .= $fields.') VALUES ('.$values.')';
	$result = PQuery($query);
	return $result;
}

function FiberSplice_UPDATE($upd,$wr)
{
	$query = 'UPDATE "FiberSplice" SET ';
    foreach ($upd as $field => $value)
    {
    	if (strlen($set) > 0) $set .= ', ';    	$set .= ' "'.$field.'"='.$value;
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

function FiberSplice_DELETE($wr)
{
	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}
	$query = 'DELETE FROM "FiberSplice" WHERE '.$where;
	$result = PQuery($query);
	return $result;
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
	$query = 'SELECT "CableType"."tubeQuantity"*"CableType"."fiberPerTube" AS "fiber", "CableLinePoint".id AS "clpid", "CableLine"."name" FROM "NetworkNode"
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
		"CableLinePointA" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeID.') 
		OR "CableLinePointB" in (SELECT id FROM "CableLinePoint" WHERE "NetworkNode" = '.$NodeID.')';
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
		$RowA = $f_elem['FiberA'];
		$RowB = $f_elem['FiberB'];
		$SpliceArray[$ColA][$RowA] = ($elem['id'], $ColB, $RowB);
		$SpliceArray[$ColB][$RowB] = ($elem['id'], $ColA, $RowA);
	}
	$res['maxfiber'] = $maxfiber;
	$res['CableLinePoints'] = $CableLinePoints;
	$res['SpliceArray'] = $SpliceArray;
	return $res;
}

/*---------------*/

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