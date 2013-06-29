<?php

function loggingIs( $type, $tableName, $values, $record )
{
    if ( $type != 3 )
    {
        foreach ( $values as $field => $value )
        {
            $action .= pg_escape_string( ' "'.$field.'"=>\''.$value.'\'' );
        }
    }
    $user_res = getCurrUserInfo();
    $user = $user_res[ 'rows' ][ 0 ][ 'id' ];
    $res = PQuery( 'SELECT id FROM "LogTableList" WHERE "name"=\''.$tableName.'\'' );
    $tableId = $res[ 'rows' ][ 0 ][ 'id' ];
    if ( $type == 1 )
    {   //update
        $action = 'UPDATED:'.$action;
    }
    elseif ( $type == 2 )
    {  //insert
        $action = 'ADDED:'.$action;
        $wr = genWhere( $values );
        $query = 'SELECT * FROM "'.pg_escape_string( $tableName ).'"'.$wr;
        $res = PQuery( $query );
        $record = $res[ 'rows' ][ 0 ][ 'id' ];
    }
    elseif ( $type == 3 )
    { //delete
        $action = 'DELETED';
    }
    $query = 'INSERT INTO "LogAdminActions" ("table", "record", "time", "action", "admin") VALUES ('.pg_escape_string( $tableId ).', '.pg_escape_string( $record ).', NOW(), \''.$action.'\', '.pg_escape_string( $user ).')';
    $res = PQuery( $query );
    return 1;
}

function loggingIs_SELECT( $linesPerPage = -1, $skip = -1 )
{
    $query = 'SELECT "laa".id, "laa"."table", "laa"."record", to_char("laa"."time", \'yyyy-mm-dd HH24:MI:SS\') AS "time", "laa"."action", "laa"."description", "laa"."admin", "u"."username", "ltl"."name" FROM "LogAdminActions" AS "laa" LEFT JOIN "Users" AS "u" ON "u".id="laa"."admin" LEFT JOIN "LogTableList" AS "ltl" ON "ltl".id="laa"."table" ORDER BY "time" DESC';
    $query .= ' LIMIT '.$linesPerPage.' OFFSET '.$skip;
    $result = PQuery( $query );
    $query = 'SELECT COUNT(*) AS "count" FROM "LogAdminActions"';
    $res = PQuery( $query );
    $result[ 'allPages' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    return $result;
}

?>