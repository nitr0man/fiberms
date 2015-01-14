<?php

require_once "auth.php";
require_once "smarty.php";
require_once "func/FiberSplice.php";
require_once "backend/NetworkNode.php";
require_once 'backend/OpticalFiber.php';
require_once "design_func.php";

if ( $_SERVER[ "REQUEST_METHOD" ] == 'POST' )
{
    $back = (isset($_POST[ 'back' ])) ? $_POST[ 'back' ] : '';
    if ( $_POST[ 'mode' ] == 1 )
    {
        $SpliceId = $_POST[ 'SpliceId' ];
        $fiber = $_POST[ 'Fibers' ];
        $FiberSpliceOrganizer = $_POST[ 'FibersSpliceOrganizer' ];
        $cableLine = $_POST[ 'CableLines' ];
        $attenuation = $_POST[ 'attenuation' ];
        $note = $_POST[ 'note' ];

        $res = FiberSplice_Mod( $SpliceId, $cableLine, $fiber,
                $FiberSpliceOrganizer, $attenuation, $note );
        if ( isset( $res[ 'error' ] ) )
        {
            $message = $res[ 'error' ];
            $error = 1;
        }
        elseif ( $res == 1 )
        {
            header( "Refresh: 3; url=".$back );
            $message = 'Сварка изменена!';
            $error = 0;
        }
        else
        {
            $message = 'Неверно заполнены поля!';
            $error = 1;
        }
    }
    elseif ( $_POST[ 'mode' ] == 2 )
    {
        $CableLine1 = $_POST[ 'clid1' ];
        $CableLine2 = $_POST[ 'CableLines' ];
        $fiber1 = $_POST[ 'fiber' ];
        $fiber2 = $_POST[ 'Fibers' ];
        $NetworkNodeId = $_POST[ 'NetworkNodeId' ];
        $FiberSpliceOrganizer = $_POST[ 'FibersSpliceOrganizer' ];
        $attenuation = $_POST[ 'attenuation' ];
        $note = $_POST[ 'note' ];

        $res = FiberSplice_Add( $CableLine1, $fiber1, $CableLine2, $fiber2,
                $FiberSpliceOrganizer, $NetworkNodeId, $attenuation, $note );

        if ( isset( $res[ 'error' ] ) )
        {
            $message = $res[ 'error' ];
            $error = 1;
        }
        elseif ( $res == 1 )
        {
            header( "Refresh: 3; url=".$back );
            $message = 'Сварка добавлена!';
            $error = 0;
        }
        else
        {
            $message = 'Неверно заполнены поля!';
            $error = 1;
        }
    }
    elseif ( $_POST[ 'mode' ] == 3 )
    {
        $currFiber = $_POST[ 'CurrFiber' ];
        $networkNodeId = $_POST[ 'NetworkNodeId' ];
        $cableLineId = $_POST[ 'CableLine' ];
        if ( (!isset( $currFiber ) ) or ( $currFiber == '' ) )
        {
            $currFiber = -1;
        }
        $fibers = getFibers( $networkNodeId, $cableLineId, $currFiber );
        $smarty->assign( "ComboBox_Fibers_values", $fibers );
        $smarty->assign( "ComboBox_Fibers_text", $fibers );
        $smarty->assign( "ComboBox_Fibers_selected", $currFiber );
        $smarty->display( "FiberSplice_content_Fibers.tpl" );
        die();
    }
    showMessage( $message, $error );
}
else
{
    if ( isset($_GET['mode' ]) && ($_GET['mode'] == 'add' ||
	($_GET['mode'] == 'change' && isset($_GET['networknodeid']) && isset($_GET['clid1']) && isset($_GET['fiber1']))))
    {
        if ( $_SESSION[ 'class' ] > 1 )
        {
            $message = '!!!';
            showMessage( $message, 0 );
        }

        $smarty->assign( "mode", "add_change" );
        $smarty->assign( "mod", ($_GET[ 'mode' ] == 'change') ? '1' : '2' );
        $smarty->assign( "back", (isset($_GET[ 'back' ])) ? $_GET[ 'back' ] : getenv( "HTTP_REFERER" ) );
        $smarty->assign( "IsA", (isset($_GET[ 'isa' ])) ? $_GET[ 'isa' ] : '' );
        $smarty->assign( "curr_fiber", (isset($_GET[ 'fiber2' ])) ? $_GET[ 'fiber2' ] : '-1' );
        $smarty->assign( "fiber1", $_GET[ 'fiber1' ] );

        $networkNodeId = $_GET[ 'networknodeid' ];
        $smarty->assign( "NetworkNodeId", $networkNodeId );

        $cableLineId1 = $_GET[ 'clid1' ];
        $smarty->assign( "clid1", $cableLineId1 );

        $fiber = ($_GET[ 'mode' ] == 'change') ? $_GET[ 'fiber2' ] : -1;
        $res = getFiberTable( $networkNodeId );

        $cl_array = $res[ 'cl_array' ];
        for ( $i = 0; $i < $cl_array[ 'count' ]; $i++ )
        {
            $ComboBox_CableLinePoint_Values[] = $cl_array[ 'rows' ][ $i ][ 'clid' ];
            $ComboBox_CableLinePoint_Text[] = $cl_array[ 'rows' ][ $i ][ 'name' ];
        }
        $smarty->assign( "ComboBox_CableLines_values",
                $ComboBox_CableLinePoint_Values );
        $smarty->assign( "ComboBox_CableLines_text",
                $ComboBox_CableLinePoint_Text );

        $cable1 = $cl_array[ 'rows' ][ $res[ 'CableLines' ][ $cableLineId1 ] ][ 'name' ];
        $smarty->assign( "cable1", $cable1 );

        $cableLineId2 = ($_GET[ 'mode' ] == 'change') ? $_GET[ 'clid2' ] : $res[ 'cl_array' ][ 'rows' ][ 0 ][ 'clid' ];
        $smarty->assign( "ComboBox_CableLines_selected", $cableLineId2 );

        $fibers = getFibers( $networkNodeId, $cableLineId2, $fiber );
        $smarty->assign( "Combobox_Fibers_selected", (isset($_GET[ 'fiber2' ])) ? $_GET[ 'fiber2' ] : '' );
        $smarty->assign( "ComboBox_Fibers_values", $fibers );
        $smarty->assign( "ComboBox_Fibers_text", $fibers );

        if ($_GET[ 'mode' ] == 'change') {
            $OFJ_id = $_GET[ 'spliceid' ];
            $smarty->assign( "SpliceId", $OFJ_id );

            $res = getNodeFibers( $networkNodeId, $OFJ_id );
            $fso = $res[ 'rows' ][ 0 ][ 'FiberSpliceOrganizer' ];
            $smarty->assign( "attenuation", $res[ 'rows' ][ 0 ][ 'attenuation' ] );
            $smarty->assign( "note", $res[ 'rows' ][ 0 ][ 'note' ] );
        } else {
            $smarty->assign( "attenuation", '' );
            $smarty->assign( "note", '' );
            $smarty->assign( "SpliceId", '' );
            $fso = '';
        }
        $res = getFiberSpliceOrganizerInfo( -1, -1, $networkNodeId );
        $ComboBox_FibersSpliceOrganizer_Values = array();
        $ComboBox_FibersSpliceOrganizer_Text = array();
        for ( $i = 0; $i < $res[ 'count' ]; $i++ )
        {
            $ComboBox_FibersSpliceOrganizer_Values[] = $res[ 'rows' ][ $i ][ 'id' ];
            $ComboBox_FibersSpliceOrganizer_Text[] = $res[ 'rows' ][ $i ][ 'id' ]." (".$res[ 'rows' ][ $i ][ 'FiberSpliceOrganizationTypeMarking' ].")";
        }
        $smarty->assign( "ComboBox_FibersSpliceOrganizer_values",
                $ComboBox_FibersSpliceOrganizer_Values );
        $smarty->assign( "ComboBox_FibersSpliceOrganizer_text",
                $ComboBox_FibersSpliceOrganizer_Text );
        $smarty->assign( "Combobox_FibersSpliceOrganizer_selected", $fso );


    }
    elseif ( isset( $_GET[ 'networknodeid' ] ) )
    {
        $networkNodeId = $_GET[ 'networknodeid' ];
        $wr[ 'id' ] = $networkNodeId;
        $res = NetworkNode_SELECT( '', '', $wr );
        $networkNodeName = $res[ 'rows' ][ 0 ][ 'name' ];
        $res = getFiberTable( $networkNodeId );
        if ( $res[ 'maxfiber' ] < 1 )
        {
            $message = 'Узлу должен принадлежать минимум 1 кабель!';
            showMessage( $message, 0 );
        }

        $table_text_cols = '<th>№</th>';
        $table_text_marking = $table_text_fiber_count = $table_text_direction = $table_text_CableLineNames = $table_text_info = $table_text_fibers = '';
        for ( $i = 0; $i < count( $res[ 'CableLines' ] ); $i++ )
        {
            $table_text_cols .= '<th colspan=3>'.($i + 1).'</th>';
            if ( isset( $_GET[ 'print' ] ) )
            {
                $table_text_marking .= '<td colspan=3>'.$res[ 'cl_array' ][ 'rows' ][ $i ][ 'manufacturer' ].'<br>'.$res[ 'cl_array' ][ 'rows' ][ $i ][ 'marking' ].'</td>';
            }
            else
            {
                $table_text_marking .= '<td colspan=3><a href="CableType.php?mode=charac&cabletypeid='
                        .$res[ 'cl_array' ][ 'rows' ][ $i ][ 'ctid' ].'">'
                        .$res[ 'cl_array' ][ 'rows' ][ $i ][ 'manufacturer' ].'<br>'
                        .$res[ 'cl_array' ][ 'rows' ][ $i ][ 'marking' ].'</a></td>';
            }
            $table_text_fiber_count .= '<td colspan=3>'.$res[ 'cl_array' ][ 'rows' ][ $i ][ 'fiber' ].'</td>';

            //$direction = getCableLineDirection($res['cl_array']['rows'][$i]['clpid'], $networkNodeId);            
            $direction_rows = getCableLineDirection( -1,
                    $res[ 'cl_array' ][ 'rows' ][ $i ][ 'clpid' ],
                    $networkNodeId );
            if ( isset($direction_rows[ 0 ][ 'NetworkNode' ]) && $direction_rows[ 0 ][ 'NetworkNode' ] == $networkNodeId )
            {
                $direction[ 'name' ] = $direction_rows[ 1 ][ 'name' ];
                $direction[ 'place' ] = $direction_rows[ 1 ][ 'place' ];
                $direction[ 'NetworkNode' ] = $direction_rows[ 1 ][ 'NetworkNode' ];
            }
            else
            {
                $direction[ 'name' ] = $direction_rows[ 0 ][ 'name' ];
                $direction[ 'place' ] = isset($direction_rows[ 0 ][ 'place' ]) ? $direction_rows[ 0 ][ 'place' ] : '';
                $direction[ 'NetworkNode' ] = (isset($direction_rows[ 0 ][ 'NetworkNode' ])) ? $direction_rows[ 0 ][ 'NetworkNode' ] : '';
            }
            if ( $direction[ 'name' ] == '-' )
            {
                $table_text_direction .= '<td colspan=3>'.'-'.'</td>';
            }
            else
            {
                $place = ( isset($direction[ 'place' ]) && strlen($direction[ 'place' ]) > 0) ? '<br><small>'.$direction[ 'place' ].'</small>' : '';
                if ( isset( $_GET[ 'print' ] ) )
                {
                    $table_text_direction .= '<td colspan=3>'.$direction[ 'name' ].$place.'</td>';
                }
                else
                {
                    $table_text_direction .= '<td colspan=3>'.'<a href="NetworkNodes.php?mode=charac&nodeid='.$direction[ 'NetworkNode' ].'">'.$direction[ 'name' ].'</a>'.$place.'</td>';
                }
            }
            if ( isset( $_GET[ 'print' ] ) )
            {
                $table_text_CableLineNames .= '<td colspan=3>'.$res[ 'cl_array' ][ 'rows' ][ $i ][ 'name' ].'</td>';
            }
            else
            {
                $table_text_CableLineNames .= '<td colspan=3>'.'<a href="CableLine.php?mode=charac&cablelineid='.$res[ 'cl_array' ][ 'rows' ][ $i ][ 'clid' ].'">'.$res[ 'cl_array' ][ 'rows' ][ $i ][ 'name' ].'</a>'.'</td>';
            }
            $table_text_info .= '<td>Соед.</td><td>К</td><td>М</td>';
        }

        for ( $i = 1; $i <= $res[ 'maxfiber' ]; $i++ )
        {
            if ( isset( $_GET[ 'print' ] ) )
            {
                $table_text_fibers .= '<tr><td><b>'.$i.'</b></td>';
            }
            else
            {
                $table_text_fibers .= '<tr><td>'.$i.'</td>';
            }
            for ( $j = 0; $j < count( $res[ 'CableLines' ] ); $j++ )
            {
                //$clpid1 = $res[ 'cl_array' ][ 'rows' ][ $j ][ 'clpid' ];
                //$clpid2 = $res[ 'cl_array' ][ 'rows' ][ $arr[ 1 ] ][ 'clpid' ];
                $fiber1 = $i;
                //$is_a = $arr[ 3 ];
                $fiberPerTube = $res[ 'cl_array' ][ 'rows' ][ $j ][ 'fiberPerTube' ];
                $module = (int)(($i - 1) / $fiberPerTube + 1);
                $rowspan_fso = 1;
                $fso = 0;
                //$rowspan_module = 1;                
                if ( ($i > $res[ 'cl_array' ][ 'rows' ][ $j ][ 'fiber' ] ) )
                {
                    $table_text_module = '<td>&nbsp;</td>';
                    $table_text_fibers .= '<td>&nbsp;</td>';
                }
                else
                {
                    if ( isset( $res[ 'SpliceArray' ][ $j ][ $i ] ) )
                    {
                        $arr = $res[ 'SpliceArray' ][ $j ][ $i ];
                        $fiber2 = $arr[ 1 ];
                        $splice_id = $arr[ 2 ];
                        $fso = $arr[ 3 ];
                        $cl_col = ($arr[0] == -1) ? '?' : (string)($arr[ 0 ] + 1);
                        if ( isset( $_GET[ 'print' ] ) )
                        {
                            $table_text_fibers .= '<td>'.$cl_col.' - '.$arr[ 1 ].'</td>';
                        }
                        else
                        {
                            $linksD = ' <a href="FiberSplice.php?mode=delete&spliceid='.$splice_id.'"&networknodeid='.$networkNodeId.' onclick="return confirm(\'Удалить?\');">[x]</a>';
                            $clid = $res[ 'cl_array' ][ 'rows' ][ $j ][ 'clid' ];
                            $linksT = ' <a href="Tracing.php?spliceId='.$res[ 'SpliceArray' ][ $j ][ $i ][ 4 ].'&fiberId=-1&clid='.$clid.'">[T]</a>';
                            $table_text_fibers .= '<td>'.'<a href="FiberSplice.php?mode=change&fiber1='.$fiber1
                                    .'&fiber2='.$fiber2.'&networknodeid='.$networkNodeId.'&spliceid='.$splice_id
                                    .'&clid2='.$res[ 'cl_array' ][ 'rows' ][ $arr[ 0 ] ][ 'clid' ]
                                    .'&clid1='.$res[ 'cl_array' ][ 'rows' ][ $j ][ 'clid' ].'">'
                                    .$cl_col.' - '.$arr[ 1 ].'</a> '.$linksD.' '.$linksT.'</td>';
                        }
                    }
                    else
                    {
                        if ( !(isset( $_GET[ 'print' ] ) ) )
                        {
                            $linksN = '<a href="FiberSplice.php?mode=add&fiber1='.$fiber1.'&networknodeid='
                                    .$networkNodeId
                                    .'&clid1='.$res[ 'cl_array' ][ 'rows' ][ $j ][ 'clid' ]
                                    .'">[+]</a>';
                            $clid = $res[ 'cl_array' ][ 'rows' ][ $j ][ 'clid' ];
                            $wr2[ 'CableLine' ] = $clid;
                            $wr2[ 'fiber' ] = $i;
                            $res3 = OpticalFiber_SELECT( 1, $wr2 );
                            $fiberId = $res3[ 'rows' ][ 0 ][ 'id' ];
                            $linksT = ' <a href="Tracing.php?spliceId=-1&fiberId='.$fiberId.'&clid='.$clid.'">[T]</a>';
                            $table_text_fibers .= '<td>'.$linksN.' '.$linksT.'</td>';
                        } else {
                            $table_text_fibers .= '<td></td>';
                        }
                    }
                    if ( ($i == 1) or ($fiberPerTube == 1) or ($i % $fiberPerTube == 1 ) )
                    {
                        $table_text_module = '<td rowspan="'.$fiberPerTube.'">'.$module.'</td>';
                    }
                }
                for ( $k = $i + 1; $k <= $res[ 'cl_array' ][ 'rows' ][ $j ][ 'fiber' ]; $k++ )
                {
                    if (!isset($res[ 'SpliceArray' ][ $j ][ $k ]))
                        break;
                    $fso2 = $res[ 'SpliceArray' ][ $j ][ $k ][ 3 ];
                    if ( ($fso == $fso2) and ($fso != -1) and (!empty( $fso )) and (!empty( $fso2 )) )
                    {
                        $res[ 'SpliceArray' ][ $j ][ $k ][ 3 ] = -1;
                        $rowspan_fso++;
                    }
                    else
                    {
                        break;
                    }
                }
                if ( $fso != -1 )
                {
                    $table_text_fibers .= ($fso) ? '<td rowspan="'.$rowspan_fso.'">'.$fso.'</td>' : '<td></td>';
                }
                if ( !empty( $table_text_module ) )
                {
                    $table_text_fibers .= $table_text_module;
                    $table_text_module = '';
                }
            }
            $table_text_fibers .= '</tr>';
        }
        if ( isset( $_GET[ 'print' ] ) )
        {
            $printLink = '';
        }
        else
        {
            $printLink = '[<a href="FiberSplice.php?networknodeid='.$networkNodeId.'&print">Версия для печати</a>]';
        }

        $table_text = '<thead><tr>'.$table_text_cols.'</tr></thead>';
        $table_text .= '<tbody>';
        if ( isset( $_GET[ 'print' ] ) )
        {
            $table_text .= '<tr class=cp><td>Имя</td>'.$table_text_CableLineNames.'</tr>';
            $table_text .= '<tr class=cp><td>Направление</td>'.$table_text_direction.'</tr>';
            $table_text .= '<tr class=cp><td>Маркировка</td>'.$table_text_marking.'</tr>';
            $table_text .= '<tr class=cp><td>Количество волокон</td>'.$table_text_fiber_count.'</tr>';
            $table_text .= '<tr class=bottomborder><td>Нумерация</td>'.$table_text_info.'</tr>';
        }
        else
        {
            $table_text .= '<tr class=header><td>Имя</td>'.$table_text_CableLineNames.'</tr>';
            $table_text .= '<tr class=header><td>Направление</td>'.$table_text_direction.'</tr>';
            $table_text .= '<tr class=header><td>Маркировка</td>'.$table_text_marking.'</tr>';
            $table_text .= '<tr class=header><td>Количество волокон</td>'.$table_text_fiber_count.'</tr>';
            $table_text .= '<tr class=header><td>Нумерация</td>'.$table_text_info.'</tr>';
        }
        $table_text .= $table_text_fibers;
        $table_text .= '</tbody>';
        $smarty->assign( "table", $table_text );

        $smarty->assign( "nodeName", $networkNodeName );
        $smarty->assign( "printLink", $printLink );
        $smarty->assign( "mode", '' );
    }
    elseif ( ($_GET[ 'mode' ] == 'delete') and ( isset( $_GET[ 'spliceid' ] ) ) )
    {
        if ( $_SESSION[ 'class' ] > 1 )
        {
            $message = '!!!';
            showMessage( $message, 0 );
        }
        deleteSplice( $_GET[ 'spliceid' ] );
        header( "Refresh: 2; url=".getenv( "HTTP_REFERER" ) );
        $message = "Сварка удалена!";
        showMessage( $message, 0 );
    }

    $smarty->display( 'FiberSplice.tpl' );
}
?>
