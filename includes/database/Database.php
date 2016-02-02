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

class DatabasePDO extends Database
{
	// database
	private     $conn;
	private		$DBPrefix;
	private		$CHARSET;
	private		$lastquery;
	private		$fetchquery;
	private		$error;
	private		$error_supress = false;
	private		$fetch_methods = [];

	public function connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, $CHARSET = 'UTF-8');
	public function error_supress($state = true);
	public function direct_query($query);
	public function query($query, $params = array());
	public function fetch($result = NULL, $method = 'FETCH_ASSOC');
	public function fetchall($result = NULL, $method = 'FETCH_ASSOC');
	public function result($column = NULL, $result = NULL, $method = 'FETCH_ASSOC');
	public function numrows($result = NULL);
	public function lastInsertId();
	private function clean_params($query, $params);
	private function find_key($params, $val);
	private function build_params($params);
	private function error_handler($error);
}
