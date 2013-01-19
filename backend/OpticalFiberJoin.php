<?php
require_once("functions.php");
require_once("backend/LoggingIs.php");

function OpticalFiberJoin_SELECT($sort, $wr) {
	$query = 'SELECT * FROM "OpticalFiberJoin"';
	if ($wr != '') {
 		$query .= genWhere($wr);
 	}
	if ($sort == 1) {
		$query .= ' ORDER BY "OpticalFiber"';
	} else {
		$query .= ' ORDER BY "OpticalFiber"';
	}
 	$result = PQuery($query);
 	return $result;
}

function OpticalFiberJoin_INSERT($ins) {
	$query = 'INSERT INTO "OpticalFiberJoin"';
	$query .= genInsert($ins);
	$result = PQuery($query);
	loggingIs(2, 'OpticalFiberJoin', $ins, '');
	return $result;
}

function OpticalFiberJoin_UPDATE($upd, $wr) {
	$query = 'UPDATE "OpticalFiberJoin" SET ';
    $query .= genUpdate($upd);
	if ($wr != '') {
		$query .= genWhere($wr);
	}
	unset($field, $value);
	$result = PQuery($query);
	loggingIs(1, 'OpticalFiberJoin', $upd, $wr['id']);
	return $result;
}

function OpticalFiberJoin_DELETE($wr, $sign = '=') {
	$query = 'DELETE FROM "OpticalFiberJoin"';
	$query .= genWhere($wr, $sign);
	$result = PQuery($query);
	loggingIs(3, 'OpticalFiberJoin', '', $wr['id']);
	return $result;
}

function getNodeFibers($nodeId, $OFJ_id = -1) {
	$wr['NetworkNode'] = $nodeId;
	$query2 = '';
	if ( $OFJ_id != -1 ) {
		$query2 = ' AND "OFJ".id = '.pg_escape_string( $OFJ_id );
	}
	$query = 'SELECT "OFJ".id AS "OFJ_id", "OpticalFiber", "OpticalFiberSplice", "OF"."CableLine", "OF"."fiber", "OFS"."FiberSpliceOrganizer"
				FROM "OpticalFiberJoin" AS "OFJ"
				LEFT JOIN "OpticalFiber" AS "OF" ON "OF".id = "OFJ"."OpticalFiber"
				LEFT JOIN "OpticalFiberSplice" AS "OFS" ON "OFS".id = "OFJ"."OpticalFiberSplice"'.GenWhere($wr).$query2.'
			ORDER BY "OFJ"."OpticalFiberSplice"';
	$result = PQuery($query);
	return $result;
}

function addOpticalFiberJoin($CableLine, $fiber, $OpticalFiberSplice) {
	$query = 'INSERT INTO "OpticalFiberJoin"(
            "OpticalFiber", "OpticalFiberSplice")
    VALUES ((SELECT id FROM "OpticalFiber" WHERE "fiber"='.pg_escape_string( $fiber ).' AND "CableLine"='.pg_escape_string( $CableLine ).'), '.pg_escape_string( $OpticalFiberSplice ).')';
	$result = PQuery( $query );
	return $result;
}
?>