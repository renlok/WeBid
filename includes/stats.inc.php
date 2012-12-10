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
 
if (!defined('InWeBid')) exit();

include $include_path . 'useragent.inc.php';

// Retrieve stats settings
$query = "SELECT * FROM " . $DBPrefix . "statssettings";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$STATSSETTINGS = mysql_fetch_array($res);

$THISDAY	= gmdate('d');
$THISMONTH	= gmdate('m');
$THISYEAR	= gmdate('Y');

if ($STATSSETTINGS['activate'] == 'y')
{
	// Users accesses
	if ($STATSSETTINGS['accesses'] == 'y')
	{		
		// check cookies and session vars
		if (isset($_SESSION['USER_STATS_SESSION']))
		{
			$UPDATESESSION = FALSE;
		}
		else
		{
			$USER_STATS_SESSION = time();
			$_SESSION['USER_STATS_SESSION'] = $USER_STATS_SESSION;
			$UPDATESESSION = TRUE;
		}
		
		// check cookies and session vars
		$Cookie = 'uniqueuser';
		if (isset($_COOKIE[$Cookie]))
		{
			$UPDATECOOKIE = FALSE;
		}
		else
		{
			// Get left seconds to the end of the month
			$exp = GetLeftSeconds();
			setcookie($Cookie, time(), time() + $exp);
			$UPDATECOOKIE = TRUE;
		}
		
		$query = "SELECT day, month FROM " . $DBPrefix . "currentaccesses WHERE day = " . $THISDAY . " AND month = " . $THISMONTH;
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "currentaccesses VALUES (
					  " . $THISDAY . ", " . $THISMONTH . ", " . $THISYEAR . ", 0, 0, 0)";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		
		$query = "UPDATE " . $DBPrefix . "currentaccesses SET pageviews = pageviews + 1";
		if ($UPDATESESSION)
		{
			$query .= ", usersessions = usersessions + 1";
		}
		if ($UPDATECOOKIE)
		{
			$query .= ", uniquevisitors = uniquevisitors + 1";
		}
		$query .= " WHERE day = " . $THISDAY . " AND month = " . $THISMONTH . " AND year = " . $THISYEAR;
		$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		// End users accesses
	}

	// Get user's agent and platform
	$browser_info = browser_detection('full');
	$browser_info[] = browser_detection('moz_version');
	//var_dump($browser_info);

	$os = '';
	switch ($browser_info[5])
	{
		case 'win':
			$os .= 'Windows ';
			break;
		case 'nt':
			$os .= 'Windows NT ';
			break;
		case 'lin':
			$os .= 'Linux ';
			break;
		case 'mac':
			$os .= 'Mac ';
			break;
		case 'unix':
			$os .= 'Unix Version: ';
			break;
		default:
			$os .= $browser_info[5];
	}
	
	if ($browser_info[5] == 'nt')
	{
		if ($browser_info[6] == 5)
		{
			$os .= '5.0 (Windows 2000)';
		}
		elseif ($browser_info[6] == 5.1)
		{
			$os .= '5.1 (Windows XP)';
		}
		elseif ($browser_info[6] == 5.2)
		{
			$os .= '5.2 (Windows XP x64 Edition or Windows Server 2003)';
		}
		elseif ($browser_info[6] == 6.0)
		{
			$os .= '6.0 (Windows Vista)';
		}
		elseif ($browser_info[6] == 6.1)
		{
			$os .= '6.1 (Windows 7)';
		}
	}
	elseif (($browser_info[5] == 'mac') && ($browser_info[6] >= 10))
	{
		$os .=  'OS X';
	}
	elseif ($browser_info[5] == 'lin')
	{
		$os .= ( $browser_info[6] != '' ) ? 'Distro: ' . ucfirst ($browser_info[6] ) : 'Smart Move!!!';
	}
	elseif ($browser_info[6] == '')
	{
		$os .=  ' (version unknown)';
	}
	else
	{
		$os .=  strtoupper( $browser_info[6] );
	}
	
	$browser = '';
	if ($browser_info[0] == 'moz')
	{
		$a_temp = $browser_info[count($browser_info) - 1]; // use the last item in array, the moz array
		$browser .= ($a_temp[0] != 'mozilla') ? 'Mozilla/ ' . ucfirst($a_temp[0]) . ' ' : ucfirst($a_temp[0]) . ' ';
		$browser .= $a_temp[1];
		/* not really needed in this much detail
		$browser .= 'ProductSub: ';
		$browser .= ($a_temp[4] != '') ? $a_temp[4] . '<br />' : 'Not Available<br />';
		$browser .= ($a_temp[0] != 'galeon') ? 'Engine: Gecko RV: ' . $a_temp[3] : ''; */
	}
	elseif ($browser_info[0] == 'ns')
	{
		$browser .= 'Netscape ' . $browser_info[1];
	}
	elseif ($browser_info[0] == 'webkit')
	{
		$browser .= 'User Agent: ';
		$browser .= ucwords($browser_info[7]);
		$browser .= '<br />Engine: AppleWebKit ';
		$browser .= ($browser_info[1]) ? $browser_info[1] : 'Not Available';
	}
	else
	{
		$browser .= ($browser_info[0] == 'ie') ? strtoupper($browser_info[7]) : ucwords($browser_info[7]);
		$browser .= ' ' . $browser_info[1];
	}
	
	if ($STATSSETTINGS['browsers'] == 'y' && !(isset($browser_info[8]) && $browser_info[8] == 'bot'))
	{
		// Update the browser stats
		$query = "SELECT month FROM " . $DBPrefix . "currentbrowsers WHERE month = " . $THISMONTH . " AND year = " . $THISYEAR . " AND browser = '" . $browser . "'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "currentbrowsers VALUES (" . $THISMONTH . ", " . $THISYEAR . ", '" . $browser . "', 1)";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "currentbrowsers SET
					 counter = counter + 1
					 WHERE browser = '" . $browser . "' AND month = " . $THISMONTH . " AND year = " . $THISYEAR;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		
		// Update the platfom stats
		$query = "SELECT month FROM " . $DBPrefix . "currentplatforms WHERE month = " . $THISMONTH . " AND year = " . $THISYEAR . " AND platform = '" . $os . "'";
		$res = mysql_query($query);
		$system->check_mysql($res, $query, __LINE__, __FILE__);
		if (mysql_num_rows($res) == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "currentplatforms VALUES (
					" . $THISMONTH . ",  " . $THISYEAR . ", '" . $os . "', 1)";
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "currentplatforms SET
					counter = counter + 1
					WHERE platform = '" . $os . "' AND month = " . $THISMONTH . " AND year = " . $THISYEAR;
			$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
		}
	}
}
?>