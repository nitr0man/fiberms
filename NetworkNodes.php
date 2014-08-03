<?php

require_once("auth.php");
require_once("smarty.php");
require_once("func/NetworkNode.php");
require_once("design_func.php");

if ( $_SERVER[ "REQUEST_METHOD" ] == 'POST' )
{
    $back = $_POST[ 'back' ];
    if ( $_POST[ 'mode' ] == 1 )
    {
        $id = $_POST[ 'id' ];
        $name = $_POST[ 'name' ];
        $networkBox = $_POST[ 'boxes' ];
        $note = $_POST[ 'note' ];
        $place = $_POST[ 'place' ];
        $OpenGIS =  ($_POST[ 'OpenGIS' ] == '') ? 'NULL' : $_POST[ 'OpenGIS' ];
        $apartment = $building = $SettlementGeoSpatial = 'NULL';

        $res = NetworkNode_Mod( $id, $name, $networkBox, $note, $OpenGIS,
                $SettlementGeoSpatial, $building, $apartment, $place );
        if ( isset( $res[ 'error' ] ) )
        {
            $message = $res[ 'error' ];
            $error = 1;
        }
        elseif ( !isset( $res[ 'error' ] ) )
        {
            header( "Refresh: 3; url=".$back );
            $message = 'Узел изменен!';
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
        $name = $_POST[ 'name' ];
        $networkBox = $_POST[ 'boxes' ];
        $note = $_POST[ 'note' ];
        $place = $_POST[ 'place' ];
        $OpenGIS =  ($_POST[ 'OpenGIS' ] == '') ? 'NULL' : $_POST[ 'OpenGIS' ];
        $apartment = $building = $SettlementGeoSpatial = 'NULL';

        $res = NetworkNode_Add( $name, $networkBox, $note, $OpenGIS,
                $SettlementGeoSpatial, $building, $apartment, $place );
        if ( isset( $res[ 'error' ] ) )
        {
            $message = $res[ 'error' ];
            $error = 1;
        }
        elseif ( !isset( $res[ 'error' ] ) )
        {
            header( "Refresh: 3; url=".$back );
            $message = 'Узел добавлен!';
            $error = 0;
        }
        else
        {
            $message = 'Неверно заполнены поля!';
            $error = 1;
        }
    }
    showMessage( $message, $error );
}
else
{
    $comboBox_Box_Values = array();
    $comboBox_Box_Text = array();
    if ( !isset( $_GET[ 'mode' ] ) )
    {
        require_once('backend/CableType.php');

        $page = (isset( $_GET[ 'page' ] )) ? $_GET[ 'page' ] : 1;
        $sort = (isset( $_GET[ 'sort' ] )) ? $_GET[ 'sort' ] : 0;

        if ( !isset( $_GET[ 'nodeid' ] ) )
        {
            $res = getNetworkNodeList_NetworkBoxName( $sort,
                    '', $config[ 'LinesPerPage' ],
                    ($page - 1) * $config[ 'LinesPerPage' ] );
        }
        else
        {
            $wr[ 'id' ] = $_GET[ 'nodeid' ];
            $res = getNetworkNodeList_NetworkBoxName( $sort,
                    $wr, $config[ 'LinesPerPage' ],
                    ($page - 1) * $config[ 'LinesPerPage' ] );
        }
        if ( $res[ 'count' ] < 1 && isset( $_GET[ 'nodeid' ] ) )
        {
            $message = 'Узла с таким ID не существует!<br />
			<a href="NetworkNodes.php">Назад</a>';
            showMessage( $message, 0 );
        }
        $pages = genPages( 'NetworkNodes.php?sort='.$sort.'&',
                ceil( $res[ 'allPages' ] / $config[ 'LinesPerPage' ] ), $page );
        $rows = $res[ 'rows' ];
        $i = -1;
        $node_arr = array();
        while ( ++$i < $res[ 'count' ] )
        {
            $node_arr[] = $rows[ $i ][ 'id' ];
            $node_arr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$rows[ $i ][ 'id' ].'">'.$rows[ $i ][ 'name' ].'</a>';
            $node_arr[] = '<a href="NetworkBox.php?mode=charac&boxid='.$rows[ $i ][ 'NetworkBox' ].'">'.$rows[ $i ][ 'inventoryNumber' ].'</a>';
            $node_arr[] = '<a href="NetworkBoxType.php?mode=charac&boxtypeid='.$rows[ $i ][ 'NetworkBoxType' ].'">'.$rows[ $i ][ 'NBTmarking' ].'</a>';
            $node_arr[] = $rows[ $i ][ 'fiberSpliceCount' ];
            $node_arr[] = $rows[ $i ][ 'OpenGIS' ];
            $node_arr[] = '<a href="NetworkNodes.php?mode=change&nodeid='.$rows[ $i ][ 'id' ].'">Изменить</a>';
            $wr[ 'NetworkNode' ] = $rows[ $i ][ 'id' ];
            $res2 = CableLinePoint_SELECT( $wr );
            if ( $res2[ 'count' ] == 0 )
            {
                $node_arr[] = '<a href="NetworkNodes.php?mode=delete&nodeid='.$rows[ $i ][ 'id' ].'">Удалить</a>';
            }
            else
            {
                $node_arr[] = '';
            }
        }
        $smarty->assign( "data", $node_arr );
        $smarty->assign( "pages", $pages );
        $smarty->assign( "mode", '' );
        $smarty->assign( "sort", $sort );
    }
    elseif ( ($_GET[ 'mode' ] == 'charac') and (isset( $_GET[ 'nodeid' ] )) )
    {
        $smarty->assign( "mode", "charac" );
        require_once("backend/FS.php");

        $nodeId = $_GET[ 'nodeid' ];
        $res = getNetworkNodeInfo( $nodeId );
        if ( $res[ 'NetworkNode' ][ 'count' ] < 1 )
        {
            $message = 'Ящика с таким ID не существует!<br />
			<a href="NetworkNodes.php">Назад</a>';
            showMessage( $message, 0 );
        }
        $rows = $res[ 'NetworkNode' ][ 'rows' ][ 0 ];
        $clpRows = $res[ 'NetworkNode' ][ 'CableLinePoints' ][ 'rows' ];

        $i = -1;
        $CableLinePoints_arr = array();
        while ( ++$i < $res[ 'NetworkNode' ][ 'CableLinePoints' ][ 'count' ] )
        {
            $CableLinePoints_arr[] = $clpRows[ $i ][ 'id' ];
            $CableLinePoints_arr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$clpRows[ $i ][ 'CableLine' ].'">'.$clpRows[ $i ][ 'clname' ].'</a>';
            $CableLinePoints_arr[] = $clpRows[ $i ][ 'meterSign' ];
            $CableLinePoints_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$clpRows[ $i ][ 'id' ].'">Изменить</a>';
            $fiberSpliceCount = $clpRows[ $i ][ 'fiberSpliceCount' ];
            if ( $fiberSpliceCount == 0 )
            {
                $CableLinePoints_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$clpRows[ $i ][ 'id' ].'">Удалить</a>';
            }
            else
            {
                $CableLinePoints_arr[] = '';
            }
        }

        $fsoRows = $res[ 'NetworkNode' ][ 'FSO' ][ 'rows' ];
        $i = -1;
        $FSO_arr = array();
        while ( ++$i < $res[ 'NetworkNode' ][ 'FSO' ][ 'count' ] )
        {
            $FSO_arr[] = $fsoRows[ $i ][ 'id' ];
            $FSO_arr[] = $fsoRows[ $i ][ 'FiberSpliceOrganizationTypeMarking' ];
            $FSO_arr[] = $fsoRows[ $i ][ 'FiberSpliceOrganizationTypeManufacturer' ];
            $FSO_arr[] = $fsoRows[ $i ][ 'FiberSpliceCount' ];
            $FSO_arr[] = '<a href="FSO.php?mode=change&fsoid='.$fsoRows[ $i ][ 'id' ].'">Изменить</a>';
            if ( $fsoRows[ $i ][ 'NetworkNodeName' ] == '' )
            {
                $FSO_arr[] = '<a href="FSO.php?mode=delete&fsoid='.$fsoRows[ $i ][ 'id' ].'">Удалить</a>';
            }
            else
            {
                $FSO_arr[] = '';
            }
        }

        $fiberSpliceCount = $rows[ 'fiberSpliceCount' ];
        if ( $res[ 'NetworkNode' ][ 'CableLinePoints' ][ 'count' ] > 0 )
        {
            $changeDeleteFiberSplice = '<a href="FiberSplice.php?networknodeid='.$nodeId.'">Отобразить сварки</a><br/>';
        } else
            $changeDeleteFiberSplice = '';
        $changeDeleteFiberSplice .= '<a href="NetworkNodes.php?mode=change&nodeid='.$nodeId.'">Изменить</a>';
        $wr[ 'NetworkNode' ] = $nodeId;
        $res2 = CableLinePoint_SELECT( $wr );
        if ( $res2[ 'count' ] == 0 )
        {
            $changeDeleteFiberSplice .= '<br><a href="NetworkNodes.php?mode=delete&nodeid='.$nodeId.'">Удалить</a>';
        }
        $invNum = $rows[ 'inventoryNumber' ];
        if ( $invNum == "" )
        {
            $invNum = "---";
        }
        $invNum .= " (".$rows[ 'NBTMarking' ].")";

        $smarty->assign( "CableLinePoints", $CableLinePoints_arr );
        $smarty->assign( "FSO", $FSO_arr );
        $smarty->assign( "id", $rows[ 'id' ] );
        $smarty->assign( "name", $rows[ 'name' ] );
        $smarty->assign( "NetworkBox", $invNum );
        $smarty->assign( "FiberSpliceCount", $fiberSpliceCount );
        $smarty->assign( "note", nl2br( $rows[ 'note' ] ) );
        $smarty->assign( "place", $rows[ 'place' ]);
        $smarty->assign( "OpenGIS", $rows[ 'OpenGIS' ] );
        $smarty->assign( "ChangeDeleteFiberSplice", $changeDeleteFiberSplice );
    }
    elseif ( ($_GET[ 'mode' ] == 'change') and (isset( $_GET[ 'nodeid' ] )) )
    {
        if ( $_SESSION[ 'class' ] > 1 )
        {
            $message = '!!!';
            showMessage( $message, 0 );
        }

        $smarty->assign( "mode", "add_change" );
        $smarty->assign( "mod", "1" );
        $smarty->assign( "back", getenv( "HTTP_REFERER" ) );

        $wr[ 'id' ] = $_GET[ 'nodeid' ];
        $res = NetworkNode_SELECT( 0, '', $wr );
        if ( $res[ 'count' ] < 1 )
        {
            $message = 'Узла с таким ID не существует!<br />
						<a href="NetworkNodes.php">Назад</a>';
            showMessage( $message, 0 );
        }
        $rows = $res[ 'rows' ];
        $smarty->assign( "id", $rows[ 0 ][ 'id' ] );
        $smarty->assign( "name", $rows[ 0 ][ 'name' ] );
        $smarty->assign( "NetworkBox", $rows[ 0 ][ 'NetworkBox' ] );
        $smarty->assign( "note", $rows[ 0 ][ 'note' ] );
        $smarty->assign( "place", $rows[ 0 ][ 'place' ] );
        $smarty->assign( "OpenGIS", $rows[ 0 ][ 'OpenGIS' ] );
        $networkBox = $rows[ 0 ][ 'NetworkBox' ];

        $res = getFreeNetworkBoxes( $rows[ 0 ][ 'NetworkBox' ] );
        $rows = $res[ 'rows' ];
        $i = -1;
        while ( ++$i < $res[ 'count' ] )
        {
            $invNum = $rows[ $i ][ 'inventoryNumber' ];
            if ( $invNum == "" )
            {
                $invNum = "---";
            }
            $invNum .= " (".$rows[ $i ][ 'marking' ].")";
            $comboBox_Box_Values[] = $rows[ $i ][ 'id' ];
            $comboBox_Box_Text[] = $invNum;
        }
        $smarty->assign( "combobox_box_values", $comboBox_Box_Values );
        $smarty->assign( "combobox_box_text", $comboBox_Box_Text );
        $smarty->assign( "combobox_box_selected", $networkBox );
    }
    elseif ( $_GET[ 'mode' ] == 'add' )
    {
        if ( $_SESSION[ 'class' ] > 1 )
        {
            $message = '!!!';
            showMessage( $message, 0 );
        }

        $smarty->assign( "mode", "add_change" );
        $smarty->assign( "mod", "2" );
        $smarty->assign( "back", getenv( "HTTP_REFERER" ) );

        $res = getFreeNetworkBoxes( -1 );
        $rows = $res[ 'rows' ];
        $i = -1;
        while ( ++$i < $res[ 'count' ] )
        {
            $invNum = $rows[ $i ][ 'inventoryNumber' ];
            if ( $invNum == "" )
            {
                $invNum = "---";
            }
            $invNum .= " (".$rows[ $i ][ 'marking' ].")";
            $comboBox_Box_Values[] = $rows[ $i ][ 'id' ];
            $comboBox_Box_Text[] = $invNum;
        }
        $smarty->assign( "combobox_box_values", $comboBox_Box_Values );
        $smarty->assign( "combobox_box_text", $comboBox_Box_Text );
        $smarty->assign( "id", '' );
        $smarty->assign( "name", '' );
        $smarty->assign( "NetworkBox", '' );
        $smarty->assign( "note", '' );
        $smarty->assign( "place", '' );
        $smarty->assign( "OpenGIS", '' );
    }
    elseif ( ($_GET[ 'mode' ] == 'delete') and (isset( $_GET[ 'nodeid' ] )) )
    {
        if ( $_SESSION[ 'class' ] > 1 )
        {
            $message = '!!!';
            showMessage( $message, 0 );
        }
        $wr[ 'id' ] = $_GET[ 'nodeid' ];
        NetworkNode_DELETE( $wr );
        header( "Refresh: 2; url=".getenv( "HTTP_REFERER" ) );
        $message = "Узел удален!";
        showMessage( $message, 0 );
    }

    $smarty->display( 'NetworkNodes.tpl' );
}
?>
