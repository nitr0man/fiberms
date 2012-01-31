<?php
require_once("functions.php");

function Users_SELECT($sel,$fr,$where)
{
	$query = 'SELECT '.$sel.' FROM "Users"';
	if ($fr != '')
		{
			$query = $query.' '.$fr;
		}
 	if ($where != '')
 		{
 			$query = $query.' WHERE '.$where;
 		}
 	$result = PQuery($query);
 	return $result;
}

function Users_INSERT($ins)
{
	$query = 'INSERT INTO "Users" '.$ins;
	$result = PQuery($query);
	return $result;
}

function Users_UPDATE($upd,$where)
{
	$query = 'UPDATE "Users" SET '.$upd;
	if ($where != '')
	{
		$query = $query.' WHERE '.$where;
	}
	$result = PQuery($query);
	return $result;
}

function Users_DELETE($where)
{
	$query = 'DELETE FROM "Users" WHERE '.$where;
	$result = PQuery($query);
	return $result;
}
?>