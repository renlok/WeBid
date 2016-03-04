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
	protected		$fetch_methods = [
		'FETCH_ASSOC' => PDO::FETCH_ASSOC,
		'FETCH_BOTH' => PDO::FETCH_BOTH,
		'FETCH_NUM' => PDO::FETCH_NUM,
	];

	public function connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix, $CHARSET = 'UTF-8')
	{
		$this->DBPrefix = $DBPrefix;
		$this->CHARSET = $CHARSET;
		try {
			// MySQL with PDO_MYSQL
			$this->conn = new PDO("mysql:host=$DbHost;dbname=$DbDatabase;charset =$CHARSET", $DbUser, $DbPassword);
			// set error reporting up
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// actually use prepared statements
			$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			return true;
		}
		catch(PDOException $e) {
			$this->error_handler($e->getMessage());
			return false;
		}
	}

	public function error_supress($state = true)
	{
		$this->error_supress = $state;
	}

	// to run a direct query
	public function direct_query($query)
	{
		try {
			$this->lastquery = $this->conn->query($query);
		}
		catch(PDOException $e) {
			$this->error_handler($e->getMessage());
		}
	}

	// put together the quert ready for running
	/*
	$query must be given like SELECT * FROM table WHERE this = :that AND where = :here
	then $params would holds the values for :that and :here, $table would hold the vlue for :table
	$params = array(
		array(':that', 'that value', PDO::PARAM_STR),
		array(':here', 'here value', PDO::PARAM_INT),
	);
	last value can be left blank more info http://php.net/manual/en/pdostatement.bindparam.php
	*/
	public function query($query, $params = array())
	{
		try {
			//$query = $this->build_query($query, $table);
			$params = $this->build_params($params);
			$params = $this->clean_params($query, $params);
			$this->lastquery = $this->conn->prepare($query);
			//$this->lastquery->bindParam(':table', $this->DBPrefix . $table, PDO::PARAM_STR); // must always be set
			foreach ($params as $val)
			{
				$this->lastquery->bindParam($val[0], $val[1], $val[2]);
			}
			$this->lastquery->execute();
			//$this->lastquery->debugDumpParams();
		}
		catch(PDOException $e) {
			//$this->lastquery->debugDumpParams();
			$this->error_handler($e->getMessage());
		}

		//$this->lastquery->rowCount(); // rows affected
	}

	// put together the quert ready for running
	public function fetch($result = NULL, $method = 'FETCH_ASSOC')
	{
		try {
			// set fetchquery
			if ($this->fetchquery == NULL)
			{
				$this->fetchquery = $this->lastquery;
			}
			if ($result == NULL)
			{
				$result = $this->fetchquery;
			}
			$data = $result->fetch($this->fetch_methods[$method]);
			// clear fetch query
			if ($data == false)
			{
				$this->fetchquery = NULL;
			}
			return $data;
		}
		catch(PDOException $e) {
			$this->error_handler($e->getMessage());
		}
	}

	// put together the quert ready for running + get all results
	public function fetchall($result = NULL, $method = 'FETCH_ASSOC')
	{
		try {
			if ($result == NULL)
			{
				$result = $this->lastquery;
			}
			// set fetchquery
			return $result->fetchAll($this->fetch_methods[$method]);
		}
		catch(PDOException $e) {
			$this->error_handler($e->getMessage());
		}
	}

	public function result($column = NULL, $result = NULL, $method = 'FETCH_ASSOC')
	{
		if ($result == NULL)
		{
			$result = $this->lastquery;
		}
		$data = $result->fetch($this->fetch_methods[$method]);
		if (empty($column) || $column == NULL)
		{
			return $data;
		}
		else
		{
			return $data[$column];
		}
	}

	public function numrows($result = NULL)
	{
		try {
			if ($result == NULL)
			{
				$result = $this->lastquery;
			}
			return $result->rowCount();
		}
		catch(PDOException $e) {
			$this->error_handler($e->getMessage());
		}
	}

	public function lastInsertId()
	{
		try {
			return $this->conn->lastInsertId();
		}
		catch(PDOException $e) {
			$this->error_handler($e->getMessage());
		}
	}

	protected function clean_params($query, $params)
	{
		// find the vars set in the query
		preg_match_all("(:[a-zA-Z0-9_]+)", $query, $set_params);
		$new_params = array();
		foreach ($set_params[0] as $val)
		{
			$key = $this->find_key($params, $val);
			if (isset($key))
				$new_params[] = $params[$key];
		}
		return $new_params;
	}

	protected function find_key($params, $val)
	{
		foreach ($params as $k => $v)
		{
			if ($v[0] == $val)
				return $k;
		}
	}

	protected function build_params($params)
	{
		$PDO_constants = array(
			'int' => PDO::PARAM_INT,
			'str' => PDO::PARAM_STR,
			//'bool' => PDO::PARAM_BOOL, doesn't work, php bug
			'bool' => PDO::PARAM_INT,
			'float' => PDO::PARAM_STR
			);
		// set PDO values to params
		for ($i = 0; $i < count($params); $i++)
		{
			// force float
			if ($params[$i][2] == 'float')
			{
				$params[$i][1] = floatval($params[$i][1]);
			}
			// to fix php bug
			if ($params[$i][2] == 'bool' && $params[$i][1] > 1)
			{
				$params[$i][1] = 1;
			}
			$params[$i][2] = $PDO_constants[$params[$i][2]];
		}
		return $params;
	}

	protected function error_handler($error)
	{
		if (!$this->error_supress)
		{
			// TODO: DO SOMETHING
			$this->error = debug_backtrace();
			//print_r($this->error);
		}
	}

	// close everything down
	public function __destruct()
	{
		// close database connection
		$this->conn = null;
	}
}
