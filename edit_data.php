<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
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
include INCLUDE_PATH . 'config/timezones.php';
include INCLUDE_PATH . 'config/gateways.php';

unset($ERR);

// If user is not logged in redirect to login page
if (!$user->checkAuth()) {
    $_SESSION['LOGIN_MESSAGE'] = $MSG['5000'];
    $_SESSION['REDIRECT_AFTER_LOGIN'] = 'edit_data.php';
    header('location: user_login.php');
    exit;
}

// Retrieve users signup settings
$MANDATORY_FIELDS = unserialize($system->SETTINGS['mandatory_fields']);

function generateSelect($name, $options, $selectsetting)
{
    $html = '<select name="' . $name . '">';
    foreach ($options as $option => $value) {
        if ($selectsetting == $option) {
            $html .= '<option value=' . $option . ' selected>' . $value . '</option>';
        } else {
            $html .= '<option value=' . $option . '>' . $value . '</option>';
        }
    }
    $html .= '</select>';
    return $html;
}

$query = "SELECT * FROM " . $DBPrefix . "payment_options WHERE is_gateway = 1";
$db->direct_query($query);
$gateway_data = $db->fetchAll();

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Check data
    if ($_POST['TPL_email']) {
        if (strlen($_POST['TPL_password']) < 6 && strlen($_POST['TPL_password']) > 0) {
            $ERR = $ERR_011;
        } elseif ($_POST['TPL_password'] != $_POST['TPL_repeat_password']) {
            $ERR = $ERR_109;
        } elseif (strlen($_POST['TPL_email']) < 5) {
            $ERR = $ERR_110;
        } elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i', $_POST['TPL_email'])) {
            $ERR = $ERR_008;
        } elseif (strlen($_POST['TPL_zip']) < 4 && $MANDATORY_FIELDS['zip'] == 'y') {
            $ERR = $ERR_616;
        } elseif (strlen($_POST['TPL_phone']) < 3 && $MANDATORY_FIELDS['tel'] == 'y') {
            $ERR = $ERR_617;
        } elseif ((empty($_POST['TPL_day']) || empty($_POST['TPL_month']) || empty($_POST['TPL_year'])) && $MANDATORY_FIELDS['birthdate'] == 'y') {
            $ERR = $MSG['948'];
        } elseif (!empty($_POST['TPL_day']) && !empty($_POST['TPL_month']) && !empty($_POST['TPL_year']) && !checkdate($_POST['TPL_month'], $_POST['TPL_day'], $_POST['TPL_year'])) {
            $ERR = $ERR_117;
        }
        foreach ($gateway_data as $gateway) {
            if ($gateway['gateway_required'] == 1 && isset($_POST[$gateway['name']]['address']) && empty($_POST[$gateway['name']]['address'])) {
                $ERR = $error_string[$gateway['name']];
            }
        }
        if (!isset($ERR)) {
            if (!empty($_POST['TPL_day']) && !empty($_POST['TPL_month']) && !empty($_POST['TPL_year'])) {
                $TPL_birthdate = $_POST['TPL_year'] . $_POST['TPL_month'] . $_POST['TPL_day'];
            } else {
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
					timezone = :timezone,
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
            $params[] = array(':timezone', $_POST['TPL_timezone'], 'str');
            $params[] = array(':emailtype', $system->cleanvars($_POST['TPL_emailtype']), 'str');
            $params[] = array(':nletter', $system->cleanvars($_POST['TPL_nletter']), 'str');

            if (strlen($_POST['TPL_password']) > 0) {
                // hash the password
                include PACKAGE_PATH . 'PasswordHash.php';
                $phpass = new PasswordHash(8, false);
                $query .= ", password = :password";
                $params[] = array(':password', $phpass->HashPassword($_POST['TPL_password']), 'str');
            }

            $query .= " WHERE id = :user_id";
            $params[] = array(':user_id', $user->user_data['id'], 'int');
            $db->query($query, $params);

            foreach ($gateway_data as $gateway) {
                if (isset($_POST[$gateway['name']]['address']) && !empty($_POST[$gateway['name']]['address'])) {
                    $params = array();
                    $query = "SELECT COUNT(id) as COUNT FROM " . $DBPrefix . "usergateways WHERE gateway_id = :gateway_id AND user_id = :user_id";
                    $params[] = array(':user_id', $user->user_data['id'], 'int');
                    $params[] = array(':gateway_id', $gateway['id'], 'int');
                    $db->query($query, $params);
                    $usergateways = $db->result();
                    if ($usergateways['COUNT'] == 0) {
                        $query = "INSERT INTO " . $DBPrefix . "usergateways (gateway_id, user_id, address, password) VALUES (:gateway_id, :user_id, :address, :password)";
                    } else {
                        $query = "UPDATE " . $DBPrefix . "usergateways SET address = :address, password = :password
								WHERE gateway_id = :gateway_id AND user_id = :user_id";
                    }
                    $params[] = array(':address', ((isset($_POST[$gateway['name']]['address'])) ? $system->cleanvars($_POST[$gateway['name']]['address']) : ''), 'str');
                    $params[] = array(':password', ((isset($_POST[$gateway['name']]['password'])) ? $system->cleanvars($_POST[$gateway['name']]['password']) : ''), 'str');
                    $db->query($query, $params);
                }
            }

            $ERR = $MSG['183'];
        }
    } else {
        $ERR = $ERR_112;
    }
}

// Retrieve user's data
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = :user_id";
$params = array();
$params[] = array(':user_id', $user->user_data['id'], 'int');
$db->query($query, $params);
$USER = $db->result();
if ($USER['birthdate'] != 0) {
    $TPL_day = substr($USER['birthdate'], 6, 2);
    $TPL_month = substr($USER['birthdate'], 4, 2);
    $TPL_year = substr($USER['birthdate'], 0, 4);
} else {
    $TPL_day = '';
    $TPL_month = '';
    $TPL_year = '';
}

$query = "SELECT country_id, country FROM " . $DBPrefix . "countries";
$db->direct_query($query);
$countries = $db->fetchall();
$country_list = '';

foreach ($countries as $country) {
    $country_list .= '<option value="' . $country['country'] . '"';
    if ($country['country'] == $USER['country']) {
        $country_list .= ' selected';
    }
    $country_list .= '>' . $country['country'] . '</option>' . "\n";
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
for ($i = 1; $i <= 31; $i++) {
    $j = (strlen($i) == 1) ? '0' . $i : $i;
    $dobday .= '<option value="' . $j . '"' . (($TPL_day == $j) ? ' selected' : '') . '>' . $j . '</option>';
}
$dobday .= '</select>';

$time_correction = generateSelect('TPL_timezone', $timezones, $USER['timezone']);

$query = "SELECT * FROM " . $DBPrefix . "payment_options po LEFT JOIN " . $DBPrefix . "usergateways ug ON (po.id = ug.gateway_id AND ug.user_id = " . $user->user_data['id'] . ") WHERE po.is_gateway = 1";
$db->direct_query($query);
$gateway_data = $db->fetchAll();

foreach ($gateway_data as $gateway) {
    if ($gateway['gateway_active'] == 1) {
        $template->assign_block_vars('gateways', array(
                'GATEWAY_ID' => $gateway['id'],
                'NAME' => $gateway['displayname'],
                'PLAIN_NAME' => $gateway['name'],
                'REQUIRED' => ($gateway['gateway_required'] == 1) ? '*' : '',
                'ADDRESS' => (!is_null($gateway['address'])) ? $gateway['address'] : '',
                'PASSWORD' => (!is_null($gateway['password'])) ? $gateway['password'] : '',
                'ADDRESS_NAME' => isset($address_string[$gateway['name']]) ? $address_string[$gateway['name']] : $gateway['name'],
                'PASSWORD_NAME' => isset($password_string[$gateway['name']]) ? $password_string[$gateway['name']] : '',
                'ERROR_STRING' => $error_string[$gateway['name']],

                'B_PASSWORD' => isset($password_string[$gateway['name']])
                ));
    }
}

$template->assign_vars(array(
        'COUNTRYLIST' => $country_list,
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

        'NLETTER1' => ($USER['nletter'] == 1) ? ' checked="checked"' : '',
        'NLETTER2' => ($USER['nletter'] == 2) ? ' checked="checked"' : '',
        'EMAILTYPE1' => ($USER['emailtype'] == 'html') ? ' checked="checked"' : '',
        'EMAILTYPE2' => ($USER['emailtype'] == 'text') ? ' checked="checked"' : '',

        'B_NEWLETTER' => ($system->SETTINGS['newsletter'] == 1)
        ));

$TMP_usmenutitle = $MSG['509'];
include 'header.php';
include INCLUDE_PATH . 'user_cp.php';
$template->set_filenames(array(
        'body' => 'edit_data.tpl'
        ));
$template->display('body');
include 'footer.php';
