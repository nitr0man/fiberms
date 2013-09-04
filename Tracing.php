<?php

require_once "auth.php";
require_once "smarty.php";
require_once "func/FiberSplice.php";
require_once "design_func.php";

global $smarty;

$spliceId = pg_escape_string( $_GET[ 'spliceId' ] );
$fiberId = pg_escape_string( $_GET[ 'fiberId' ] );

$trace_res = trace( $spliceId, $fiberId );
$traceArr = array( );
for ( $i = 0; $i < count( $trace_res ); $i++ )
{
    if ( $trace_res[ $i ][ 'isNode' ] == 0 )
    {
        $CableLine = $trace_res[ $i ][ 'CableLine' ];
        $CableLineName = $trace_res[ $i ][ 'cl_name' ];
        $fiber = $trace_res[ $i ][ 'fiber' ];
        $fiberNote = $trace_res[ $i ][ 'note' ];
        if ( $trace_res[ $i ][ 'isTr' ] == 1 )
        {
            $traceArr[ ] = "<b>Линия</b>";
        }
        else
        {
            $traceArr[ ] = "Линия";
        }
        $traceArr[ ] = '<a href="CableLine.php?mode=charac&cablelineid='.$CableLine.'">'
                .$CableLineName.'</a>, волокно '.$fiber;
        $traceArr[ ] = $fiberNote;
    }
    else
    {
        $NetworkNode = $trace_res[ $i ][ 'NetworkNode' ];
        $NetworkNodeName = $trace_res[ $i ][ 'nn_name' ];
        $organizer = $trace_res[ $i ][ 'FiberSpliceOrganizer' ];
        if ( $trace_res[ $i ][ 'isTr' ] == 1 )
        {
            $traceArr[ ] = "<b>Узел</b>";
        }
        else
        {
            $traceArr[ ] = "Узел";
        }
        $traceArr[ ] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$NetworkNode.'">'
                .$NetworkNodeName.'</a>, кассета '.$organizer;
        $traceArr[ ] = '-';
    }
}
$smarty->assign( "data", $traceArr );
$smarty->display( 'Tracing.tpl' );
?>
