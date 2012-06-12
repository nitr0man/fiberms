<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function NetworkNode_SELECT($sort,$FSort,$wr)
{
	$query = 'SELECT * FROM "NetworkNode"';
	if ($sort == 1)	{
		$query .= ' ORDER BY "'.$FSort.'"';
	}
 	if ($wr != '') {
			$query .= GenWhere($wr);
 		}
 	$result = PQuery($query);
 	return $result;
}

function NetworkNode_INSERT($ins)
{
	$query = 'INSERT INTO "NetworkNode"';
	$query .= GenInsert($ins);
	$result = PQuery($query);
	LoggingIs(2,'NetworkNode',$ins,'');
	return $result;
}

function NetworkNode_UPDATE($upd,$wr)
{
	$query = 'UPDATE "NetworkNode" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '')
	{
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'NetworkNode',$upd,$wr['id']);
	return $result;
}

function NetworkNode_DELETE($wr)
{
	$query = 'DELETE FROM "NetworkNode"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	LoggingIs(3,'NetworkNode','',$wr['id']);
	return $result;
}

function GetNetworkNode_NetworkBoxName($NetworkNodeId) {	$query = 'SELECT "NN".id, "NN"."OpenGIS", "NN"."name", "NN"."NetworkBox", "NN"."note", "NN"."SettlementGeoSpatial",
        "NN"."Building", "NN"."Apartment", "NB"."inventoryNumber"
  		FROM "NetworkNode" AS "NN"
		LEFT JOIN "NetworkBox" AS "NB" ON "NB".id="NN"."NetworkBox" WHERE "NN".id='.$NetworkNodeId;
	$result = PQuery($query);
	return $result;
}
function GetNetworkNodeList_NetworkBoxName($sort,$FSort,$wr) {
	$query = 'SELECT "NN".id, "NN"."OpenGIS", "NN"."name", "NN"."NetworkBox", "NN"."note", "NN"."SettlementGeoSpatial",
        "NN"."Building", "NN"."Apartment", "NB"."inventoryNumber"
  		FROM "NetworkNode" AS "NN"';
	$query .= ' LEFT JOIN "NetworkBox" AS "NB" ON "NB".id="NN"."NetworkBox"';
	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
	if ($sort == 1)	{
		$query .= ' ORDER BY "NN"."'.$FSort.'"';
	}
	$result = PQuery($query);
	return $result;
}
?>
