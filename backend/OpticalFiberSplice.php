<?php

require_once("functions.php");
require_once("backend/LoggingIs.php");

function OpticalFiberSplice_SELECT( $sort, $wr )
{
    $query = 'SELECT id, "NetworkNode", round(attenuation / 100.0, 2) AS attenuation, note, "FiberSpliceOrganizer" 
	FROM "OpticalFiberSplice"';
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

function OpticalFiberSplice_INSERT( $ins )
{
    if ( isset($ins[ 'attenuation' ]) ) {
        $attenuation = str_replace(',', '.', $ins[ 'attenuation' ]);
        if ( is_numeric( $attenuation ) )
            $ins[ 'attenuation' ] = floatval($attenuation) * 100;
        else
	    $ins[ 'attenuation' ] = 'NULL';
    }
    $query = 'INSERT INTO "OpticalFiberSplice"';
    $query .= genInsert( $ins );
    $query .= ' RETURNING id';
    $result = PQuery( $query );
    loggingIs( 2, 'OpticalFiberSplice', $ins, '' );
    return $result;
}

function OpticalFiberSplice_UPDATE( $upd, $wr )
{
    if ( isset($upd[ 'attenuation' ]) ) {
        $attenuation = str_replace(',', '.', $upd[ 'attenuation' ]);
        if ( is_numeric( $attenuation ) )
            $upd[ 'attenuation' ] = floatval($attenuation) * 100;
        else
	    $upd[ 'attenuation' ] = 'NULL';
    }
    $query = 'UPDATE "OpticalFiberSplice" SET ';
    $query .= genUpdate( $upd );
    if ( $wr != '' )
    {
        $query .= genWhere( $wr );
    }
    unset( $field, $value );
    $result = PQuery( $query );
    loggingIs( 1, 'OpticalFiberSplice', $upd, $wr[ 'id' ] );
    return $result;
}

function OpticalFiberSplice_DELETE( $wr, $sign = '=' )
{
    $query = 'DELETE FROM "OpticalFiberSplice"';
    $query .= genWhere( $wr, $sign );
    $result = PQuery( $query );
    loggingIs( 3, 'OpticalFiberSplice', '', $wr[ 'id' ] );
    return $result;
}

?>