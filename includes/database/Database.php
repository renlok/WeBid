<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2016 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if (!defined('InWeBid')) exit('Access denied');

abstract class Database
{
	// database
	protected		$conn;
	protected		$DBPrefix;
	protected		$CHARSET;
	protected		$lastquery;
	protected		$fetchquery;
	protected		$error;
	protected		$error_supress = false;
	protected		$fetch_methods = [];

	abstract public function connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, $CHARSET = 'UTF-8');
	abstract public function error_supress($state = true);
	abstract public function direct_query($query);
	abstract public function query($query, $params = array());
	abstract public function fetch($result = NULL, $method = 'FETCH_ASSOC');
	abstract public function fetchall($result = NULL, $method = 'FETCH_ASSOC');
	abstract public function result($column = NULL, $result = NULL, $method = 'FETCH_ASSOC');
	abstract public function numrows($result = NULL);
	abstract public function lastInsertId();
	abstract protected function clean_params($query, $params);
	abstract protected function find_key($params, $val);
	abstract protected function build_params($params);
	abstract protected function error_handler($error);
}
