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
 *  $Id: postgres.2009082500.php,v 1.4 2011/01/18 08:12:16 alec Exp $
 */

$DB->BeginTrans();

$DB->Execute("

DROP VIEW customersview;

ALTER TABLE customers ALTER lastname TYPE varchar(128);
ALTER TABLE customers ALTER name TYPE varchar(128);
CREATE INDEX customers_lastname_idx ON customers (lastname, name);

CREATE VIEW customersview AS 
SELECT c.* FROM customers c
	WHERE NOT EXISTS (
		SELECT 1 FROM customerassignments a
		JOIN excludedgroups e ON (a.customergroupid = e.customergroupid)
		WHERE e.userid = lms_current_user() AND a.customerid = c.id);

");

$DB->Execute("UPDATE dbinfo SET keyvalue = ? WHERE keytype = ?", array('2009082500', 'dbversion'));

$DB->CommitTrans();

?>
