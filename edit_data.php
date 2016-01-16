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

include 'common.php';
include $main_path . 'language/' . $language . '/countries.inc.php';

// If user is not logged in redirect to login page
if (!$user->is_logged_in())
{
	$_SESSION['REDIRECT_AFTER_LOGIN'] = 'edit_data.php';
	header('location: user_login.php');
	exit;
}

// Retrieve users signup settings
$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);

function generateSelect($name = '', $options = array())
{
	global $selectsetting;
	$html = '<select name="' . $name . '">';
	foreach ($options as $option => $value)
	{
		if ($selectsetting == $option)
		{
			$html .= '<option value=' . $option . ' selected>' . $value . '</option>';
		}
		else
		{
			$html .= '<option value=' . $option . '>' . $value . '</option>';
		}
	}
	$html .= '</select>';
	return $html;
}

$TIMECORRECTION = array();
for ($i = 12; $i > -13; $i--)
{
	$TIMECORRECTION[$i] = $MSG['TZ_' . $i];
}

$query = "SELECT * FROM " . $DBPrefix . "gateways LIMIT 1";
$db->direct_query($query);
$gateway_data = $db->result();

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	// Check data
	if ($_POST['TPL_email'])
	{
		if (strlen($_POST['TPL_password']) < 6 && strlen($_POST['TPL_password']) > 0)
		{
			$ERR = $ERR_011;
		}
		elseif ($_POST['TPL_password'] != $_POST['TPL_repeat_password'])
		{
			$ERR = $ERR_109;
		}
		elseif (strlen($_POST['TPL_email']) < 5)
		{
			$ERR = $ERR_110;
		}
		elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_email']))
		{
			$ERR = $ERR_008;
		}
		elseif (strlen($_POST['TPL_zip']) < 4 && $MANDATORY_FIELDS['zip'] == 'y')
		{
			$ERR = $ERR_616;
		}
		elseif (strlen($_POST['TPL_phone']) < 3 && $MANDATORY_FIELDS['tel'] == 'y')
		{
			$ERR = $ERR_617;
		}
		elseif ((empty($_POST['TPL_day']) || empty($_POST['TPL_month']) || empty($_POST['TPL_year'])) && $MANDATORY_FIELDS['birthdate'] == 'y')
		{
			$ERR = $MSG['948'];
		}
		elseif (!empty($_POST['TPL_day']) && !empty($_POST['TPL_month']) && !empty($_POST['TPL_year']) && !checkdate($_POST['TPL_month'], $_POST['TPL_day'], $_POST['TPL_year']))
		{
			$ERR = $ERR_117;
		}
		elseif ($gateway_data['paypal_required'] == 1 && (empty($_POST['TPL_pp_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_pp_email'])))
		{
			$ERR = $MSG['810'];
		}
		elseif ($gateway_data['authnet_required'] == 1 && (empty($_POST['TPL_authnet_id']) || empty($_POST['TPL_authnet_pass'])))
		{
			$ERR = $MSG['811'];
		}
		elseif ($gateway_data['moneybookers_required'] == 1 && (empty($_POST['TPL_moneybookers_email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_moneybookers_email'])))
		{
			$ERR = $MSG['822'];
		}
		elseif ($gateway_data['toocheckout_required'] == 1 && (empty($_POST['TPL_toocheckout_id'])))
		{
			$ERR = $MSG['821'];
		}
		elseif ($gateway_data['worldpay_required'] == 1 && (empty($_POST['TPL_worldpay_id'])))
		{
			$ERR = $MSG['823'];
		}
		else
		{
			if (!empty($_POST['TPL_day']) && !empty($_POST['TPL_month']) && !empty($_POST['TPL_year']))
			{
				$TPL_birthdate = $_POST['TPL_year'] . $_POST['TPL_month'] . $_POST['TPL_day'];
			}
			else
			{
				$TPL_birthdate = '';
			}

			$query = "UPDATE " . $DBPrefix . "users SET email = :email,
					birthdate = :birthdate,
					address = :address,
					city = :city,
					prov = :prov,
					country = :country,
					zip = :zip,
					phone = :phone,
					timecorrection = :timecorrection,
					emailtype = :emailtype,
					nletter = :nletter";
			$params = array();
			$params[] = array(':email', $system->cleanvars($_POST['TPL_email']), 'str');
			$params[] = array(':birthdate', ((empty($TPL_birthdate)) ? 0 : $TPL_birthdate), 'int');
			$params[] = array(':address', $system->cleanvars($_POST['TPL_address']), 'str');
			$params[] = array(':city', $system->cleanvars($_POST['TPL_city']), 'str');
			$params[] = array(':prov', $system->cleanvars($_POST['TPL_prov']), 'str');
			$params[] = array(':country', $system->cleanvars($_POST['TPL_country']), 'str');
			$params[] = array(':zip', $system->cleanvars($_POST['TPL_zip']), 'str');
			$params[] = array(':phone', $system->cleanvars($_POST['TPL_phone']), 'str');
			$params[] = array(':timecorrection', $_POST['TPL_timezone'], 'float');
			$params[] = array(':emailtype', $system->cleanvars($_POST['TPL_emailtype']), 'str');
			$params[] = array(':nletter', $system->cleanvars($_POST['TPL_nletter']), 'str');

			if ($gateway_data['paypal_active'] == 1)
			{
				$query .= ", paypal_email = :paypal_email";
				$params[] = array(':paypal_email', $system->cleanvars($_POST['TPL_pp_email']), 'str');
			}

			if ($gateway_data['authnet_active'] == 1)
			{
				$query .= ", authnet_id = :authnet_id,
							authnet_pass = :authnet_pass";
				$params[] = array(':authnet_id', $system->cleanvars($_POST['TPL_authnet_id']), 'str');
				$params[] = array(':authnet_pass', $system->cleanvars($_POST['TPL_authnet_pass']), 'str');
			}

			if ($gateway_data['worldpay_active'] == 1)
			{
				$query .= ", worldpay_id = :worldpay_id";
				$params[] = array(':worldpay_id', $system->cleanvars($_POST['TPL_worldpay_id']), 'str');
			}

			if ($gateway_data['moneybookers_active'] == 1)
			{
				$query .= ", moneybookers_email = :moneybookers_email";
				$params[] = array(':moneybookers_email', $system->cleanvars($_POST['TPL_moneybookers_email']), 'str');
			}

			if ($gateway_data['toocheckout_active'] == 1)
			{
				$query .= ", toocheckout_id = :toocheckout_id";
				$params[] = array(':toocheckout_id', $system->cleanvars($_POST['TPL_toocheckout_id']), 'str');
			}

			if (strlen($_POST['TPL_password']) > 0)
			{
				// hash the password
				include $include_path . 'PasswordHash.php';
				$phpass = new PasswordHash(8, false);
				$query .= ", password = :password";
				$params[] = array(':password', $phpass->HashPassword($_POST['TPL_password']), 'str');
			}

			$query .= " WHERE id = :user_id";
			$params[] = array(':user_id', $user->user_data['id'], 'int');
			$db->query($query, $params);
			$ERR = $MSG['183'];
		}
	}
	else
	{
		$ERR = $ERR_112;
	}
}

// Retrieve user's data
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$USER = $db->result();
if ($USER['birthdate'] != 0)
{
	$TPL_day = substr($USER['birthdate'], 6, 2);
	$TPL_month = substr($USER['birthdate'], 4, 2);
	$TPL_year = substr($USER['birthdate'], 0, 4);
}
else
{
	$TPL_day = '';
	$TPL_month = '';
	$TPL_year = '';
}

$country = '';
foreach ($countries as $code => $name)
{
	$country .= '<option value="' . $name . '"';
	if ($name == $USER['country'])
	{
		$country .= ' selected';
	}
	$country .= '>' . $name . '</option>' . "\n";
}
$dobmonth = '<select name="TPL_month">
		<option value=""></option>
		<option value="01"' . (($TPL_month == '01') ? ' selected' : '') . '>' . $MSG['MON_001E'] . '</option>
		<option value="02"' . (($TPL_month == '02') ? ' selected' : '') . '>' . $MSG['MON_002E'] . '</option>
		<option value="03"' . (($TPL_month == '03') ? ' selected' : '') . '>' . $MSG['MON_003E'] . '</option>
		<option value="04"' . (($TPL_month == '04') ? ' selected' : '') . '>' . $MSG['MON_004E'] . '</option>
		<option value="05"' . (($TPL_month == '05') ? ' selected' : '') . '>' . $MSG['MON_005E'] . '</option>
		<option value="06"' . (($TPL_month == '06') ? ' selected' : '') . '>' . $MSG['MON_006E'] . '</option>
		<option value="07"' . (($TPL_month == '07') ? ' selected' : '') . '>' . $MSG['MON_007E'] . '</option>
		<option value="08"' . (($TPL_month == '08') ? ' selected' : '') . '>' . $MSG['MON_008E'] . '</option>
		<option value="09"' . (($TPL_month == '09') ? ' selected' : '') . '>' . $MSG['MON_009E'] . '</option>
		<option value="10"' . (($TPL_month == '10') ? ' selected' : '') . '>' . $MSG['MON_010E'] . '</option>
		<option value="11"' . (($TPL_month == '11') ? ' selected' : '') . '>' . $MSG['MON_011E'] . '</option>
		<option value="12"' . (($TPL_month == '12') ? ' selected' : '') . '>' . $MSG['MON_012E'] . '</option>
	</select>';
$dobday = '<select name="TPL_day">
		<option value=""></option>';
for ($i = 1; $i <= 31; $i++)
{
	$j = (strlen($i) == 1) ? '0' . $i : $i;
	$dobday .= '<option value="' . $j . '"' . (($TPL_day == $j) ? ' selected' : '') . '>' . $j . '</option>';
}
$dobday .= '</select>';

$selectsetting = $USER['timecorrection'];
$time_correction = generateSelect('TPL_timezone', $TIMECORRECTION);

$template->assign_vars(array(
		'COUNTRYLIST' => $country,
		'NAME' => $USER['name'],
		'NICK' => $USER['nick'],
		'EMAIL' => $USER['email'],
		'YEAR' => $TPL_year,
		'ADDRESS' => $USER['address'],
		'CITY' => $USER['city'],
		'PROV' => $USER['prov'],
		'ZIP' => $USER['zip'],
		'PHONE' => $USER['phone'],
		'DATEFORMAT' => ($system->SETTINGS['datesformat'] == 'USA') ? $dobmonth . ' ' . $dobday : $dobday . ' ' . $dobmonth,
		'TIMEZONE' => $time_correction,

		//payment stuff
		'PP_EMAIL' => $USER['paypal_email'],
		'AN_ID' => $USER['authnet_id'],
		'AN_PASS' => $USER['authnet_pass'],
		'WP_ID' => $USER['worldpay_id'],
		'TC_ID' => $USER['toocheckout_id'],
		'MB_EMAIL' => $USER['moneybookers_email'],

		'NLETTER1' => ($USER['nletter'] == 1) ? ' checked="checked"' : '',
		'NLETTER2' => ($USER['nletter'] == 2) ? ' checked="checked"' : '',
		'EMAILTYPE1' => ($USER['emailtype'] == 'html') ? ' checked="checked"' : '',
		'EMAILTYPE2' => ($USER['emailtype'] == 'text') ? ' checked="checked"' : '',

		'B_NEWLETTER' => ($system->SETTINGS['newsletter'] == 1),
		'B_PAYPAL' => ($gateway_data['paypal_active'] == 1),
		'B_AUTHNET' => ($gateway_data['authnet_active'] == 1),
		'B_WORLDPAY' => ($gateway_data['worldpay_active'] == 1),
		'B_TOOCHECKOUT' => ($gateway_data['toocheckout_active'] == 1),
		'B_MONEYBOOKERS' => ($gateway_data['moneybookers_active'] == 1)
		));

$TMP_usmenutitle = $MSG['509'];
include 'header.php';
include $include_path . 'user_cp.php';
$template->set_filenames(array(
		'body' => 'edit_data.tpl'
		));
$template->display('body');
include 'footer.php';