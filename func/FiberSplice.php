<?php

require_once "backend/FS.php";
require_once "backend/CableType.php";
require_once "backend/OpticalFiberJoin.php";
require_once "backend/OpticalFiber.php";
require_once "backend/OpticalFiberSplice.php";

/* function FiberSplice_Check() {

  } */

function FiberSplice_Mod( $OFJ_id, $CableLine, $fiber, $FiberSpliceOrganizer )
{
    $wr[ 'id' ] = $OFJ_id;
    $res = OpticalFiberJoin_SELECT( 1, $wr );
    $OpticalFiberSplice = $res[ 'rows' ][ 0 ][ 'OpticalFiberSplice' ];
    unset( $wr );
    $wr[ 'fiber' ] = $fiber;
    $wr[ 'CableLine' ] = $CableLine;
    $res = OpticalFiber_SELECT( 1, $wr );
    unset( $wr );
    $upd[ 'OpticalFiber' ] = $res[ 'rows' ][ 0 ][ 'id' ];
    $wr[ 'id' ] = $OFJ_id;
    $res = OpticalFiberJoin_UPDATE( $upd, $wr );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    unset( $wr );
    unset( $upd );
    $wr[ 'id' ] = $OpticalFiberSplice;
    $upd[ 'FiberSpliceOrganizer' ] = $FiberSpliceOrganizer;
    $res = OpticalFiberSplice_UPDATE( $upd, $wr );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

function FiberSplice_Add( $CableLineA, $fiberA, $CableLineB, $fiberB,
        $FiberSpliceOrganizer, $NetworkNodeId )
{
    $ins[ 'NetworkNode' ] = $NetworkNodeId;
    $ins[ 'FiberSpliceOrganizer' ] = $FiberSpliceOrganizer;
    $res = OpticalFiberSplice_INSERT( $ins );
    $OFS_id = $res[ 'rows' ][ 0 ][ 'id' ];
    $res = addOpticalFiberJoin( $CableLineA, $fiberA, $OFS_id );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    $res = addOpticalFiberJoin( $CableLineB, $fiberB, $OFS_id );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

/* --------------- */

function getFiberTable( $nodeID )
{
    $cl_array = getCableLineInfo( $nodeID );
    $i = 0;
    $maxfiber = 0;
    if ( $cl_array[ 'count' ] == 0 )
    {
        // TODO: exit and return zero table
        return;
    }
    // Array of cableline points
    foreach ( $cl_array[ 'rows' ] as $elem )
    {
        if ( $maxfiber < $elem[ 'fiber' ] )
        {
            $maxfiber = $elem[ 'fiber' ];
        }
        $CableLines[ $elem[ 'clid' ] ] = $i++;
    }
    // Buiding array of fiber splices
    $fs_array = getNodeFibers( $nodeID );
    if ( $fs_array[ 'count' ] > 0 )
    {
        $rows = $fs_array[ 'rows' ];
        $i = 0;
        while ( $i < count( $rows ) )
        {
            if ( $rows[ $i ][ 'OpticalFiberSplice' ] == $rows[ $i + 1 ][ 'OpticalFiberSplice' ] )
            {
                $ClA = $CableLines[ $rows[ $i ][ 'CableLine' ] ];
                $ClB = $CableLines[ $rows[ $i + 1 ][ 'CableLine' ] ];
                $fA = $rows[ $i ][ 'fiber' ];
                $fB = $rows[ $i + 1 ][ 'fiber' ];
                $FSO = $rows[ $i ][ 'FiberSpliceOrganizer' ];
                $spliceId = $rows[ $i ][ 'OpticalFiberSplice' ];
                $spliceArray[ $ClA ][ $fA ] = array( $ClB, $fB, $rows[ $i + 1 ][ 'OFJ_id' ],
                    $FSO, $spliceId );
                $spliceArray[ $ClB ][ $fB ] = array( $ClA, $fA, $rows[ $i ][ 'OFJ_id' ],
                    $FSO, $spliceId );
                $i = $i + 2;
            }
            else
            {
                $i++;
            }
        }
    }
    else
    {
        $spliceArray = array();
    }
    $res[ 'maxfiber' ] = $maxfiber;
    $res[ 'CableLines' ] = $CableLines;
    $res[ 'SpliceArray' ] = $spliceArray;
    $res[ 'cl_array' ] = $cl_array;
    return $res;
}

/* --------------- */

function getFibers( $networkNodeId, $CableLine, $fiber )
{
    $res = getFiberTable( $networkNodeId );
    $j = $res[ 'CableLines' ][ $CableLine ];
    for ( $i = 1; $i <= $res[ 'cl_array' ][ 'rows' ][ $j ][ 'fiber' ]; $i++ )
    {
        $arr = $res[ 'SpliceArray' ][ $j ][ $i ];
        if ( (!isset( $arr )) or ($i == $fiber) )
        {
            $fibers[] = $i;
        }
    }
    return $fibers;
}

function FSOT_Check( $marking, $manufacturer, $note )
{
    $result = 1;
    /* ����� �������� */
    if ( $marking == '' )
    {
        $result = 0;
    }
    return $result;
}

function FSOT_Mod( $id, $marking, $manufacturer, $note )
{
    if ( FSOT_Check( $marking, $manufacturer, $note ) == 0 )
    {
        return 0;
    }
    $upd[ 'marking' ] = $marking;
    $upd[ 'manufacturer' ] = $manufacturer;
    $upd[ 'note' ] = $note;
    $wr[ 'id' ] = $id;
    $res = FSOT_UPDATE( $upd, $wr );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

function FSOT_Add( $marking, $manufacturer, $note )
{
    if ( FSOT_Check( $marking, $manufacturer, $note ) == 0 )
    {
        return 0;
    }
    $ins[ 'marking' ] = $marking;
    $ins[ 'manufacturer' ] = $manufacturer;
    $ins[ 'note' ] = $note;
    $res = FSOT_INSERT( $ins );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

function FSO_Check( $FSOT )
{
    $result = 1;
    /* ����� �������� */
    return $result;
}

function FSO_Mod( $id, $FSOT )
{
    if ( FSO_Check( $FSOT ) == 0 )
    {
        return 0;
    }
    $upd[ 'FiberSpliceOrganizationType' ] = $FSOT;
    $wr[ 'id' ] = $id;
    $res = FSO_UPDATE( $upd, $wr );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

function FSO_Add( $FSOT )
{
    if ( FSO_Check( $FSOT ) == 0 )
    {
        return 0;
    }
    $ins[ 'FiberSpliceOrganizationType' ] = $FSOT;
    $res = FSO_INSERT( $ins );
    if ( isset( $res[ 'error' ] ) )
    {
        return $res;
    }
    return 1;
}

function getFSOTsInfo( $sort, $linesPerPage = -1, $skip = -1 )
{
    $res = FSOT_SELECT( $sort, '', $linesPerPage, $skip );
    $result[ 'FSOTs' ] = $res;
    unset( $wr );
    for ( $i = 0; $i < $res[ 'count' ]; $i++ )
    {
        $wr[ 'FiberSpliceOrganizationType' ] = $res[ 'rows' ][ $i ][ 'id' ];
        $res2 = FSO_SELECT( '', $wr );
        $result[ 'FSOTs' ][ 'rows' ][ $i ][ 'FSOCount' ] = $res2[ 'count' ];
    }
    return $result;
}

function deleteSplice( $OFJ_id )
{
    $wr[ 'id' ] = $OFJ_id;
    $res = OpticalFiberJoin_SELECT( 1, $wr );
    $OFS_id = $res[ 'rows' ][ 0 ][ 'OpticalFiberSplice' ];
    $query = 'DELETE FROM "OpticalFiberJoin" WHERE "OpticalFiberSplice"='.$OFS_id;
    $res = PQuery( $query );
    $query = 'DELETE FROM "OpticalFiberSplice" WHERE id='.$OFS_id;
    $res = PQuery( $query );
    return $res;
}

function trace( $spliceId = -1, $fiberId = -1 )
{
    $result = array();
    if ( $spliceId != -1 && $fiberId != -1 )
    {
        $spliceIds = getSplices( $spliceId, $fiberId );
        if ( count( $spliceIds ) > 0 )
        {
            $fibers = getFibs( $spliceIds, $fiberId );
            $result = array_merge( $result, $fibers );
            for ( $i = 0; $i < count( $fibers ); $i++ )
            {
                $sId = $fibers[ $i ][ 'OpticalFiberSplice' ];
                $oF = $fibers[ $i ][ 'OpticalFiber' ];
                if ( ($sId != '') && ($oF != '') )
                {
                    $res = trace( $sId, $oF );
                    $result = array_merge( $result, $res );
                }
            }
        }
    }
    elseif ( $spliceId != -1 )
    {
        $fibers = getFibs( array( array( "OpticalFiberSplice" => $spliceId ) ) );
        $trackArr = array();
        for ( $i = 0; $i < count( $fibers ); $i++ )
        {
            $sId = $fibers[ $i ][ 'OpticalFiberSplice' ];
            $oF = $fibers[ $i ][ 'OpticalFiber' ];
            if ( ($sId != '') && ($oF != '') )
            {
                $res = trace( $sId, $oF );
                $trackArr[ $i ] = $res;
            }
        }

        $traceArr = array();
        $traceArr[ 0 ] = array();
        $traceArr[ 1 ] = array();
        for ( $i = 0; $i < count( $trackArr ); $i++ )
        {
            $k = 0;
            $traceArr[ $i ] = array();
            for ( $j = 0; $j < count( $trackArr[ $i ] ); $j++ )
            {
                $traceArr[ $i ][ $k ][ 'isNode' ] = 1;
                $traceArr[ $i ][ $k ][ 'isTr' ] = 0;
                $traceArr[ $i ][ $k ][ 'NetworkNode' ] = $trackArr[ $i ][ $j ][ 'NetworkNode' ];
                $traceArr[ $i ][ $k ][ 'FiberSpliceOrganizer' ] = $trackArr[ $i ][ $j ][ 'FiberSpliceOrganizer' ];
                $traceArr[ $i ][ $k++ ][ 'nn_name' ] = $trackArr[ $i ][ $j ][ 'nn_name' ];

                $traceArr[ $i ][ $k ][ 'isNode' ] = 0;
                foreach ( $trackArr[ $i ][ $j ] as $key => $value )
                {
                    if ( ($key != 'NetworkNode') && ($key != 'nn_name') )
                    {
                        $traceArr[ $i ][ $k ][ $key ] = $value;
                    }
                }
                $k++;
            }
        }
        $cArr_res = getAllInfoBySpliceId( $spliceId );
        $cArr = array();
        for ( $i = 0; $i < count( $cArr_res ); $i++ )
        {
            $cArr[ $i ][ 'isNode' ] = 0;
            foreach ( $cArr_res[ $i ] as $key => $value )
            {
                if ( ($key != 'NetworkNode') && ($key != 'nn_name') )
                {
                    $cArr[ $i ][ $key ] = $value;
                }
            }
        }
        $cArr[ $i ][ 'isNode' ] = 1;
        $cArr[ $i ][ 'NetworkNode' ] = $cArr_res[ $i - 1 ][ 'NetworkNode' ];
        $cArr[ $i ][ 'nn_name' ] = $cArr_res[ $i - 1 ][ 'nn_name' ];
        $cArr[ $i ][ 'FiberSpliceOrganizer' ] = $cArr_res[ $i - 1 ][ 'FiberSpliceOrganizer' ];

        if ( count( $traceArr[ 0 ] ) > count( $traceArr[ 1 ] ) )
        {
            $traceArr[ 1 ] = array_reverse( $traceArr[ 1 ] );
            $traceArr[ 1 ][] = $cArr[ 0 ];
            $traceArr[ 1 ][] = $cArr[ 2 ];
            $traceArr[ 1 ][] = $cArr[ 1 ];
            $result = array_merge( $traceArr[ 1 ], $traceArr[ 0 ] );
        }
        else
        {
            $traceArr[ 0 ] = array_reverse( $traceArr[ 0 ] );
            $traceArr[ 0 ][] = $cArr[ 0 ];
            $traceArr[ 0 ][] = $cArr[ 2 ];
            $traceArr[ 0 ][] = $cArr[ 1 ];
            $result = array_merge( $traceArr[ 0 ], $traceArr[ 1 ] );
        }
    }
    else
    {
        $spliceIds = getSplices( $spliceId, $fiberId );
        $trackArr = array();
        $trackArr[ 0 ] = array();
        for ( $i = 0; $i < count( $spliceIds ); $i++ )
        {
            $sId = $spliceIds[ $i ][ 'OpticalFiberSplice' ];
            $oF = $spliceIds[ $i ][ 'OpticalFiber' ];
            if ( ($sId != '') && ($oF != '') )
            {
                $res = trace( $sId, $oF );
                $trackArr[ $i ] = $res;
            }
        }

        $traceArr = array();
        $traceArr[ 0 ] = array();
        $traceArr[ 1 ] = array();
        for ( $i = 0; $i < count( $trackArr ); $i++ )
        {
            $k = 0;
            $traceArr[ $i ] = array();
            for ( $j = 0; $j < count( $trackArr[ $i ] ); $j++ )
            {
                $traceArr[ $i ][ $k ][ 'isNode' ] = 1;
                $traceArr[ $i ][ $k ][ 'isTr' ] = 0;
                $traceArr[ $i ][ $k ][ 'NetworkNode' ] = $trackArr[ $i ][ $j ][ 'NetworkNode' ];
                $traceArr[ $i ][ $k ][ 'FiberSpliceOrganizer' ] = $trackArr[ $i ][ $j ][ 'FiberSpliceOrganizer' ];
                $traceArr[ $i ][ $k++ ][ 'nn_name' ] = $trackArr[ $i ][ $j ][ 'nn_name' ];

                $traceArr[ $i ][ $k ][ 'isNode' ] = 0;
                foreach ( $trackArr[ $i ][ $j ] as $key => $value )
                {
                    if ( ($key != 'NetworkNode') && ($key != 'nn_name') )
                    {
                        $traceArr[ $i ][ $k ][ $key ] = $value;
                    }
                }
                $k++;
            }
        }

        $line_res = getLineByFiberId( $fiberId );
        $cArr = array();
        $cArr[ 'isNode' ] = 0;
        $cArr[ 'isTr' ] = 1;
        foreach ( $line_res as $key => $value )
        {
            if ( ($key != 'NetworkNode') && ($key != 'nn_name') )
            {
                $cArr[ $key ] = $value;
            }
        }


        if ( count( $traceArr[ 0 ] ) > count( $traceArr[ 1 ] ) )
        {
            $traceArr[ 1 ] = array_reverse( $traceArr[ 1 ] );
            $traceArr[ 1 ][] = $cArr;
            $result = array_merge( $traceArr[ 1 ], $traceArr[ 0 ] );
        }
        else
        {
            $traceArr[ 0 ] = array_reverse( $traceArr[ 0 ] );
            $traceArr[ 0 ][] = $cArr;
            $result = array_merge( $traceArr[ 0 ], $traceArr[ 1 ] );
        }
    }
    return $result;
}

?>