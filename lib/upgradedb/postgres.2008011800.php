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
 *  $Id: postgres.2008011800.php,v 1.4 2011/01/18 08:12:15 alec Exp $
 */

$DB->BeginTrans();

$DB->Execute("
	ALTER TABLE nodes ADD port smallint NOT NULL DEFAULT 0;
	ALTER TABLE netlinks ADD srcport smallint NOT NULL DEFAULT 0;
	ALTER TABLE netlinks ADD dstport smallint NOT NULL DEFAULT 0;
");

$DB->Execute("UPDATE dbinfo SET keyvalue = ? WHERE keytype = ?",array('2008011800', 'dbversion'));

$DB->CommitTrans();

?>
