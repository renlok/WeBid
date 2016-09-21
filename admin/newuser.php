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

		if ($_POST['password'] == '')
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_004));
		}
		elseif (strlen($_POST['password']) < 6)
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_011));
		}
		elseif ($_POST['password'] != $_POST['repeat_password'])
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_006));
		}
		elseif ($_POST['username'] == '')
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_003));
		}
		elseif (strlen($_POST['username']) < 6)
		{
			$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_010));
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

			$query = "INSERT INTO " . $DBPrefix . "users (name, nick, email, address, city, prov, country, zip, phone, birthdate, groups, balance, password)
					VALUES (:name, :nick, :email, :address, :city, :prov, :country, :zip, :phone, :birthdate, :groups, :balance, :password)";
			$params = array();
			$params[] = array(':name', $system->cleanvars($_POST['name']), 'str');
			$params[] = array(':nick', $system->cleanvars($_POST['username']), 'str');
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
			// generate password hash
			include PACKAGE_PATH . 'PasswordHash.php';
			$phpass = new PasswordHash(8, false);
			$params[] = array(':password', $phpass->HashPassword($_POST['password']), 'str');
			$db->query($query, $params);

			header('location: listusers.php');
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
	if (isset($_POST['country']) && $country['country'] == $_POST['country'])
	{
		$country_list .= ' selected';
	}
	$country_list .= '>' . $country['country'] . '</option>' . "\n";
}

$query = "SELECT id, group_name FROM ". $DBPrefix . "groups";
$db->direct_query($query);
$usergroups = '';
$groups = (isset($_POST['group'])) ? $_POST['group'] : [];
while ($row = $db->fetch())
{
	$member = (in_array($row['id'], $groups)) ? ' checked' : '';
	$usergroups .= '<p><input type="checkbox" name="group[]" value="' . $row['id'] . '"' . $member . '> ' . $row['group_name'] . '</p>';
}

$template->assign_vars(array(
		'REALNAME' => (isset($_POST['name'])) ? $_POST['name'] : '',
		'USERNAME' => (isset($_POST['username'])) ? $_POST['username'] : '',
		'EMAIL' => (isset($_POST['email'])) ? $_POST['email'] : '',
		'ADDRESS' => (isset($_POST['address'])) ? $_POST['address'] : '',
		'CITY' => (isset($_POST['city'])) ? $_POST['city'] : '',
		'PROV' => (isset($_POST['prov'])) ? $_POST['prov'] : '',
		'ZIP' => (isset($_POST['zip'])) ? $_POST['zip'] : '',
		'COUNTRY' => (isset($_POST['country'])) ? $_POST['country'] : '',
		'PHONE' => (isset($_POST['phone'])) ? $_POST['phone'] : '',
		'BALANCE' => $system->print_money_nosymbol((isset($_POST[''])) ? $_POST['balance'] : 0.00),
		'DOB' => (isset($_POST['birthdate'])) ? $_POST['birthdate'] : '',
		'COUNTRY_LIST' => $country_list,
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
		'body' => 'newuser.tpl'
		));
$template->display('body');
include 'footer.php';
?>
