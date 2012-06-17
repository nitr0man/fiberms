<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function NetworkNode_SELECT($sort,$FSort,$wr) {
	$query = 'SELECT * FROM "NetworkNode"';
	if ($wr != '') {
		$query .= GenWhere($wr);
 	}
	if ($sort == 1)	{
		$query .= ' ORDER BY "'.$FSort.'"';
	} else {
		$query .= ' ORDER BY "name"';
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

function NetworkNode_UPDATE($upd,$wr) {
	$query = 'UPDATE "NetworkNode" SET ';
    $query .= GenUpdate($upd);
	if ($wr != '') {
		$query .= GenWhere($wr);
	}
	unset($field,$value);
	$result = PQuery($query);
	LoggingIs(1,'NetworkNode',$upd,$wr['id']);
	return $result;
}

function NetworkNode_DELETE($wr) {
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
function GetNetworkNodeList_NetworkBoxName($sort,$FSort,$wr,$LinesPerPage = -1,$skip = -1) {
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
	if (($LinesPerPage != -1) and ($skip != -1)) {
		$query .= ' LIMIT '.$LinesPerPage.' OFFSET '.$skip;
		$query2 = 'SELECT COUNT(*) AS "count" FROM "CableType"';
		$res = PQuery($query2);
		$AllPages = $res['rows'][0]['count'];
	}
	$result = PQuery($query);
	$result['AllPages'] = $AllPages;
	return $result;
}

function GetFreeNetworkBoxes($NetworkBox) {
	$query = 'SELECT "NB".id,"NB"."NetworkBoxType","NB"."inventoryNumber","NN".id AS "nnid" FROM "NetworkBox" AS "NB" LEFT JOIN "NetworkNode" AS "NN" ON "NN"."NetworkBox"="NB".id WHERE "NN".id IS NULL OR "NB".id='.$NetworkBox;
	$result = PQuery($query);
	return $result;
}
?>
