<?php
require_once("functions.php");

function CableLine_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "CableLine"';
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

function CableLine_INSERT($ins)
{
	$query = 'INSERT INTO "CableLine" (';
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

function CableLine_UPDATE($upd,$wr)
{
	$query = 'UPDATE "CableLine" SET ';
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

function CableLine_DELETE($wr)
{
	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}
	$query = 'DELETE FROM "CableLine" WHERE '.$where;
	$result = PQuery($query);
	return $result;
}

function CableType_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "CableType"';
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

function CableType_INSERT($ins)
{
	$query = 'INSERT INTO "CableType" (';
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

function CableType_UPDATE($upd,$wr)
{
	$query = 'UPDATE "CableType" SET ';
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

function CableType_DELETE($wr)
{
	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}
	$query = 'DELETE FROM "CableType" WHERE '.$where;
	$result = PQuery($query);
	return $result;
}
function CableLinePoint_SELECT($ob,$wr)
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
	$result['rows']=$rowarr;
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
}
?>