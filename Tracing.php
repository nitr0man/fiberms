<?php

require_once "auth.php";
require_once "smarty.php";
require_once "func/FiberSplice.php";
require_once "design_func.php";

global $smarty;

$spliceId = pg_escape_string( $_GET[ 'spliceId' ] );
$fiberId = pg_escape_string( $_GET[ 'fiberId' ] );
$clid = pg_escape_string( $_GET[ 'clid' ] );

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
        $fiberNote = $trace_res[ $i ][ 'cl_note' ];
        if (strlen($fiberNote) > 0 && strlen($trace_res[ $i ][ 'note' ]) > 0) {
            $fiberNote .= ', ';
        }
        $fiberNote .= $trace_res[ $i ][ 'note' ];
        if ( $trace_res[ $i ][ 'CableLine' ] == $clid ||
             (isset($trace_res[ $i ][ 'id' ]) && $trace_res[ $i ][ 'id' ] == $fiberId ))
        {
            $traceArr[] = "<b>Линия</b>";
        }
        else
        {
            $traceArr[] = "Линия";
        }
        $traceArr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$CableLine.'">'
             .$CableLineName.'</a>, волокно '.$fiber;
        $traceArr[] = $trace_res[ $i ][ 'length' ] . (($trace_res[$i]['length2']) ? ' / '.$trace_res[$i]['length2'] : '');
        $traceArr[] = $fiberNote;
    }
    else
    {
        $NetworkNode = $trace_res[ $i ][ 'NetworkNode' ];
        $NetworkNodeName = $trace_res[ $i ][ 'nn_name' ];
        $organizer = $trace_res[ $i ][ 'FiberSpliceOrganizer' ];
        $note =  $trace_res[ $i ][ 'place' ];
        if (strlen($note) > 0 && strlen($trace_res[ $i ][ 'ofs_note' ]) > 0) {
            $note .= ', ';
        }
        $note .= $trace_res[ $i ][ 'ofs_note' ];
        $traceArr[] = "Узел";
        $traceArr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$NetworkNode.'">'
             .$NetworkNodeName.'</a>, кассета '.$organizer;
        $traceArr[] = $trace_res[ $i ][ 'length' ] . (($trace_res[$i]['rlength']) ? ' / '.$trace_res[$i]['rlength'] : '');
        $traceArr[] = $note;
    }
}
$smarty->assign( "data", $traceArr );
$smarty->display( 'Tracing.tpl' );
?>
