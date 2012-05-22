<?php
require_once("functions.php");

function NetworkBox_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "NetworkBox"';
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

function NetworkBox_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkBox"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function NetworkBox_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkBox" SET ';
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

function NetworkBox_DELETE($wr)
{
/*	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}          */
	$query = 'DELETE FROM "NetworkBox"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}

function NetworkBoxType_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "NetworkBoxType"';
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

function NetworkBoxType_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkBoxType"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function NetworkBoxType_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkBoxType" SET ';
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

function NetworkBoxType_DELETE($wr)
{
/*	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}                    */
	$query = 'DELETE FROM "NetworkBoxType"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}
?>