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
 *  $Id: postgres.2004072100.php,v 1.12 2011/01/18 08:12:12 alec Exp $
 */

$DB->Execute("
    BEGIN;
    ALTER TABLE users ADD serviceaddr text;
    ALTER TABLE users ALTER serviceaddr SET DEFAULT '';
    UPDATE users SET serviceaddr='';
    ALTER TABLE users ALTER serviceaddr SET NOT NULL;
    
    UPDATE dbinfo SET keyvalue = '2004072100' WHERE keytype = 'dbversion';
    COMMIT;
");

?>
