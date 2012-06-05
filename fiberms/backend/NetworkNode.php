<?php
require_once("functions.php");

function NetworkNode_SELECT($sort,$FSort,$wr)
{
	$query = 'SELECT * FROM "NetworkNode"';
	if ($sort == 1)
		{
			$query .= ' ORDER BY "'.$FSort.'"';
		}
 	if ($wr != '')
 		{
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
	return $result;
}

function NetworkNode_DELETE($wr)
{
/*	foreach ($wr as $field => $value)
	{
    	if (strlen($where) > 0) $where .= ' AND ';
    	$where .= ' "'.$field.'"='.$value;
	}                           */
	$query = 'DELETE FROM "NetworkNode"';
	$query .= GenWhere($wr);
	$result = PQuery($query);
	return $result;
}

function GetNetworkNode_NetworkBoxName($NetworkNodeId) {	$query = 'SELECT "NN".id, "NN"."OpenGIS", "NN"."name", "NN"."NetworkBox", "NN"."note", "NN"."SettlementGeoSpatial",
        "NN"."Building", "NN"."Apartment", "NB"."inventoryNumber"
  		FROM "NetworkNode" AS "NN"
		LEFT JOIN "NetworkBox" AS "NB" ON "NB".id="NN"."NetworkBox" WHERE "NN".id='.$NetworkNodeId;
	$result = PQuery($query);
	return $result;
}
?>
