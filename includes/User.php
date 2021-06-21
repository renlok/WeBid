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

class User
{
	public $user_data = [];
	public $logged_in = false;
	public $can_sell = false;
	public $can_buy = false;

	function __construct()
	{
		if (!$this->checkLoginSession())
		{
			$this->rememberMeLogin();
		}
		$this->userPermissions();
		$this->checkBalance();
	}
	
	private function rememberMeLogin()
	{
		global $db, $_COOKIE, $DBPrefix, $_SESSION;
		
		if (!$this->logged_in && isset($_COOKIE['WEBID_RM_ID']))
		{
			$query = "SELECT userid FROM " . $DBPrefix . "rememberme WHERE hashkey = :RM_ID";
			$params = array();
			$params[] = array(':RM_ID', alphanumeric($_COOKIE['WEBID_RM_ID']), 'str');
			$db->query($query, $params);
			if ($db->numrows() > 0)
			{
				// generate a random unguessable token
				$_SESSION['csrftoken'] = md5(uniqid(rand(), true));
				$id = $db->result('userid');
				$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
				$params = array();
				$params[] = array(':user_id', $id, 'int');
				$db->query($query, $params);
				if ($db->numrows() > 0)
				{
					$user_data = $db->result();
					$this->user_data = $user_data;
					$_SESSION['WEBID_LOGGED_IN'] 		= $id;
					$_SESSION['WEBID_LOGGED_NUMBER'] 	= strspn($user_data['password'], $user_data['hash']);
					$_SESSION['WEBID_LOGGED_PASS'] 		= $user_data['password'];
					$this->logged_in = true;
					return true;
				}
			}
		}
		return false;
	}
	
	private function checkLoginSession()
	{
		global $DBPrefix, $_SESSION, $db;

		if (isset($_SESSION['WEBID_LOGGED_NUMBER']) && isset($_SESSION['WEBID_LOGGED_IN']) && isset($_SESSION['WEBID_LOGGED_PASS']))
		{
			$query = "SELECT * FROM " . $DBPrefix . "users WHERE password = :pass AND id = :login";
			$params = array();
			$params[] = array(':pass', $_SESSION['WEBID_LOGGED_PASS'], 'str');
			$params[] = array(':login', $_SESSION['WEBID_LOGGED_IN'], 'str');
			$db->query($query, $params);

			if ($db->numrows() > 0)
			{
				$user_data = $db->result();
				
				if (strspn($user_data['password'], $user_data['hash']) == $_SESSION['WEBID_LOGGED_NUMBER'])
				{
					$this->user_data = $user_data;
					$this->logged_in = true;
					return true;
				}
			}
		}
		return false;
	}
	
	private function userPermissions()
	{
		global $DBPrefix, $db;
		if ($this->logged_in)
		{
			if ($this->user_data['suspended'] != 7)
			{
				// check if user can sell or buy
				if (strlen($this->user_data['groups']) > 0)
				{
					$query = "SELECT can_sell, can_buy FROM " . $DBPrefix . "groups WHERE id IN (" . $this->user_data['groups'] . ") AND (can_sell = 1 OR can_buy = 1)";
					$db->direct_query($query);
					while ($row = $db->fetch())
					{
						if ($row['can_sell'] == 1)
						{
							$this->can_sell = true;
						}
						if ($row['can_buy'] == 1)
						{
							$this->can_buy = true;
						}
					}
				}
			}
		}
	}

	public function checkAuth()
	{
		if(isset($_SESSION['csrftoken']))
		{
			# Token should exist as soon as a user is logged in
			if(1 < count($_POST))		# More than 2 parameters in a POST (csrftoken + 1 more) => check
				$valid_req = ($_POST['csrftoken'] == $_SESSION['csrftoken']);
			else
				$valid_req = true;		# Neither GET nor POST params exist => permit
			if(!$valid_req)
            {
                global $MSG, $ERR_077;

                $_SESSION['msg_title'] = $MSG['936'];
                $_SESSION['msg_body'] = $ERR_077;
                    header('location: message.php');
                    exit; // kill the page
            }
		}
		return $this->logged_in;
	}

	public function checkSuspended()
	{
		if (in_array($this->user_data['suspended'], array(5, 6, 7)))
		{
			header('location: message.php');
			exit;
		}
	}

	private function checkBalance()
	{
		global $system, $DBPrefix, $MSG, $db;

		// check if user needs to be suspended
		if ($system->SETTINGS['fee_type'] == 1 && $this->logged_in && $this->user_data['suspended'] != 7 && $system->SETTINGS['fee_disable_acc'] == 'y')
		{
			if ($system->SETTINGS['fee_max_debt'] <= (-1 * $this->user_data['balance']))
			{
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 7 WHERE id = :user_id";
				$params = array();
				$params[] = array(':user_id', $this->user_data['id'], 'int');
				$db->query($query, $params);

				// send email
				$emailer = new email_handler();
				$emailer->assign_vars(array(
						'SITENAME' => $system->SETTINGS['sitename'],

						'NAME' => $this->user_data['name'],
						'BALANCE' => $system->print_money($this->user_data['balance']),
						'OUTSTANDING' => $system->SETTINGS['siteurl'] . 'outstanding.php'
						));
				$emailer->email_uid = $this->user_data['id'];
				$emailer->email_sender($this->user_data['email'], 'suspended_balance.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['753']);
			}
		}
	}

	public function checkUserValid($id)
	{
		global $system, $MSG, $ERR_025, $DBPrefix, $db;

		$query = "SELECT id FROM " . $DBPrefix . "users WHERE id = :user_id";
		$params = array();
		$params[] = array(':user_id', $id, 'int');
		$db->query($query, $params);
		if ($db->numrows() == 0)
		{
			$_SESSION['msg_title'] = $MSG['415'];
			$_SESSION['msg_body'] = $ERR_025;
			header('location: message.php');
			exit;
		}
	}
}
