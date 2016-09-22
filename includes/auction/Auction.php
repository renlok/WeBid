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
	// array of feilds that must be cleaned on submission and if they can accept html
	private $cleanable = [
		'title' => false,
		'subtitle' => false,
		'description' => true,
		'shipping_terms' => false
	];
	protected $auction_data;
	protected $default_data = [];
	protected $db;

	public function __construct($db)
	{
		$this->db = $db;
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

	// run this before buildDataFromPost
	public function buildDataFromSession()
	{
		global $_SESSION;
		foreach ($_SESSION['WEBID_SELL_DATA'] as $key => $value)
		{
			$this->auction_data[$key] = $value;
		}
	}

	// variables are cleaned on submission
	public function buildDataFromPost($post_data)
	{
		$data = [];
		// TODO: this is the old setvars() function end up with a $data array and push it into setData()
		$this->setData($data);
	}

	public function setSessionData()
	{
		foreach ($auction_data as $key => $value)
		{
			$_SESSION['WEBID_SELL_DATA'][$key] = $value;
		}
	}

	public function clearSessionData()
	{
		foreach ($auction_data as $key => $value)
		{
			if (isset($_SESSION['WEBID_SELL_DATA'][$key]))
			{
				unset($_SESSION['WEBID_SELL_DATA'][$key]);
			}
		}
	}

	// TODO: allow this to take arrays of auction_ids OR a single auction_id
	public function removeAuction($auction_id)
	{
		$catscontrol = new MPTTcategories();
		$params = array();
		$params[] = array(':auc_id', $auction_id, 'int');

		// get auction data
		$query = "SELECT category, num_bids, suspended, closed FROM " . $db->DBPrefix . "auctions WHERE id = :auc_id";
		$db->query($query, $params);
		$auc_data = $db->result();

		if ($auc_data['suspended'] == 2)
		{
			$query = "DELETE FROM `" . $db->DBPrefix . "auction_moderation` WHERE auction_id = :auc_id";
			$db->query($query, $params);
		}

		// Delete related values
		$query = "DELETE FROM " . $db->DBPrefix . "auctions WHERE id = :auc_id";
		$db->query($query, $params);

		// delete bids
		$query = "DELETE FROM " . $db->DBPrefix . "bids WHERE auction = :auc_id";
		$db->query($query, $params);

		// Delete proxybids
		$query = "DELETE FROM " . $db->DBPrefix . "proxybid WHERE itemid = :auc_id";
		$db->query($query, $params);

		// Delete file in counters
		$query = "DELETE FROM " . $db->DBPrefix . "auccounter WHERE auction_id = :auc_id";
		$db->query($query, $params);

		if ($auc_data['suspended'] == 0 && $auc_data['closed'] == 0)
		{
			// update main counters
			$query = "UPDATE " . $db->DBPrefix . "counters SET auctions = (auctions - 1), bids = (bids - :num_bids)";
			$params = array();
			$params[] = array(':num_bids', $auc_data['num_bids'], 'int');
			$db->query($query, $params);

			// update recursive categories
			$query = "SELECT left_id, right_id, level FROM " . $db->DBPrefix . "categories WHERE cat_id = :cat_id";
			$params = array();
			$params[] = array(':cat_id', $auc_data['category'], 'int');
			$db->query($query, $params);

			$parent_node = $db->result();
			$crumbs = $catscontrol->get_bread_crumbs($parent_node['left_id'], $parent_node['right_id']);

			for ($i = 0; $i < count($crumbs); $i++)
			{
				$query = "UPDATE " . $db->DBPrefix . "categories SET sub_counter = sub_counter - 1 WHERE cat_id = :cat_id";
				$params = array();
				$params[] = array(':cat_id', $crumbs[$i]['cat_id'], 'int');
				$db->query($query, $params);
			}
		}

		// Delete auctions images
		if (is_dir(UPLOAD_PATH . $auction_id))
		{
			if ($dir = opendir(UPLOAD_PATH . $auction_id))
			{
				while ($file = readdir($dir))
				{
					if ($file != '.' && $file != '..')
					{
						@unlink(UPLOAD_PATH . $auction_id . '/' . $file);
					}
				}
				closedir($dir);
				rmdir(UPLOAD_PATH . $auction_id);
			}
		}
	}

	public function updateAuction()
	{
		// updateauction()
	}

	public function saveAuction()
	{
		// addauction()
	}

	public function getAuction($auction_id, $select = '*')
	{
		$query = "SELECT " . $select . " FROM " . $db->DBPrefix . "auctions WHERE id = :auc_id";
		$params = array();
		$params[] = array(':auc_id', $auction_id, 'int');
		$db->query($query, $params);
		$auc_data = $db->result();
		return $auc_data;
	}

	public function addBid();
	public function getBidHistory();
}
