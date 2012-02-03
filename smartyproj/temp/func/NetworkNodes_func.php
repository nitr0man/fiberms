<?php
require_once("functions.php");

function NetworkNode_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "NetworkNode"';
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

function NetworkNode_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkNode" (';
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

function NetworkNode_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkNode" SET ';
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

function NetworkNode_DELETE($wr)
{
	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}
	$query = 'DELETE FROM "NetworkNode" WHERE '.$where;
	$result = PQuery($query);
	return $result;
}
?>
