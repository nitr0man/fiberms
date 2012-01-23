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
 *  $Id: domainedit.php,v 1.32 2011/01/18 08:12:22 alec Exp $
 */

function GetDomainIdByName($name)
{
	global $DB;
	return $DB->GetOne('SELECT id FROM domains WHERE name = ?', array($name));
}

function DomainExists($id)
{
	global $DB;
	return ($DB->GetOne('SELECT id FROM domains WHERE id = ?', array($id)) ? TRUE : FALSE);
}

$id = $_GET['id'];

if($id && !DomainExists($id))
{
	$SESSION->redirect('?'.$SESSION->get('backto'));
}

$domain = $DB->GetRow('SELECT id, name, ownerid, description, master, last_check, type, notified_serial, account
	FROM domains WHERE id = ?', array($id));

$layout['pagetitle'] = trans('Domain Edit: $0', $domain['name']);

if(isset($_POST['domain']))
{
	$olddomain = $domain['name'];
	$oldowner = $domain['ownerid'];
	
	$domain = $_POST['domain'];
	$domain['name'] = trim($domain['name']);
	$domain['description'] = trim($domain['description']);
	$domain['id'] = $id;
	
	if($domain['name']=='' && $domain['description']=='')
	{
		$SESSION->redirect('?'.$SESSION->get('backto'));
	}
	
        if($domain['type'] == 'SLAVE')
        {
    		if (!check_ip($domain['master']))
    			$error['master'] = trans('IP address of master NS is required!');
        }
        else
    		$domain['master'] = '';
	
	if($domain['name'] == '')
		$error['name'] = trans('Domain name is required!');
	elseif(!preg_match('/^[a-z0-9._-]+$/', $domain['name']))
	        $error['name'] = trans('Domain name contains forbidden characters!');
	elseif($olddomain != $domain['name'] && GetDomainIdByName($domain['name']))
		$error['name'] = trans('Domain with specified name exists!');

	if($domain['ownerid'] && $domain['ownerid'] != $oldowner)
        {
                $limits = $LMS->GetHostingLimits($domain['ownerid']);
        
		if($limits['domain_limit'] !== NULL)
                {
			if($limits['domain_limit'] > 0)
			        $cnt = $DB->GetOne('SELECT COUNT(*) FROM domains WHERE ownerid = ?',
		        		array($domainadd['ownerid']));
		
			if($limits['domain_limit'] == 0 || $limits['domain_limit'] <= $cnt)
			        $error['ownerid'] = trans('Exceeded domains limit of selected customer ($0)!', $limits['domain_limit']);
		}
	}

	if(!$error)
	{
		$DB->Execute('UPDATE domains SET name = ?, ownerid = ?, description = ?,
			master = ?, last_check = ?, type = ?, notified_serial = ?,
			account = ? WHERE id = ?', 
			array(	$domain['name'],
				$domain['ownerid'],
				$domain['description'],
				$domain['master'],
				$domain['last_check'],
				$domain['type'],
				$domain['notified_serial'],
				$domain['account'],
				$domain['id']
				));
		
		// accounts owner update
		if($domain['ownerid'])
			$DB->Execute('UPDATE passwd SET ownerid = ? WHERE domainid = ? AND ownerid != 0',
					array($domain['ownerid'], $domain['id'])); 

		$SESSION->redirect('?m=domainlist');
	}
}

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$SMARTY->assign('error', $error);
$SMARTY->assign('domain', $domain);
$SMARTY->assign('customers', $LMS->GetCustomerNames());
$SMARTY->display('domainedit.html');

?>
