<?php

require_once 'config.php';

$query_count = 0;
$connection = PConnect( $config[ 'host' ], $config[ 'db' ], $config[ 'user' ],
     $config[ 'pass' ] );
$inTransaction = false;

if ( !$connection )
{
    die( "Could not open connection to database server" );
}


function PConnect( $host, $db, $user, $pass )
{
    global $connection;
    $connection = pg_connect( "host='".$host."' dbname='".$db."' user='".$user."' password='".$pass."'" );
    return $connection;
}

function PQuery( $query )
{
    require "config.php";
    global $connection;

    //error_log( $query );
    //print $query."<br>";
    $res = pg_query( $connection, $query );
    if ( !$res )
    {
        //print_r (debug_backtrace());
	list(, $caller) = debug_backtrace(false);
	error_log($caller['function'].', '.$caller['line'].": $query");
        $result[ 'count' ] = 0;
        $result[ 'rows' ] = NULL;
        $result[ 'error' ] = pg_last_error( $connection );
        return $result;
    }
    $result[ 'count' ] = pg_num_rows( $res );
    $i = 0;
    $rowarr = array();
    while ( $row = pg_fetch_array( $res, NULL, PGSQL_ASSOC ) )
    {
        $rowarr[ $i++ ] = $row;
    }
    pg_free_result( $res );
    $result[ 'rows' ] = $rowarr;
    return $result;
}

function genFieldName($field, $defprefix = NULL)
{
    $fieldarr = explode('.', $field);
    if (count($fieldarr) == 1 && $defprefix) {
	array_unshift($fieldarr, $defprefix);
    }
    $nfields = array();
    foreach ($fieldarr as $f) {
	if (mb_strtolower($f) != $f) {
	    $nfields[] = '"'.$f.'"';
	} else {
	    $nfields[] = $f;
	}
    }
    return implode('.', $nfields);
}
function genWhere( $wr, $sign = '=', $recursive = false )
{
    $where = '';
    foreach ( $wr as $field => $value )
    {
	$field1 = genFieldName($field);
        if ( strlen( $where ) > 0 )
            $where .= ' AND ';
        if ( is_string($value) &&  preg_match( '/^(NOT\s)?NULL$/', $value ) )
        {
            $where .= ' '.$field1.' IS '.pg_escape_string( $value ).'';
        }
        else
        {
            if ( is_string($value) &&  preg_match( '/^\(\s*([0-9.]+[, \s]+)+[0-9.]+\s*\)$/', $value ) )
            {
                $where .= ' '.$field1.'~=\''.pg_escape_string( $value ).'\'';
            }
            else if (is_numeric($value))
            {
                $where .= ' '.$field1.$sign.$value.'';
            }
            else if (is_array($value))
            {
                $where .= genWhere(array($field => $value['val']), $value['sign'], true);
            }
            else
            {
                $where .= ' '.$field1.$sign.'\''.pg_escape_string( $value ).'\'';
            }
        }
    }
    return ($recursive) ? ' '.$where : ' WHERE '.$where ;
}

function genInsert( $ins )
{
    $fields = '';
    $values = '';
    foreach ( $ins as $field => $value )
    {
        if ( strlen( $fields ) > 0 )
            $fields .= ', ';
        if ( strlen( $values ) > 0 )
            $values .= ', ';
        $fields .= '"'.$field.'"';
        if ( $value != 'NULL' )
        {
            $values .= "'".pg_escape_string( $value )."'";
        }
        else
        {
            $values .= "".pg_escape_string( $value )."";
        }
    }
    $result = ' ('.$fields.') VALUES ('.$values.')';
    return $result;
}

function genUpdate( $upd )
{
    $set = '';
    foreach ( $upd as $field => $value )
    {
        if ( strlen( $set ) > 0 )
            $set .= ', ';
        if ( $value != 'NULL' )
        {
            $set .= ' "'.$field.'"=\''.pg_escape_string( $value ).'\'';
        }
        else
        {
            $set .= ' "'.$field.'"='.pg_escape_string( $value );
        }
    }
    return $set;
}

function genWhereAndOr( $wr, $OrAnd )
{
    foreach ( $wr as $field => $value )
    {
        if ( strlen( $where ) > 0 )
        {
            if ( $OrAnd == 0 )
            {
                $sl = 'AND';
            }
            elseif ( $OrAnd == 1 )
            {
                $sl = 'OR';
            }
            $where .= ' '.$sl.' ';
        }
        $where .= ' "'.$field.'"=\''.pg_escape_string( $value ).'\'';
    }
    $result = ' WHERE '.$where;
    return $result;
}

function getCurrUserInfo()
{
    global $_SESSION;
    $login = (isset($_SESSION[ 'user' ])) ? $_SESSION[ 'user' ] : "";
    if ( $login != "" )
    {
        $query = 'SELECT * FROM "Users" WHERE "username"=\''.$login.'\'';
    }
    else
    {
        $id = $_SESSION[ 'user_id' ];
        $query = 'SELECT * FROM "Users" WHERE "id"='.$id;
    }
    $result = PQuery( $query );
    return $result;
}

function getStat()
{
    require_once('FS.php');
    require_once('backend/NetworkNode.php');

    $query = 'SELECT COUNT(*) AS "count" FROM "Users"';
    $res = PQuery( $query );
    $result[ 'Users' ][ 'All' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    $query = 'SELECT COUNT(*) AS "count" FROM "Users" WHERE "class"=\'1\'';
    $res = PQuery( $query );
    $result[ 'Users' ][ 'Admin' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    $query = 'SELECT id FROM "NetworkNode"';
    $res_nodes = PQuery( $query );
    $res_nodes_rows = $res_nodes[ 'rows' ];
    $result[ 'FiberSplice' ][ 'NetworkNodesCount' ] = $res_nodes[ 'count' ];
    $res2 = getFiberSpliceCount();
    $fiberSpliceCount = $res2[ 'fiberSpliceCount' ];
    $result[ 'FiberSplice' ][ 'FiberSpliceCount' ] = $fiberSpliceCount;
    $NetworkNodeCountInFiberSplice = $res2[ 'NetworkNodesCountInFiberSplice' ];
    $result[ 'FiberSplice' ][ 'NetworkNodeCountInFiberSplice' ] = $NetworkNodeCountInFiberSplice;
    $query = 'SELECT COUNT(*) AS "count" FROM "CableLinePoint"';
    $res = PQuery( $query );
    $result[ 'CableLinePoint' ][ 'Count' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    $query = 'SELECT COUNT(*) AS "count" FROM "NetworkNode"';
    $res = PQuery( $query );
    $result[ 'NetworkNode' ][ 'Count' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    $query = 'SELECT COUNT(*) AS "count" FROM "NetworkBox"';
    $res = PQuery( $query );
    $result[ 'NetworkBox' ][ 'Count' ] = $res[ 'rows' ][ 0 ][ 'count' ];
    return $result;
}

function tmpTable( $table, $tmp )
{
    return $tmp ? $table.'_tmp' : $table;
}

function getTables()
{
    $res[] = "CableType";
    $res[] = "CableLine";
    $res[] = "NetworkBoxType";
    $res[] = "NetworkBox";
    $res[] = "NetworkNode";
    $res[] = "CableLinePoint";
    $res[] = "FiberSpliceOrganizerType";
    $res[] = "FiberSpliceOrganizer";
    $res[] = "OpticalFiberSplice";
    $res[] = "OpticalFiber";
    $res[] = "OpticalFiberJoin";
    return $res;
}

function createTmpTables($in_transaction = false)
{
    global $config;
    $db_user = $config[ 'user' ];
    $tablist = getTables();
    $tables = array();
    for ( $i = 0; $i < count( $tablist ); $i++ )
    {
        $res = PQuery( "SELECT * FROM information_schema.tables WHERE table_name = '".tmpTable( $tablist[$i], TRUE )."';");
        if ($res['count'] == 0 && !isset($res['error'])) {
            $tables[] = $tablist[$i];
        }
    }
    if (count($tables) == 0) {
        return array('count' => 0);
    }
    $query = ($in_transaction) ? '' : 'BEGIN; LOCK "MapSettings";';
    for ( $i = 0; $i < count( $tables ); $i++ )
    {
        $table = $tables[ $i ];
        $tmpT = tmpTable( $table, TRUE );
        $query .= ' CREATE TABLE  "'.$tmpT.'" ( LIKE "'.$table.'" INCLUDING DEFAULTS INCLUDING INDEXES );';
        $query .= 'ALTER TABLE "'.$tmpT.'" OWNER TO '.$db_user.';';
        $query .= ' INSERT INTO "'.$tmpT.'" SELECT * FROM "'.$table.'";';
    }
    if (!$in_transaction) {
	$query .= ' COMMIT;';
    }
    return PQuery( $query );
}

function dropTmpTables($in_transaction = false)
{
    $tables = getTables();
    $query = ($in_transaction) ? '' : 'BEGIN; LOCK "MapSettings";';
    $tbl_del = "";
    for ( $i = 0; $i < count( $tables ); $i++ )
    {
        $table = $tables[ $i ];
        $tmpT = tmpTable( $table, TRUE );
        if ( strlen( $tbl_del ) > 0 )
        {
            $tbl_del .= ', ';
        }
        $tbl_del .= '"'.$tmpT.'"';
    }
    //$query .= ' TRUNCATE '.$tbl_del.';';
    $query .= ' DROP TABLE IF EXISTS '.$tbl_del.' CASCADE;';
    if (!$in_transaction) {
	$query .= ' COMMIT;';
    }
    //print($query);
    return PQuery( $query );
}

function removeDup( $arr )
{
    for ( $i = 0; $i < count( $arr ); $i++ )
    {
        $val = $arr[ $i ];
        $j = $i + 1;
        while ( $j < count( $arr ) )
        {
            $val = $arr[ $i ];
            $val2 = $arr[ $j ];           
            $dupeCount = 0;
            foreach ( $val as $key => $value )
            {
                if ( isset($val2[ $key ]) && $value == $val2[ $key ] )
                {
                    $dupeCount++;
                }
            }
            if ( $dupeCount == count( $val ) )
            {
                unset( $arr[ $j ] );
                $arr = array_values( $arr );                
            }
            else
            {
                $j++;
            }
        }
    }
    return $arr;
}


function startTransaction()
{
    global $inTransaction;
    if ($inTransaction)
	return false;
    $res = PQuery("BEGIN WORK;");
    if (isset($res['error']))
	return false;
    $inTransaction = true;
    return true;
};

function commitTransaction()
{
    global $inTransaction;
    if (!$inTransaction)
	return false;
    $res = PQuery("COMMIT WORK;");
    if (isset($res['error']))
	return false;
    $inTransaction = false;
    return true;
};

function rollbackTransaction()
{
    global $inTransaction;
    if (!$inTransaction)
	return false;
    $res = PQuery("ROLLBACK WORK;");
    if (isset($res['error']))
	return false;
    $inTransaction = false;
    return true;
};

?>