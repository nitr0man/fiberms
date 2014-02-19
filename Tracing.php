<?php

require_once "auth.php";
require_once "smarty.php";
require_once "func/FiberSplice.php";
require_once "design_func.php";

global $smarty;

$spliceId = pg_escape_string( $_GET[ 'spliceId' ] );
$fiberId = pg_escape_string( $_GET[ 'fiberId' ] );
$clid = pg_escape_string( $_GET[ 'clid' ] );

$traceDepth = 0;
$trace_res = trace( $spliceId, $fiberId );
$trace_res = removeDup( $trace_res );
$traceArr = array();
for ( $i = 0; $i < count( $trace_res ); $i++ )
{
    if ( $trace_res[ $i ][ 'isNode' ] == 0 )
    {
        $CableLine = $trace_res[ $i ][ 'CableLine' ];
        $CableLineName = $trace_res[ $i ][ 'cl_name' ];
        $fiber = $trace_res[ $i ][ 'fiber' ];
        $fiberNote = $trace_res[ $i ][ 'note' ];
        if ( $trace_res[ $i ][ 'CableLine' ] == $clid ||
             $trace_res[ $i ][ 'id' ] == $fiberId )
        {
            $traceArr[] = "<b>Линия</b>";
        }
        else
        {
            $traceArr[] = "Линия";
        }
        $traceArr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$CableLine.'">'
             .$CableLineName.'</a>, волокно '.$fiber;
        $traceArr[] = $fiberNote;
    }
    else
    {
        $NetworkNode = $trace_res[ $i ][ 'NetworkNode' ];
        $NetworkNodeName = $trace_res[ $i ][ 'nn_name' ];
        $organizer = $trace_res[ $i ][ 'FiberSpliceOrganizer' ];
        $traceArr[] = "Узел";
        $traceArr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$NetworkNode.'">'
             .$NetworkNodeName.'</a>, кассета '.$organizer;
        $traceArr[] = '-';
    }
}
$smarty->assign( "data", $traceArr );
$smarty->display( 'Tracing.tpl' );
?>
