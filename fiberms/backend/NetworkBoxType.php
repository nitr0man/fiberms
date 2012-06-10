<?php
require_once("functions.php");

function NetworkBox_SELECT($sort,$wr)
{
	$query = 'SELECT * FROM "NetworkBox"';
	if ($sort == 1)
		{
			$query .= ' ORDER BY "inventoryNumber"';
		}
 	if ($wr != '')
 		{
			 $query .= GenWhere($wr);
 		}
 	$result = PQuery($query);
 	return $result;
}

function NetworkBox_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkBox"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function NetworkBox_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkBox" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function NetworkBox_DELETE($wr)
{
	$query = 'DELETE FROM "NetworkBox"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}

function NetworkBoxType_SELECT($ob,$wr)
{
	$query = 'SELECT * FROM "NetworkBoxType"';
	if ($ob != '')
		{
			$query .= ' ORDER BY '.$ob;
		}
 	if ($wr != '')
 		{
			$query .= GenWhere($wr);
 		}
 	unset($field,$value);
 	$result = PQuery($query);
 	return $result;
}

function NetworkBoxType_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkBoxType"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	return $result;
}

function NetworkBoxType_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkBoxType" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	return $result;
}

function NetworkBoxType_DELETE($wr)
{
	$query = 'DELETE FROM "NetworkBoxType"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}
?>