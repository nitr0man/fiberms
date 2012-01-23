<?php

/*
 * LMS version 1.11.13 Dira
 *
 *  (C) Copyright 2001-2011 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id: netremap.php,v 1.37 2011/01/18 08:12:23 alec Exp $
 */

if(!$LMS->NetworkExists($_GET['id'])||!$LMS->NetworkExists($_GET['mapto']))
{
	$SESSION->redirect('?m=netlist');
}

$network['source'] = $LMS->GetNetworkRecord($_GET['id'],$SESSION->get('ntlp'.$_GET['id'],1024));
$network['dest'] = $LMS->GetNetworkRecord($_GET['mapto']);

if($network['source']['assigned'] > $network['dest']['free'])
	$error['remap'] = TRUE;

if(!$error)
{
	if($_GET['is_sure'])
	{
		$LMS->NetworkRemap($network['source']['id'],$network['dest']['id']);
		$SESSION->redirect('?m=netinfo&id='.$network['dest']['id']);

	}else{
		$layout['pagetitle'] = trans('Readdressing Network $0',strtoupper($network['source']['name']));
		$SMARTY->display('header.html');
		echo '<H1>'.$layout['pagetitle'].'</H1>';
		echo '<P>'.trans('Are you sure, you want to readdress network $0 to network $1 ?',strtoupper($network['source']['name']).' ('.$network['source']['address'].'/'.$network['source']['prefix'].')', strtoupper($network['dest']['name']).' ('.$network['dest']['address'].'/'.$network['dest']['prefix'].')').'</P>';
		echo '<A href="?m=netremap&id='.$_GET['id'].'&mapto='.$_GET['mapto'].'&is_sure=1">'.trans('Yes, I am sure.').'</A>';
		$SMARTY->display('footer.html');
	}
}else{
	$networks = $LMS->GetNetworks();
	$SMARTY->assign('network',$network['source']);
	$SMARTY->assign('networks',$networks);
	$SMARTY->assign('error',$error);
	$SMARTY->display('netinfo.html');
}
	
?>
