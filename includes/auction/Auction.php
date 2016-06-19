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

// work in progress
class Auction
{
	protected $auction_data;
	protected $default_data = [];

	public function __construct()
	{
		$this->auction_data = $this->default_data;
	}

	public function __set($variable, $value)
	{
        $this->auction_data[$variable] = $value;
    }

    public function __get($variable)
	{
        if(isset($this->auction_data[$variable]))
		{
            return $this->auction_data[$variable];
        }
		else
		{
            return null;
        }
    }

	protected function setData($data)
	{
		foreach ($data as $k => $v)
		{
			$this->auction_data[$k] = $v;
		}
	}

	public function buildData()
	{
		// TODO: this is the old setvars() function end up with a $data array and push it into setData()
	}

	public function setSessionData()
	{
		foreach ($auction_data as $key => $value)
		{
			$_SESSION['SELL_' . $key] = $value;
		}
	}

	public function clearSessionData()
	{
		foreach ($auction_data as $key => $value)
		{
			if (isset($_SESSION['SELL_' . $key]))
			{
				unset($_SESSION['SELL_' . $key]);
			}
		}
	}

	public function removeAuction()
	{

	}

	public function updateAuction()
	{
		// updateauction()
	}

	public function saveAuction()
	{
		// addauction()
	}

	public function addBid(); // no contained in base class will be in Auction_BIN or Auction_Dutch or Auction_Bid ...
}
