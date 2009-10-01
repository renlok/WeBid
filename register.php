<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include 'includes/common.inc.php';
include $include_path . 'countries.inc.php';
include $include_path . 'banemails.inc.php';

// check recaptcha is enabled
if ($system->SETTINGS['spam_register'] == 2)
{
	include $include_path . 'captcha/recaptchalib.php';
}
elseif ($system->SETTINGS['spam_register'] == 1)
{
	include $include_path . 'captcha/securimage.php';
}

if ($system->SETTINGS['https'] == 'y' && $_SERVER['HTTPS'] != 'on')
{
	$sslurl = str_replace('http://', 'https://', $system->SETTINGS['siteurl']);
	header('Location: ' . $sslurl . 'register.php');
	exit;
}

function CheckAge($day, $month, $year) // check if the users > 18
{
	$NOW_year = gmdate('Y');
	$NOW_month = gmdate('m');
	$NOW_day = gmdate('d');

	if (($NOW_year - $year) > 18)
	{
		return 1;
	}
	elseif ((($NOW_year - $year) == 18) && ($NOW_month > $month))
	{
		return 1;
	}
	elseif ((($NOW_year - $year) == 18) && ($NOW_month == $month) && ($NOW_day >= $day))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function get_hash()
{
	$string = '0123456789abcdefghijklmnopqrstuvyxz';
	$hash = '';
	for ($i = 0; $i < 5; $i++)
	{
		$rand = rand(0, 35);
		$hash .= $string[$rand];
		$string = str_replace($string[$rand], '', $string);
	}
	return $hash;
}

$TPL_errmsg = '';
$TPL_err = 0;

if (empty($_POST['action']))
{
	$action = 'first';
}
// Retrieve users signup settings
$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);
$DISPLAYED_FIELDS = unserialize($system->SETTINGS['displayed_feilds']);
$spam_html = '';

if ($system->SETTINGS['spam_register'] == 1)
{
	$resp = new Securimage();
	$spam_html = $resp->show_html();
}

if (isset($_POST['action']) && $_POST['action'] == 'first')
{
	if (empty($_POST['TPL_name']))
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5029;
	}
	elseif (empty($_POST['TPL_nick']))
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5030;
	}
	elseif (empty($_POST['TPL_password']))
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5031;
	}
	elseif (empty($_POST['TPL_repeat_password']))
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5032;
	}
	elseif (empty($_POST['TPL_email']))
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5033;
	}
	elseif (empty($_POST['TPL_address']) && $MANDATORY_FIELDS['address'] == 'y')
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5034;
	}
	elseif (empty($_POST['TPL_city']) && $MANDATORY_FIELDS['city'] == 'y')
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5035;
	}
	elseif (empty($_POST['TPL_prov']) && $MANDATORY_FIELDS['prov'] == 'y')
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5036;
	}
	elseif (empty($_POST['TPL_country']) && $MANDATORY_FIELDS['country'] == 'y')
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5037;
	}
	elseif (empty($_POST['TPL_zip']) && $MANDATORY_FIELDS['zip'] == 'y')
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5038;
	}
	elseif (empty($_POST['TPL_phone']) && $MANDATORY_FIELDS['tel'] == 'y')
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5039;
	}
	elseif ((empty($_POST['TPL_day']) || empty($_POST['TPL_month']) || empty($_POST['TPL_year'])) && $MANDATORY_FIELDS['birthdate'] == 'y')
	{
		$TPL_err = 1;
		$TPL_errmsg = $ERR_5040;
	}
	else
	{
		$birth_day = $_POST['TPL_day'];
		$birth_month = $_POST['TPL_month'];
		$birth_year = $_POST['TPL_year'];
		$DATE = $birth_year . $birth_month . $birth_day;

		if ($system->SETTINGS['spam_register'] == 2)
		{
			$resp = recaptcha_check_answer($system->SETTINGS['recaptcha_private'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
		}

		if ($system->SETTINGS['spam_register'] == 2 && !$resp->is_valid)
		{
			$TPL_err = 1;
			$TPL_errmsg = $MSG['752'];
		}
		elseif ($system->SETTINGS['spam_register'] == 1 && !$resp->check($_POST['captcha_code']))
		{
			$TPL_err = 1;
			$TPL_errmsg = $MSG['752'];
		}
		elseif (strlen($_POST['TPL_nick']) < 6)
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_107;
		}
		elseif (strlen ($_POST['TPL_password']) < 6)
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_108;
		}
		elseif ($_POST['TPL_password'] != $_POST['TPL_repeat_password'])
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_109;
		}
		elseif (strlen($_POST['TPL_email']) < 5)
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_110;
		}
		elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['TPL_email']))
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_008;
		}
		elseif (!CheckAge($birth_day, $birth_month, $birth_year) && $MANDATORY_FIELDS['birthdate'] == 'y')
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_113;
		}
		elseif (!empty($birth_month) && !empty($birth_day) && !empty($birth_year) && !checkdate($birth_month, $birth_day, $birth_year))
		{
			$TPL_err = 1;
			$TPL_errmsg = $ERR_117;
		}
		elseif (BannedEmail($_POST['TPL_email'], $BANNEDDOMAINS))
		{
			$TPL_err = 1;
			$TPL_errmsg = $MSG['30_0054'];
		}
		else
		{
			$sql = "SELECT nick FROM " . $DBPrefix . "users WHERE nick = '" . $system->cleanvars($_POST['TPL_nick']) . "'";
			$res = mysql_query($sql);
			$system->check_mysql($res, $sql, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				$TPL_err = 1;
				$TPL_errmsg = $ERR_111; // Selected user already exists
			}
			$query = "SELECT email FROM " . $DBPrefix . "users WHERE email = '" . $system->cleanvars($_POST['TPL_email']) . "'";
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
			if (mysql_num_rows($res) > 0)
			{
				$TPL_err = 1;
				$TPL_errmsg = $ERR_115; // E-mail already used
			}

			if ($TPL_err == 0)
			{
				$TPL_nick_hidden = $_POST['TPL_nick'];
				$TPL_password_hidden = $_POST['TPL_password'];
				$TPL_name_hidden = $_POST['TPL_name'];
				$TPL_email_hidden = $_POST['TPL_email'];
				$SUSPENDED = ($system->SETTINGS['activationtype'] == 2) ? 0 : 8;
				$SUSPENDED = ($system->SETTINGS['activationtype'] == 0) ? 10 : $SUSPENDED;

				$query = "SELECT type FROM " . $DBPrefix . "fees WHERE type = 'signup_fee'";
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$signup_fee = mysql_result($res, 0);
				if ($system->SETTINGS['fee_type'] == 2 && $signup_fee > 0)
				{
					$SUSPENDED = 9;
					$query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers + 1";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				elseif ($system->SETTINGS['activationtype'] == 1 || $system->SETTINGS['activationtype'] == 0)
				{
					$query = "UPDATE " . $DBPrefix . "counters SET inactiveusers = inactiveusers + 1";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				else
				{
					$query = "UPDATE " . $DBPrefix . "counters SET users = users + 1";
					$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				}
				$balance = ($system->SETTINGS['fee_type'] == 2) ? 0 : ($system->SETTINGS['fee_signup_bonus'] - $signup_fee);

				$query = "SELECT id FROM " . $DBPrefix . "groups WHERE auto_join = 1";
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$groups = array();
				while ($row = mysql_fetch_assoc($res))
				{
					$groups[] = $row['id'];
				}
				$hash = get_hash();
				$query = "INSERT INTO " . $DBPrefix . "users
						(nick, password, hash, name, address, city, prov, country, zip, phone,
						nletter, email, reg_date, birthdate, suspended, language, groups, balance, timecorrection)
						VALUES ('" . $system->cleanvars($TPL_nick_hidden) . "',
						'" . md5($MD5_PREFIX . $TPL_password_hidden) . "',
						'" . $hash . "',
						'" . $system->cleanvars($TPL_name_hidden) . "',
						'" . $system->cleanvars($_POST['TPL_address']) . "',
						'" . $system->cleanvars($_POST['TPL_city']) . "',
						'" . $system->cleanvars($_POST['TPL_prov']) . "',
						'" . $system->cleanvars($_POST['TPL_country']) . "',
						'" . $system->cleanvars($_POST['TPL_zip']) . "',
						'" . $system->cleanvars($_POST['TPL_phone']) . "',
						'" . $system->cleanvars($_POST['TPL_nletter']) . "',
						'" . $system->cleanvars($_POST['TPL_email']) . "',
						'" . time() . "',
						'" . ((empty($DATE)) ? $DATE : 0) . "',
						'" . $SUSPENDED . "',
						'" . $language . "',
						'" . implode(',', $groups) . "',
						'" . $balance . "',
						" . $system->SETTINGS['timecorrection'] . ")";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$TPL_id_hidden = mysql_insert_id();
				$query = "INSERT INTO " . $DBPrefix . "usersips VALUES
						  (NULL, " . intval($TPL_id_hidden) . ", '" . $_SERVER['REMOTE_ADDR'] . "', 'first','accept')";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);

				$_SESSION['language'] = $language;
				$first = false;

				if ($system->SETTINGS['activationtype'] == 0)
				{
					include $include_path . 'user_confirmation_needapproval.inc.php';
					$TPL_message = $MSG['016_a'];
				}
				elseif ($system->SETTINGS['activationtype'] == 1)
				{
					include $include_path . 'user_confirmation.inc.php';
					$TPL_message = sprintf($MSG['016'], $TPL_email_hidden);
				}
				else
				{
					$USER = array('name' => $TPL_name_hidden, 'email' => $_POST['TPL_email']);
					include $include_path . 'user_approved.inc.php';
					$TPL_message = $MSG['016_b'];
				}

				if ($system->SETTINGS['fee_type'] == 2 && $signup_fee > 0)
				{
					$_SESSION['signup_id'] = $TPL_id_hidden;
					header('location: pay.php?a=3');
					exit;
				}
			}
		}
	}
}

$country = '';
if (!isset($_POST['action']) || (isset($_POST['action']) && $TPL_err == 1))
{
	$first = true;
	$selcountry = isset($_POST['TPL_country']) ? $_POST['TPL_country'] : '';
	foreach ($countries as $key => $name)
	{
		$country .= '<option value="' . $name . '"';
		if ($name == $selcountry)
		{
			$country .= ' selected';
		}
		elseif ($system->SETTINGS['defaultcountry'] == $name)
		{
			$country .= ' selected';
		}
		$country .= '>' . $name . '</option>' . "\n";
	}
	$dobmonth = '<select name="TPL_month">
			<option value="00"></option>
			<option value="01"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '01') ? ' selected' : '') . '>' . $MSG['MON_001E'] . '</option>
			<option value="02"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '02') ? ' selected' : '') . '>' . $MSG['MON_002E'] . '</option>
			<option value="03"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '03') ? ' selected' : '') . '>' . $MSG['MON_003E'] . '</option>
			<option value="04"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '04') ? ' selected' : '') . '>' . $MSG['MON_004E'] . '</option>
			<option value="05"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '05') ? ' selected' : '') . '>' . $MSG['MON_005E'] . '</option>
			<option value="06"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '06') ? ' selected' : '') . '>' . $MSG['MON_006E'] . '</option>
			<option value="07"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '07') ? ' selected' : '') . '>' . $MSG['MON_007E'] . '</option>
			<option value="08"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '08') ? ' selected' : '') . '>' . $MSG['MON_008E'] . '</option>
			<option value="09"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '09') ? ' selected' : '') . '>' . $MSG['MON_009E'] . '</option>
			<option value="10"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '10') ? ' selected' : '') . '>' . $MSG['MON_010E'] . '</option>
			<option value="11"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '11') ? ' selected' : '') . '>' . $MSG['MON_011E'] . '</option>
			<option value="12"' . ((isset($_POST['TPL_month']) && $_POST['TPL_month'] == '12') ? ' selected' : '') . '>' . $MSG['MON_012E'] . '</option>
		</select>';
	$dobday = '<select name="TPL_day">
			<option value=""></option>';
	for ($i = 1; $i <= 31; $i++)
	{
		$j = (strlen($i) == 1) ? '0' . $i : $i;
		$dobday .= '<option value="' . $j . '"' . ((isset($_POST['TPL_day']) && $_POST['TPL_day'] == $j) ? ' selected' : '') . '>' . $j . '</option>';
	}
	$dobday .= '</select>';
}

$template->assign_vars(array(
		'L_ERROR' => $TPL_errmsg,
		'L_COUNTRIES' => $country,
		'L_ACCEPTANCE' => nl2br(stripslashes($system->SETTINGS['acceptancetext'])),
		'L_DATEFORMAT' => ($system->SETTINGS['datesformat'] == 'USA') ? $dobmonth . ' ' . $dobday : $dobday . ' ' . $dobmonth,
		'L_MESSAGE' => (isset($TPL_message)) ? $TPL_message : '',

		'B_ERRORMSG' => ($TPL_err == 1),
		'B_ADMINAPROVE' => ($system->SETTINGS['activationtype'] == 0),
		'B_NLETTER' => ($system->SETTINGS['newsletter'] == 1),
		'B_SHOWACCEPTANCE' => ($system->SETTINGS['showacceptancetext'] == 1),
		'B_FIRST' => $first,

		'CAPTCHATYPE' => $system->SETTINGS['spam_register'],
		'CAPCHA' => ($system->SETTINGS['spam_register'] == 2) ? recaptcha_get_html($system->SETTINGS['recaptcha_public']) : $spam_html,
		'BIRTHDATE' => ($DISPLAYED_FIELDS['birthdate_regshow'] == 1),
		'ADDRESS' => ($DISPLAYED_FIELDS['address_regshow'] == 1),
		'CITY' => ($DISPLAYED_FIELDS['city_regshow'] == 1),
		'PROV' => ($DISPLAYED_FIELDS['prov_regshow'] == 1),
		'COUNTRY' => ($DISPLAYED_FIELDS['country_regshow'] == 1),
		'ZIP' => ($DISPLAYED_FIELDS['zip_regshow'] == 1),
		'TEL' => ($DISPLAYED_FIELDS['tel_regshow'] == 1),
		'REQUIRED' => array(
					($MANDATORY_FIELDS['birthdate'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['address'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['city'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['prov'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['country'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['zip'] == 'y') ? ' *' : '',
					($MANDATORY_FIELDS['tel'] == 'y') ? ' *' : ''
					),

		'V_YNEWSL' => ((isset($_POST['TPL_nletter']) && $_POST['TPL_nletter'] == 1) || !isset($_POST['TPL_nletter'])) ? 'checked=true' : '',
		'V_NNEWSL' => (isset($_POST['TPL_nletter']) && $_POST['TPL_nletter'] == 2) ? 'checked=true' : '',
		'V_YNAME' => (isset($_POST['TPL_name'])) ? $_POST['TPL_name'] : '',
		'V_UNAME' => (isset($_POST['TPL_nick'])) ? $_POST['TPL_nick'] : '',
		'V_EMAIL' => (isset($_POST['TPL_email'])) ? $_POST['TPL_email'] : '',
		'V_YEAR' => (isset($_POST['TPL_year'])) ? $_POST['TPL_year'] : '',
		'V_ADDRE' => (isset($_POST['TPL_address'])) ? $_POST['TPL_address'] : '',
		'V_CITY' => (isset($_POST['TPL_city'])) ? $_POST['TPL_city'] : '',
		'V_PROV' => (isset($_POST['TPL_prov'])) ? $_POST['TPL_prov'] : '',
		'V_POSTCODE' => (isset($_POST['TPL_zip'])) ? $_POST['TPL_zip'] : '',
		'V_PHONE' => (isset($_POST['TPL_phone'])) ? $_POST['TPL_phone'] : ''
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'register.tpl'
		));
$template->display('body');
include 'footer.php';
?>
