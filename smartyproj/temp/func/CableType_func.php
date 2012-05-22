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
 			/*foreach ($wr as $field => $value)
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

function CableLine_INSERT($ins)
{
	$query = 'INSERT INTO "CableLine"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function CableLine_UPDATE($upd,$wr)
{
	$query = 'UPDATE "CableLine" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		/*foreach ($wr as $field => $value)
	    {
    		if (strlen($where) > 0) $where .= ' AND ';
    		$where .= ' "'.$field.'"='.$value;
	    }
		$query .= ' WHERE '.$where;    */
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function CableLine_DELETE($wr)
{
	/*foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	} */
	$query = 'DELETE FROM "CableLine"';
	$query .= GenWhere($wr);
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
 			/*foreach ($wr as $field => $value)
			 {
			 	if (strlen($where) > 0) $where .= ' AND ';
			 	$where .= ' "'.$field.'"='.$value;
			 }
			 $query .= ' WHERE '.$where;*/
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

function CableType_INSERT($ins)
{
	$query = 'INSERT INTO "CableType"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function CableType_UPDATE($upd,$wr)
{
	$query = 'UPDATE "CableType" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		/*foreach ($wr as $field => $value)
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

function CableType_DELETE($wr)
{
/*	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}       */
	$query = 'DELETE FROM "CableType"';
	$query .= GenWhere($wr);
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
 			/*foreach ($wr as $field => $value)
			 {
			 	if (strlen($where) > 0) $where .= ' AND ';
			 	$where .= ' "'.$field.'"='.$value;
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

function CableLinePoint_INSERT($ins)
{
	$query = 'INSERT INTO "CableLinePoint"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function CableLinePoint_UPDATE($upd,$wr)
{
	$query = 'UPDATE "CableLinePoint" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		/*foreach ($wr as $field => $value)
	    {
    		if (strlen($where) > 0) $where .= ' AND ';
    		$where .= ' "'.$field.'"='.$value;
	    }
		$query .= ' WHERE '.$where;    */
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function CableLinePoint_DELETE($wr)
{
	/*foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}   */
	$query = 'DELETE FROM "CableLinePoint"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}
?>