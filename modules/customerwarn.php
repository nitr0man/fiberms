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
 *  $Id: customerwarn.php,v 1.17 2011/01/18 08:12:21 alec Exp $
 */

$setwarnings = isset($_POST['setwarnings']) ? $_POST['setwarnings'] : array();

if(isset($setwarnings['mcustomerid']))
{
	$warnon = isset($setwarnings['warnon']) ? $setwarnings['warnon'] : FALSE;
	$warnoff = isset($setwarnings['warnoff']) ? $setwarnings['warnoff'] : FALSE;
	$message = isset($setwarnings['message']) ? $setwarnings['message'] : NULL;

	foreach($setwarnings['mcustomerid'] as $uid)
	{
		if($warnon)
			$LMS->NodeSetWarnU($uid, TRUE);

		if($warnoff) 
			$LMS->NodeSetWarnU($uid, FALSE);

		if(isset($message))
			$DB->Execute('UPDATE customers SET message=? WHERE id=?', array($message, $uid));
	}

	$SESSION->save('warnmessage', $message);
	$SESSION->save('warnon', $warnon);
	$SESSION->save('warnoff', $warnoff);

	$SESSION->redirect('?'.$SESSION->get('backto'));
}

if(isset($_GET['search']))
{
	$SESSION->restore('customersearch', $customersearch);
	$SESSION->restore('cslo', $o);
	$SESSION->restore('csls', $s);
	$SESSION->restore('csln', $n);
	$SESSION->restore('cslg', $g);
	$SESSION->restore('cslk', $k);

	$customerlist = $LMS->GetCustomerList($o, $s, $n, $g, $customersearch, NULL, $k);
	
	unset($customerlist['total']);
	unset($customerlist['state']);
	unset($customerlist['network']);
	unset($customerlist['customergroup']);
	unset($customerlist['direction']);
	unset($customerlist['order']);
	unset($customerlist['below']);
	unset($customerlist['over']);

	$selected = array();
	if($customerlist)
		foreach($customerlist as $row)
			$selected[$row['id']] = $row['id'];
	
	$SMARTY->assign('selected', $selected);
}

$layout['pagetitle'] = trans('Notices');

$customerlist = $DB->GetAllByKey('SELECT c.id AS id, MAX(warning) AS warning, '.
		    $DB->Concat('UPPER(lastname)',"' '",'c.name').' AS customername 
		    FROM customersview c 
		    LEFT JOIN nodes ON c.id = ownerid 
		    WHERE deleted = 0 
		    GROUP BY c.id, lastname, c.name 
		    ORDER BY customername ASC', 'id');

$SMARTY->assign('warnmessage', $SESSION->get('warnmessage'));
$SMARTY->assign('warnon', $SESSION->get('warnon'));
$SMARTY->assign('warnoff', $SESSION->get('warnoff'));
$SMARTY->assign('customerlist',$customerlist);
$SMARTY->display('customerwarnings.html');

?>
