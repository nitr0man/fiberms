<?php
require_once('config.php');
function PConnect($host,$db,$user,$pass) {
	$connection = pg_connect("host='".$host."' dbname='".$db."' user='".$user."' password='".$pass."'");
	return $connection;
}

function PQuery($query) {	
	require "config.php";	
	//error_log($query);
	$res = pg_query($connection, $query) or $error = 1;
	if ($error == 1) {
		$result['error'] = pg_last_error($connection);
		return $result;
	}
	$result['count'] = pg_num_rows($res);
 	$i = 0;
 	while ($row = pg_fetch_array($res))	{
		$rowarr[$i++] = $row;
	}
	pg_free_result($res);
	$result['rows']=$rowarr;
	return $result;
}

function GenWhere($wr) {	foreach ($wr as $field => $value) {
	 	if (strlen($where) > 0) $where .= ' AND ';
		if ($value != 'NULL') {
			$where .= ' "'.$field.'"=\''.pg_escape_string($value).'\'';
		} else {
			$where .= ' "'.$field.'" IS '.pg_escape_string($value).'';
		}
	}
	$result = ' WHERE '.$where;
	return $result;
}

function GenInsert($ins) {	foreach ($ins as $field => $value)
	{
		if (strlen($fields) > 0) $fields .= ', ';
		if (strlen($values) > 0) $values .= ', ';
		$fields .= '"'.$field.'"';
		if ($value != 'NULL') {
			$values .= "'".pg_escape_string($value)."'";
		} else {
			$values .= "".pg_escape_string($value)."";
		}
	}
	$result = ' ('.$fields.') VALUES ('.$values.')';
	return $result;
}

function GenUpdate($upd) {	foreach ($upd as $field => $value) {
    	if (strlen($set) > 0) $set .= ', ';
		if ($value != 'NULL') {
			$set .= ' "'.$field.'"=\''.pg_escape_string($value).'\'';
		} else {
			$set .= ' "'.$field.'"='.pg_escape_string($value);
		}
    }
    return $set;
}

function GenWhereAndOr($wr,$OrAnd) {	foreach ($wr as $field => $value) {
	 	if (strlen($where) > 0) {
	 		if ($OrAnd==0) {
	 	  		$sl = 'AND';
			}
			elseif ($OrAnd==1) {
				$sl = 'OR';
			}
			$where .= ' '.$sl.' ';
		}
	 	$where .= ' "'.$field.'"=\''.pg_escape_string($value).'\'';
	}
	$result = ' WHERE '.$where;
	return $result;
}

function GetCurrUserInfo() {
	global $_SESSION;
	$login = $_SESSION['user'];
	$query = 'SELECT * FROM "Users" WHERE "username"=\''.$login.'\'';
	$result = PQuery($query);
	return $result;
}

function GetStat() {
	$query = 'SELECT COUNT(*) AS "count" FROM "Users"';
	$res = PQuery($query);
	$result['Users']['All'] = $res['rows'][0]['count'];
	$query = 'SELECT COUNT(*) AS "count" FROM "Users" WHERE "class"=\'1\'';
	$res = PQuery($query);
	$result['Users']['Admin'] = $res['rows'][0]['count'];
	$query = 'SELECT id FROM "NetworkNode"';
	$res_nodes = PQuery($query);
	$res_nodes_rows = $res_nodes['rows'];
	$result['FiberSplice']['NetworkNodesCount'] = $res_nodes['count'];
	$FiberSpliceCount = 0;
	for($i = 0; $i < $res_nodes['count']; $i++) {
		$query = 'SELECT id FROM "CableLinePoint" WHERE "NetworkNode"='.$res_nodes_rows[$i]['id'];
		$res_clp = PQuery($query);
		$res_clp_rows = $res_clp['rows'];
		for ($j = 0; $j < $res_clp['count']; $j++) {
			$query = 'SELECT COUNT(*) AS "count" FROM "FiberSplice" WHERE "CableLinePointA"='.$res_clp_rows[$j]['id'].' OR "CableLinePointB"='.$res_clp_rows[$j]['id'];
			$res_fs = PQuery($query);
			if ($res_fs['rows'][0]['count'] > 0) {
				$FiberSpliceCount += $res_fs['rows'][0]['count'];
			}			
		}
	}
	$result['FiberSplice']['FiberSpliceCount'] = $FiberSpliceCount;
	$query = 'SELECT COUNT(*) AS "count" FROM "CableLinePoint"';
	$res = PQuery($query);
	$result['CableLinePoint']['Count'] = $res['rows'][0]['count'];
	$query = 'SELECT COUNT(*) AS "count" FROM "NetworkNode"';
	$res = PQuery($query);
	$result['NetworkNode']['Count'] = $res['rows'][0]['count'];
	$query = 'SELECT COUNT(*) AS "count" FROM "NetworkBox"';
	$res = PQuery($query);
	$result['NetworkBox']['Count'] = $res['rows'][0]['count'];
	return $result;
}
?>