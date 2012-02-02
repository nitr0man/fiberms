<?php
require_once("functions.php");

function NetworkNode_SELECT($sel,$fr,$where)
{
	$query = 'SELECT '.$sel.' FROM "NetworkNode"';
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

function NetworkBox_SELECT($sel,$fr,$where)
{
	$query = 'SELECT '.$sel.' FROM "NetworkBox"';
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

function NetworkNode_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkNode" '.$ins;
	$result = PQuery($query);
	return $result;
}

function NetworkNode_UPDATE($upd,$where)
{
	$query = 'UPDATE "NetworkNode" SET '.$upd;
	if ($where != '')
	{
		$query = $query.' WHERE '.$where;
	}
	$result = PQuery($query);
	return $result;
}

function NetworkNode_DELETE($where)
{
	$query = 'DELETE FROM "NetworkNode" WHERE '.$where;
	$result = PQuery($query);
	return $result;
}
?>
