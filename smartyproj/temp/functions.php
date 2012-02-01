<?php
function PQuery($query)
{
	require "config.php";
	error_log($query);
	$result = pg_query($connection, $query) or die(pg_last_error($connection));
	return $result;
}
?>