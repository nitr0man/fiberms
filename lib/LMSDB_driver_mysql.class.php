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
 *  $Id: LMSDB_driver_mysql.class.php,v 1.62 2011/01/18 08:12:05 alec Exp $
 */

/*
 * To jest pseudo-driver dla LMSDB, dla bazy danych 'mysql'.
 */

class LMSDB_driver_mysql extends LMSDB_common
{
	var $_loaded = TRUE;
	var $_dbtype = 'mysql';

	function LMSDB_driver_mysql($dbhost, $dbuser, $dbpasswd, $dbname)
	{
		if(!extension_loaded('mysql'))
		{
		        trigger_error('MySQL extension not loaded!', E_USER_WARNING);
			$this->_loaded = FALSE;
	                return;
	        }

	    $this->_version .= ' ('.preg_replace('/^.Revision: ([0-9.]+).*/','\1',$this->_revision).'/'.preg_replace('/^.Revision: ([0-9.]+).*/','\1','$Revision: 1.62 $').')';
		$this->Connect($dbhost, $dbuser, $dbpasswd, $dbname);
	}

	function _driver_dbversion()
	{
		return mysql_get_server_info();
	}

	function _driver_connect($dbhost, $dbuser, $dbpasswd, $dbname)
	{
		if($this->_dblink = @mysql_connect($dbhost, $dbuser, $dbpasswd, true))
		{
			$this->_dbhost = $dbhost;
			$this->_dbuser = $dbuser;
			$this->_driver_selectdb($dbname);
		}
		else
		{
			$this->_error = TRUE;
		}

		return $this->_dblink;
	}

	function _driver_shutdown()
	{
		$this->_loaded = FALSE;
		@mysql_close($this->_dblink); // apparently, mysql_close() is automagicly called after end of the script...
	}
	
	function _driver_geterror()
	{
		if($this->_dblink)
			return mysql_error($this->_dblink);
		elseif($this->_query)
			return 'We\'re not connected!';
		else
			return mysql_error();
	}

	function _driver_disconnect()
	{
		return @mysql_close($this->_dblink);
	}
	
	function _driver_selectdb($dbname)
	{
		if($result = mysql_select_db($dbname, $this->_dblink))
			$this->_dbname = $dbname;
		return $result;
	}

	function _driver_execute($query)
	{
		$this->_query = $query;

		if($this->_result = @mysql_query($query, $this->_dblink))
			$this->_error = FALSE;
		else
			$this->_error = TRUE;
		return $this->_result;
	}

	function _driver_fetchrow_assoc($result = NULL)
	{
		if(! $this->_error)
			return mysql_fetch_array($result ? $result : $this->_result, MYSQL_ASSOC);
		else
			return FALSE;
	}

	function _driver_fetchrow_num()
	{
		if(! $this->_error)
			return mysql_fetch_array($this->_result, MYSQL_NUM);
		else
			return FALSE;
	}

	function _driver_affected_rows()
	{
		if(! $this->_error)
			return mysql_affected_rows();
		else
			return FALSE;
	}

	function _driver_num_rows()
	{
		if(! $this->_error)
			return mysql_num_rows($this->_result);
		else
			return FALSE;
	}
	
	function _driver_now()
	{
		return 'UNIX_TIMESTAMP()';
	}

	function _driver_like()
	{
		return 'LIKE';
	}

	function _driver_concat($input)
	{
		$return = implode(', ', $input);
		return 'CONCAT('.$return.')';
	}

	function _driver_listtables()
	{
		return $this->GetCol('SELECT table_name FROM information_schema.tables
	                        WHERE table_type = ? AND table_schema = ?',
				array('BASE TABLE', $this->_dbname));
	}

	function _driver_begintrans()
	{
		return $this->Execute('BEGIN');
	}

	function _driver_committrans()
	{
		return $this->Execute('COMMIT');
	}
	
	function _driver_rollbacktrans()
        {
	        return $this->Execute('ROLLBACK');
	}

	function _driver_locktables($table, $locktype=null)
	{
		$locktype = $locktype ? strtoupper($locktype) : 'WRITE';

		if(is_array($table))
			$this->Execute('LOCK TABLES '.implode(' '.$locktype.', ', $table).' '.$locktype);
		else
			$this->Execute('LOCK TABLES '.$table.' '.$locktype);
	}

	function _driver_unlocktables()
	{
		$this->Execute('UNLOCK TABLES');
	}

	function _driver_lastinsertid($table = NULL)
        {
	        return $this->GetOne('SELECT LAST_INSERT_ID()');
	}

	function _driver_groupconcat($field, $separator = ',')
	{
		return 'GROUP_CONCAT('.$field.' SEPARATOR \''.$separator.'\')';
	}
}

?>
