<?php
function PQuery($query) {
	require "config.php";
	error_log($query);
	$result = pg_query($connection, $query) or die(pg_last_error($connection));
	return $result;
}

function GenWhere($wr) {	foreach ($wr as $field => $value) {
	 	if (strlen($where) > 0) $where .= ' AND ';
	 	$where .= ' "'.$field.'"='.$value;
	}
	$result = ' WHERE '.$where;
	return $result;
}

function GenInsert($ins) {	foreach ($ins as $field => $value)
	{
		if (strlen($fields) > 0) $fields .= ', ';
		if (strlen($values) > 0) $values .= ', ';
		$fields .= '"'.$field.'"';
		$values .= $value;
	}
	$result = ' ('.$fields.') VALUES ('.$values.')';
	return $result;
}

function GenUpdate($upd) {	foreach ($upd as $field => $value) {
    	if (strlen($set) > 0) $set .= ', ';
    	$set .= ' "'.$field.'"='.$value;
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
	 	$where .= ' "'.$field.'"='.$value;
	}
	$result = ' WHERE '.$where;
	return $result;
}
?>