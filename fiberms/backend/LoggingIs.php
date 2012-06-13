<?php
function LoggingIs($type,$TableName,$values,$record) {
	if ($type != 3) {
		foreach ($values as $field => $value) {
			$action .= pg_escape_string(' "'.$field.'"=>\''.$value.'\'');
		}
	}
	$user_res = GetCurrUserInfo();
	$user = $user_res['rows'][0]['id'];
	$res = PQuery('SELECT id FROM "LogTableList" WHERE "name"=\''.$TableName.'\'');
	$TableId = $res['rows'][0]['id'];
	if ($type == 1) {   //update
		$action = 'UPDATED:'.$action;
	} elseif ($type == 2) {  //insert
		$action = 'ADDED:'.$action;
		$wr = GenWhere($values);
		$query = 'SELECT * FROM "'.pg_escape_string($TableName).'"'.$wr;
		$res = PQuery($query);
		$record = $res['rows'][0]['id'];
	} elseif ($type == 3) { //delete
		$action = 'DELETED';
	}
	$query = 'INSERT INTO "LogAdminActions" ("table","record","time","action","admin") VALUES ('.pg_escape_string($TableId).','.pg_escape_string($record).',NOW(),\''.$action.'\','.pg_escape_string($user).')';
	$res = PQuery($query);
	return 1;
}

function LoggingIs_SELECT($LinesPerPage,$skip) {
	$query = 'SELECT "laa".id,"laa"."table","laa"."record",to_char("laa"."time", \'yyyy-mm-dd HH24:MI:SS\') AS "time","laa"."action","laa"."description","laa"."admin","u"."username" FROM "LogAdminActions" AS "laa" LEFT JOIN "Users" AS "u" ON "u".id="laa"."admin" ORDER BY "time" DESC';
	$query .= ' LIMIT '.$LinesPerPage.' OFFSET '.$skip.'';
 	$result = PQuery($query);
	$query = 'SELECT COUNT(*) AS "count" FROM "LogAdminActions"';
	$res = PQuery($query);
	$result['all'] = $res['rows'][0]['count'];
 	return $result;
}
?>