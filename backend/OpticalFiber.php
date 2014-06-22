<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function OpticalFiber_SELECT( $sort, $wr, $tmpT = FALSE )
{
    $query = 'SELECT * FROM "'.tmpTable( 'OpticalFiber', $tmpT ).'"';
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    if ( $sort == 1 )
    {
        $query .= ' ORDER BY "fiber"';
    }
    else
    {
        $query .= ' ORDER BY "CableLine"';
    }
    $result = PQuery( $query );
    return $result;
}

function OpticalFiber_INSERT( $ins )
{
    $query = 'INSERT INTO "OpticalFiber"';
    $query .= genInsert( $ins );
    $result = PQuery( $query );
    loggingIs( 2, 'OpticalFiber', $ins, '' );
    return $result;
}

function OpticalFiber_UPDATE( $upd, $wr )
{
    $query = 'UPDATE "OpticalFiber" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'OpticalFiber', $upd, $wr[ 'id' ] );
    return $result;
}

function OpticalFiber_DELETE( $wr, $sign = '=' )
{
    $query = 'DELETE FROM "OpticalFiber"';
    $query .= genWhere( $wr, $sign );
    $result = PQuery( $query );
    loggingIs( 3, 'OpticalFiber', '', $wr[ 'id' ] );
    return $result;
}

?>