<?php

require_once('config.php');

function PConnect( $host, $db, $user, $pass )
{
    $connection = pg_connect( "host='".$host."' dbname='".$db."' user='".$user."' password='".$pass."'" );
    return $connection;
}

function PQuery( $query )
{
    require "config.php";

    //error_log( $query );
    $res = pg_query( $connection, $query ) or $error = 1;
    if ( $error == 1 )
    {
        $result[ 'error' ] = pg_last_error( $connection );
        return $result;
    }
    $result[ 'count' ] = pg_num_rows( $res );
    $i = 0;
    while ( $row = pg_fetch_array( $res, NULL, PGSQL_ASSOC ) )
    {
        $rowarr[ $i++ ] = $row;
    }
    pg_free_result( $res );
    $result[ 'rows' ] = $rowarr;
    return $result;
}

function genWhere( $wr, $sign = '=' )
{
    foreach ( $wr as $field => $value )
    {
        if ( strlen( $where ) > 0 )
            $where .= ' AND ';
        if ( preg_match( '/^(NOT\s)?NULL$/', $value ) )
        {
            $where .= ' "'.$field.'" IS '.pg_escape_string( $value ).'';
        }
        else
        {
            if ( preg_match( '/^\(\s*([0-9.]+[, \s]+)+[0-9.]+\s*\)$/', $value ) )
            {
                $where .= ' "'.$field.'"~=\''.pg_escape_string( $value ).'\'';
            }
            else
            {
                $where .= ' "'.$field.'"'.$sign.'\''.pg_escape_string( $value ).'\'';
            }
        }
        /* if ($value != 'NULL') {
          if (preg_match('/^\(\s*([0-9.]+[, \s]+)+[0-9.]+\s*\)$/', $value)) {
          $where .= ' "'.$field.'"~=\''.pg_escape_string($value).'\'';
          } else {
          $where .= ' "'.$field.'"=\''.pg_escape_string($value).'\'';
          }
          } else {
          $where .= ' "'.$field.'" IS '.pg_escape_string($value).'';
          } */
    }
    $result = ' WHERE '.$where;
    return $result;
}

function genInsert( $ins )
{
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
    $login = $_SESSION[ 'user' ];
    $query = 'SELECT * FROM "Users" WHERE "username"=\''.$login.'\'';
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
    $res[ ] = "CableLinePoint";
    $res[ ] = "CableLine";
    $res[ ] = "CableType";
    $res[ ] = "FiberSpliceOrganizer";
    $res[ ] = "FiberSplice";    
    $res[ ] = "FiberSpliceOrganizerType";
    $res[ ] = "NetworkNode";
    $res[ ] = "NetworkBox";
    $res[ ] = "NetworkBoxType";    
    $res[ ] = "OpticalFiberJoin";
    $res[ ] = "OpticalFiberSplice";
    $res[ ] = "OpticalFiber";
    return $res;
}

function createTmpTables()
{
    $tables = getTables();
    $query = 'BEGIN;';
    for ( $i = 0; $i < count( $tables ); $i++ )
    {
        $table = $tables[ $i ];
        $tmpT = tmpTable( $table, TRUE );
        $query .= ' CREATE TABLE "'.$tmpT.'" ( LIKE "'.$table.'" INCLUDING ALL );';
        $query .= ' INSERT INTO "'.$tmpT.'" SELECT * FROM "'.$table.'";';
    }
    $query .= 'COMMIT;';
    PQuery( $query );
}

function dropTmpTables()
{
    $tables = getTables();
    $query = 'BEGIN;';
    for ( $i = 0; $i < count( $tables ); $i++ )
    {
        $table = $tables[ $i ];
        $tmpT = tmpTable( $table, TRUE );
        $query .= ' DROP TABLE IF EXISTS "'.$tmpT.'";';
    }
    $query .= ' COMMIT;';
    PQuery( $query );
}

?>