<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
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

class db_handle 
{
	// database
	private     $pdo;
	private		$DBPrefix;
	private		$lastquery;

    public function connect($DbHost, $DbUser, $DbPassword, $DbDatabase, $DBPrefix)
    {
        $this->DBPrefix = $DBPrefix;
		try {
			// MySQL with PDO_MYSQL
			$this->pdo = new PDO("mysql:host=$DbHost;dbname=$DbDatabase", $DbUser, $DbPassword);
			// set error reporting up
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
    }

	// to run a direct query
	public function direct_query($query)
	{
		$this->lastquery = $this->pdo->query(query);
	}

	// put together the quert ready for running
	public function query($type, $table, $params, $select = '*')
	{
		$this->build_query($type, $table, $params, $select);
	}

	// put together the quert ready for running
	public function fetch($method = 'FETCH_ASSOC')
	{
		if ('FETCH_ASSOC') $result = $this->lastquery->fetch(PDO::FETCH_ASSOC);
		if ('FETCH_BOTH') $result = $this->lastquery->fetch(PDO::FETCH_BOTH);
		if ('FETCH_NUM') $result = $this->lastquery->fetch(PDO::FETCH_NUM);
		return $result;
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}

	// build the query to be run
	private function build_query($type, $table, $params, $select)
	{
		if ($type == 'INSERT')
		{
		
		}
		if ($type == 'UPDATE')
		{
		
		}
		if ($type == 'SELECT')
		{
		
		}
		$this->pdo->prepare();
	}

	// close everything down
	public function __destruct()
	{
		// close database connection
		$this->pdo = null;
	}
}
?>