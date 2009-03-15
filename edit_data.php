<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include "includes/config.inc.php";
include $include_path . "countries.inc.php";
// // If user is not logged in redirect to login page
if (!isset($_SESSION['WEBID_LOGGED_IN'])) {
    header("Location: user_login.php");
    exit;
}

// Retrieve users signup settings
$query = "SELECT * FROM " . $DBPrefix . "usersettings";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$MANDATORY_FIELDS = unserialize(mysql_result($res, 0, 'mandatory_fields'));

$TPL_errmsg = '';
if (isset($_POST['action']) && $_POST['action'] == "update") {
    // // Check data
    if ($_POST['TPL_email']) {
        if (strlen($_POST['TPL_password']) < 6 && strlen($_POST['TPL_password']) > 0) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_011;
        } else if ($_POST['TPL_password'] != $_POST['TPL_repeat_password']) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_109;
        } else if (strlen($_POST['TPL_email']) < 5) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_110;
        } elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$", $_POST['TPL_email'])) {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_008;
        } elseif (strlen($_POST['TPL_zip']) < 4 && $MANDATORY_FIELDS['zip'] == 'y') {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_616;
        } elseif (strlen($_POST['TPL_phone']) < 3 && $MANDATORY_FIELDS['tel'] == 'y') {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_617;
        } elseif ((empty($_POST['TPL_day']) || empty($_POST['TPL_month']) || empty($_POST['TPL_year'])) && $MANDATORY_FIELDS['birthdate'] == 'y') {
            $TPL_err = 1;
            $TPL_errmsg = $ERR_5040;
		} else {
			$TPL_birthdate = $_POST['TPL_year'] . $_POST['TPL_month'] . $_POST['TPL_day'];

            $sql = "UPDATE " . $DBPrefix . "users SET email='" . $system->cleanvars($_POST['TPL_email']) . "',
					birthdate = '" . $system->cleanvars($TPL_birthdate) . "',
					address = '" . $system->cleanvars($_POST['TPL_address']) . "',
					city = '" . $system->cleanvars($_POST['TPL_city']) . "',
					prov = '" . $system->cleanvars($_POST['TPL_prov']) . "',
					country = '" . $system->cleanvars($_POST['TPL_country']) . "',
					zip = '" . $system->cleanvars($_POST['TPL_zip']) . "',
					phone = '" . $system->cleanvars($_POST['TPL_phone']) . "',
					nletter = '" . $system->cleanvars($_POST['TPL_nletter']);

            if (strlen($_POST['TPL_password']) > 0) {
                $sql .= "', password='" . md5($MD5_PREFIX . addslashes($_POST['TPL_password']));
            }

            $sql .= "' WHERE id = " . $_SESSION['WEBID_LOGGED_IN'];
            $res = mysql_query ($sql);
            $system->check_mysql($res, $sql, __LINE__, __FILE__);
            $TPL_errmsg = $MSG['183'];
        }
    } else {
        $TPL_errmsg = $ERR_112;
    }
}
// // Retrieve user's data
$query = "SELECT * FROM " . $DBPrefix . "users WHERE id = " . $_SESSION['WEBID_LOGGED_IN'];
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$USER = mysql_fetch_array($result);
$TPL_day = substr($USER['birthdate'], 6, 2);
$TPL_month = substr($USER['birthdate'], 4, 2);
$TPL_year = substr($USER['birthdate'], 0, 4);

$country = '';
while (list($code, $name) = each($countries)) {
    $country .= "<option value=\"$name\"";
    if ($name == $USER['country']) {
        $country .= " selected";
    }
    $country .= ">$name</option>\n";
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
for($i = 1; $i <= 31; $i++) {
	$j = (strlen($i) == 1) ? '0' . $i : $i;
	$dobday .= '<option value="' . $j . '"' . (($TPL_day == $j) ? ' selected' : '') . '>' . $j . '</option>';
}
$dobday .= '</select>';

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
		'DATEFORMAT' => ($system->SETTINGS['datesformat'] == "USA") ? $dobmonth . ' ' . $dobday : $dobday . ' ' . $dobmonth,
        'ERROR' => $TPL_errmsg,

        'NLETTER1' => ($USER['nletter'] == 1) ? ' checked="checked"' : '',
        'NLETTER2' => ($USER['nletter'] == 2) ? ' checked="checked"' : '',

        'B_NEWLETTER' => ($system->SETTINGS['newsletter'] == 1)
        ));

$TMP_usmenutitle = $MSG['509'];
include "header.php";
include "includes/user_cp.php";
$template->set_filenames(array(
        'body' => 'edit_details.html'
        ));
$template->display('body');
include "footer.php";

?>