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

class user
{
	var $user_data, $numbers, $logged_in;

	function user()
	{
		global $_SESSION, $system, $DBPrefix;

		$this->numbers = '1234567890';
		$this->logged_in = false;
		$this->can_sell = false;
		$this->can_buy = false;
		$this->user_data = array();

		if (isset($_SESSION['WEBID_LOGGED_NUMBER']) && isset($_SESSION['WEBID_LOGGED_IN']) && isset($_SESSION['WEBID_LOGGED_PASS']))
		{
			$query = "SELECT * FROM " . $DBPrefix . "users WHERE password = '" . $_SESSION['WEBID_LOGGED_PASS'] . "' AND id = " . $_SESSION['WEBID_LOGGED_IN'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);

			if (mysql_num_rows($res) > 0)
			{
				$user_data = mysql_fetch_array($res);

				if (strspn($user_data['password'], $user_data['hash']) == $_SESSION['WEBID_LOGGED_NUMBER'])
				{
					$this->logged_in = true;
					$this->user_data = $user_data;
					if ($this->user_data['suspended'] != 7)
					{
						// check if user can sell or buy
						if (count($user_data['groups']) < 1)
							$user_data['groups'] = 0; // just in case
						$query = "SELECT can_sell, can_buy FROM " . $DBPrefix . "groups WHERE id IN (" . $user_data['groups'] . ") AND (can_sell = 1 OR can_buy = 1)";
						$res = mysql_query($query);
						$system->check_mysql($res, $query, __LINE__, __FILE__);
						while ($row = mysql_fetch_assoc($res))
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
			$this->check_balance();
		}
	}

	function is_logged_in()
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

	function check_balance()
	{
		global $system, $DBPrefix, $MSG;

		// check if user needs to be suspended
		if ($system->SETTINGS['fee_type'] == 1 && $this->logged_in && $this->user_data['suspended'] != 7 && $system->SETTINGS['fee_disable_acc'] == 'y')
		{
			if ($system->SETTINGS['fee_max_debt'] <= (-1 * $this->user_data['balance']))
			{
				$query = "UPDATE " . $DBPrefix . "users SET suspended = 7 WHERE id = " . $this->user_data['id'];
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

				// send email
				$emailer = new email_handler();
				$emailer->assign_vars(array(
						'SITENAME' => $system->SETTINGS['sitename'],

						'NAME' => $this->user_data['name'],
						'BALANCE' => $system->print_money($this->user_data['balance'], true, false),
						'OUTSTANDING' => $system->SETTINGS['siteurl'] . 'outstanding.php'
						));
				$emailer->email_uid = $this->user_data['id'];
				$emailer->email_sender($this->user_data['email'], 'suspended_balance.inc.php', $system->SETTINGS['sitename'] . ' - ' . $MSG['753']);
			}
		}
	}

	function is_valid_user($id) 
    { 
        global $system, $MSG, $ERR_025, $DBPrefix; 
        $query = "SELECT id FROM " . $DBPrefix . "users WHERE id = " . intval($id); 
        $res = mysql_query($query); 
        $system->check_mysql($res, $query, __LINE__, __FILE__); 
        if (mysql_num_rows($res) == 0) 
        { 
            $_SESSION['msg_title'] = $MSG['415']; 
            $_SESSION['msg_body'] = $ERR_025; 
            header('location: message.php'); 
            exit; 
        } 
    }
}
?>