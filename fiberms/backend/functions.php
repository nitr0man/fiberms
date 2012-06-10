<?php
function PConnect($host,$db,$user,$pass) {
	$connection = pg_connect("host='".$host."' dbname='".$db."' user='".$user."' password='".$pass."'");
	return $connection;
}

function PQuery($query) {	
	require "config.php";	
	error_log($query);
	$res = pg_query($connection, $query) or $error = 1;
	if ($error == 1) {
		$result['error'] = pg_last_error($connection);/*pg_result_error_field($err, PGSQL_DIAG_SQLSTATE);*/
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
	 	$where .= ' "'.$field.'"=\''.pg_escape_string($value).'\'';
	}
	$result = ' WHERE '.$where;
	return $result;
}

function GenInsert($ins) {	foreach ($ins as $field => $value)
	{
		if (strlen($fields) > 0) $fields .= ', ';
		if (strlen($values) > 0) $values .= ', ';
		$fields .= '"'.$field.'"';
		$values .= "'".pg_escape_string($value)."'";
	}
	$result = ' ('.$fields.') VALUES ('.$values.')';
	return $result;
}

function GenUpdate($upd) {	foreach ($upd as $field => $value) {
    	if (strlen($set) > 0) $set .= ', ';
    	$set .= ' "'.$field.'"=\''.pg_escape_string($value).'\'';
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
?>