<?php
require_once("functions.php");

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

function NetworkBoxType_SELECT($sel,$fr,$where)
{
	$query = 'SELECT '.$sel.' FROM "NetworkBoxType"';
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

function NetworkBoxType_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkBoxType" '.$ins;
	$result = PQuery($query);
	return $result;
}

function NetworkBoxType_UPDATE($upd,$where)
{
	$query = 'UPDATE "NetworkBoxType" SET '.$upd;
	if ($where != '')
	{
		$query = $query.' WHERE '.$where;
	}
	$result = PQuery($query);
	return $result;
}

function NetworkBoxType_DELETE($where)
{
	$query = 'DELETE FROM "NetworkBoxType" WHERE '.$where;
	$result = PQuery($query);
	return $result;
}
?>