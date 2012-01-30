<?php
function PQuery($query)
{
	require "config.php";
	$result = pg_query($connection, $query) or die(pg_last_error($connection));
	return $result;
}
?>
