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

define('InAdmin', 1);
$current_page = 'users';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $include_path . 'countries.inc.php';

unset($ERR);
$userid = intval($_REQUEST['userid']);

// Data check
if (empty($userid) || $userid <= 0)
{
	header('location: listusers.php?PAGE=' . intval($_GET['offset']));
	exit;
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

		if (strlen($_POST['password']) > 0 && ($_POST['password'] != $_POST['repeat_password']))
		{
			$ERR = $ERR_006;
		}
		elseif (strlen($_POST['email']) < 5) //Primitive mail check
		{
			$ERR = $ERR_110;
		}
		elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['email']))
		{
			$ERR = $ERR_008;
		}
		elseif (!preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{2,4})$/', $_POST['birthdate']) && $MANDATORY_FIELDS['birthdate'] == 'y')
		{ //Birthdate check
			$ERR = $ERR_043;
		}
		elseif (strlen($_POST['zip']) < 4 && $MANDATORY_FIELDS['zip'] == 'y')
		{ //Primitive zip check
			$ERR = $ERR_616;
		}
		elseif (strlen($_POST['phone']) < 3 && $MANDATORY_FIELDS['tel'] == 'y')
		{ //Primitive phone check
			$ERR = $ERR_617;
		}
		elseif (empty($_POST['address']) && $MANDATORY_FIELDS['address'] == 'y')
		{
			$ERR = $ERR_5034;
		}
		elseif (empty($_POST['city']) && $MANDATORY_FIELDS['city'] == 'y')
		{
			$ERR = $ERR_5035;
		}
		elseif (empty($_POST['prov']) && $MANDATORY_FIELDS['prov'] == 'y')
		{
			$ERR = $ERR_5036;
		}
		elseif (empty($_POST['country']) && $MANDATORY_FIELDS['country'] == 'y')
		{
			$ERR = $ERR_5037;
		}
		elseif (count($_POST['group']) == 0)
		{
			$ERR = $ERR_044;
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
				  name = '" . $system->cleanvars($_POST['name']) . "',
				  email = '" . $system->cleanvars($_POST['email']) . "',
				  address = '" . $system->cleanvars($_POST['address']) . "',
				  city = '" . $system->cleanvars($_POST['city']) . "',
				  prov = '" . $system->cleanvars($_POST['prov']) . "',
				  country = '" . $system->cleanvars($_POST['country']) . "',
				  zip = '" . $system->cleanvars($_POST['zip']) . "',
				  phone = '" . $system->cleanvars($_POST['phone']) . "',
				  birthdate = '" . $system->cleanvars($birthdate) . "',
				  groups = '" . implode(',', $_POST['group']) . "',
				  balance = '" . $system->input_money($_POST['balance']) . "'";
			if (strlen($_POST['password']) > 0)
			{
				$query .=  ", password = '" . md5($MD5_PREFIX . $_POST['password']) . "'";
			}
			$query .=  " WHERE id = " . $userid;
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);

			header('location: listusers.php?PAGE=' . intval($_POST['offset']));
			exit;
		}
	}
	else
	{
		$ERR = $ERR_112;
	}
}

// load the page
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $userid;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$user_data = mysql_fetch_assoc($res);

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

$country_list = '';
foreach ($countries as $code => $descr)
{
	$country_list .= '<option value="' . $descr . '"';
	if ($descr == $user_data['country'])
	{
		$country_list .= ' selected';
	}
	$country_list .= '>' . $descr . '</option>' . "\n";
}

$query = "SELECT id, group_name FROM ". $DBPrefix . "groups";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$usergroups = '';
$groups = explode(',', $user_data['groups']);
while ($row = mysql_fetch_assoc($res))
{
	$member = (in_array($row['id'], $groups)) ? ' checked' : '';
	$usergroups .= '<p><input type="checkbox" name="group[]" value="' . $row['id'] . '"' . $member . '> ' . $row['group_name'] . '</p>';
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'REALNAME' => $user_data['name'],
		'USERNAME' => $user_data['nick'],
		'EMAIL' => $user_data['email'],
		'ADDRESS' => $user_data['address'],
		'CITY' => $user_data['city'],
		'PROV' => $user_data['prov'],
		'ZIP' => $user_data['zip'],
		'COUNTRY' => $user_data['country'],
		'PHONE' => $user_data['phone'],
		'BALANCE' => $user_data['balance'],
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
		
$template->set_filenames(array(
		'body' => 'edituser.tpl'
		));
$template->display('body');
?> 
