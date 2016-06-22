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

define('InAdmin', 1);
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

$userid = intval($_REQUEST['userid']);

// Data check
if (empty($userid) || $userid <= 0)
{
	header('location: listusers.php?PAGE=' . intval($_GET['offset']));
	exit;
}

// load the user data
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $userid, 'int');
$db->query($query, $params);
$user_data = $db->result();

if ($user_data['birthdate'] != 0)
{
	$birth_day = substr($user_data['birthdate'], 6, 2);
	$birth_month = substr($user_data['birthdate'], 4, 2);
	$birth_year = substr($user_data['birthdate'], 0, 4);

	if ($system->SETTINGS['datesformat'] == 'USA')
	{
		$birthdate = $birth_month . '/' . $birth_day . '/' . $birth_year;
	}
	else
	{
		$birthdate = $birth_day . '/' . $birth_month . '/' . $birth_year;
	}
}
else
{
	$birthdate = '';
}

// Retrieve users signup settings
$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	if ($_POST['name'] && $_POST['email'])
	{
		if (!empty($_POST['birthdate']))
		{
			$DATE = explode('/', $_POST['birthdate']);
			if ($system->SETTINGS['datesformat'] == 'USA')
			{
				$birth_day = $DATE[1];
				$birth_month = $DATE[0];
				$birth_year = $DATE[2];
			}
			else
			{
				$birth_day = $DATE[0];
				$birth_month = $DATE[1];
				$birth_year = $DATE[2];
			}

			if (strlen($birth_year) == 2)
			{
				$birth_year = '19' . $birth_year;
			}
		}

		if (isset($_POST['balance']))
		{
			$balance_clean = str_replace('-', '', $_POST['balance']);
		}

		if (strlen($_POST['password']) > 0 && ($_POST['password'] != $_POST['repeat_password']))
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_006));
		}
		elseif (strlen($_POST['email']) < 5) //Primitive mail check
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_5033));
		}
		elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_008));
		}
		elseif (!preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{2,4})$/', $_POST['birthdate']) && $MANDATORY_FIELDS['birthdate'] == 'y')
		{ //Birthdate check
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_043));
		}
		elseif (strlen($_POST['zip']) < 4 && $MANDATORY_FIELDS['zip'] == 'y')
		{ //Primitive zip check
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_616));
		}
		elseif (strlen($_POST['phone']) < 3 && $MANDATORY_FIELDS['tel'] == 'y')
		{ //Primitive phone check
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_617));
		}
		elseif (empty($_POST['address']) && $MANDATORY_FIELDS['address'] == 'y')
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_5034));
		}
		elseif (empty($_POST['city']) && $MANDATORY_FIELDS['city'] == 'y')
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_5035));
		}
		elseif (empty($_POST['prov']) && $MANDATORY_FIELDS['prov'] == 'y')
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_5036));
		}
		elseif (empty($_POST['country']) && $MANDATORY_FIELDS['country'] == 'y')
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_5037));
		}
		elseif (empty($_POST['group']))
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_044));
		}
		elseif (empty($_POST['balance']) && $system->SETTINGS['moneydecimals'] != 0)
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_112));
		}
		elseif (!$system->CheckMoney($balance_clean))
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_081));
		}
		else
		{
			if (!empty($_POST['birthdate']))
			{
				$birthdate = $birth_year . $birth_month . $birth_day;
			}
			else
			{
				$birthdate = 0;
			}

			$query = "UPDATE " . $DBPrefix . "users SET
					name = :name,
					email = :email,
					address = :address,
					city = :city,
					prov = :prov,
					country = :country,
					zip = :zip,
					phone = :phone,
					birthdate = :birthdate,
					groups = :groups,
					balance = :balance";
			$params = array();
			$params[] = array(':name', $system->cleanvars($_POST['name']), 'str');
			$params[] = array(':email', $system->cleanvars($_POST['email']), 'str');
			$params[] = array(':birthdate', $birthdate, 'int');
			$params[] = array(':address', $system->cleanvars($_POST['address']), 'str');
			$params[] = array(':city', $system->cleanvars($_POST['city']), 'str');
			$params[] = array(':prov', $system->cleanvars($_POST['prov']), 'str');
			$params[] = array(':country', $system->cleanvars($_POST['country']), 'str');
			$params[] = array(':zip', $system->cleanvars($_POST['zip']), 'str');
			$params[] = array(':phone', $system->cleanvars($_POST['phone']), 'str');
			$params[] = array(':groups', implode(',', $_POST['group']), 'str');
			$params[] = array(':balance', $system->input_money($_POST['balance']), 'float');
			if (strlen($_POST['password']) > 0)
			{
				include PACKAGE_PATH . 'PasswordHash.php';
				$phpass = new PasswordHash(8, false);
				$query .=  ", password = :password";
				$params[] = array(':password', $phpass->HashPassword($_POST['password']), 'str');
			}
			if ($system->SETTINGS['fee_disable_acc'] == 'y' && $user_data['suspended'] != 8 && $user_data['suspended'] != 1)
			{
				// process balance positive and negative allowed and compare to max allowed credit before it is marked/unmarked as suspendeds
				if ($_POST['balance'] >= -$system->SETTINGS['fee_max_debt'])
				{
					$query .=  ", suspended = 0";
				}
				elseif ($_POST['balance'] < -$system->SETTINGS['fee_max_debt'])
				{
					$query .=  ", suspended = 7";
				}
			}
			
			$query .=  " WHERE id = :user_id";
			$params[] = array(':user_id', $userid, 'int');
			$db->query($query, $params);

			header('location: listusers.php?PAGE=' . intval($_POST['offset']));
			exit;
		}
	}
	else
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_112));
	}
}

$query = "SELECT country_id, country FROM " . $DBPrefix . "countries";
$db->direct_query($query);
$countries = $db->fetchall();
$country_list = '';

foreach($countries as $country)
{
	$country_list .= '<option value="' . $country['country'] . '"';
	if ($country['country'] == $user_data['country'])
	{
		$country_list .= ' selected';
	}
	$country_list .= '>' . $country['country'] . '</option>' . "\n";
}

$query = "SELECT id, group_name FROM ". $DBPrefix . "groups";
$db->direct_query($query);
$usergroups = '';
$groups = explode(',', $user_data['groups']);
while ($row = $db->fetch())
{
	$member = (in_array($row['id'], $groups)) ? ' checked' : '';
	$usergroups .= '<p><input type="checkbox" name="group[]" value="' . $row['id'] . '"' . $member . '> ' . $row['group_name'] . '</p>';
}

$template->assign_vars(array(
		'REALNAME' => $user_data['name'],
		'USERNAME' => $user_data['nick'],
		'EMAIL' => $user_data['email'],
		'ADDRESS' => $user_data['address'],
		'CITY' => $user_data['city'],
		'PROV' => $user_data['prov'],
		'ZIP' => $user_data['zip'],
		'COUNTRY' => $user_data['country'],
		'PHONE' => $user_data['phone'],
		'BALANCE' => $system->print_money_nosymbol($user_data['balance']),
		'DOB' => $birthdate,
		'COUNTRY_LIST' => $country_list,
		'ID' => $userid,
		'OFFSET' => $_GET['offset'],
		'USERGROUPS' => $usergroups,
		'REQUIRED' => array(
					($MANDATORY_FIELDS['birthdate'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['address'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['city'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['prov'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['country'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['zip'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['tel'] == 'y') ? ' *' : ''
					)
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'edituser.tpl'
		));
$template->display('body');
include 'footer.php';
?>
