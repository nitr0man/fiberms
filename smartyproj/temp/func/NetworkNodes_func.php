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
 			/*foreach ($wr as $field => $value)
			 {
			 	if (strlen($where) > 0) $where .= ' AND ';
			 	$where .= ' "'.$field.'"='.$value;
			 }
			 $query .= ' WHERE '.$where;   */
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

function NetworkNode_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkNode"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function NetworkNode_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkNode" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
/*		foreach ($wr as $field => $value)
	    {
    		if (strlen($where) > 0) $where .= ' AND ';
    		$where .= ' "'.$field.'"='.$value;
	    }
		$query .= ' WHERE '.$where; */
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function NetworkNode_DELETE($wr)
{
/*	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}                           */
	$query = 'DELETE FROM "NetworkNode"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}
?>
