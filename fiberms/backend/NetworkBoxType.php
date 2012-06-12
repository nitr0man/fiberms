<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function NetworkBox_SELECT($sort,$wr)
{
	$query = 'SELECT * FROM "NetworkBox"';
	if ($sort == 1)	{
		$query .= ' ORDER BY "inventoryNumber"';
	}
 	if ($wr != '') {
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
	LoggingIs(2,'NetworkBox',$ins,'');
	return $result;
}

function NetworkBox_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkBox" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '') {
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'NetworkBox',$upd,$wr['id']);
	return $result;
}

function NetworkBox_DELETE($wr)
{
	$query = 'DELETE FROM "NetworkBox"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'NetworkBox','',$wr['id']);
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
	LoggingIs(2,'NetworkBoxType',$ins,'');
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
	LoggingIs(1,'NetworkBoxType',$upd,$wr['id']);
	return $result;
}

function NetworkBoxType_DELETE($wr)
{
	$query = 'DELETE FROM "NetworkBoxType"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'NetworkBoxType','',$wr['id']);
	return $result;
}

function GetNetworkBoxList($sort,$wr) {
	$query = 'SELECT "NB".id,"NB"."NetworkBoxType","NB"."inventoryNumber","NBT"."marking" FROM "NetworkBox" AS "NB"';
	$query .= ' LEFT JOIN "NetworkBoxType" AS "NBT" ON "NBT".id="NB"."NetworkBoxType"';
	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
	if ($sort == 1)	{
		$query .= ' ORDER BY "NB"."inventoryNumber" ';
	}		
	$result = PQuery($query);
	return $result;
}
?>