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

if (!defined('InWeBid')) exit();

include PACKAGE_PATH . 'useragent.inc.php';

// Retrieve stats settings
$query = "SELECT * FROM " . $DBPrefix . "statssettings";
$db->direct_query($query);
$STATSSETTINGS = $db->result();

$THISDAY	= date('d');
$THISMONTH	= date('m');
$THISYEAR	= date('Y');

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

		$query = "SELECT day, month FROM " . $DBPrefix . "currentaccesses WHERE day = :day AND month = :month";
		$params = array();
		$params[] = array(':day', $THISDAY, 'int');
		$params[] = array(':month', $THISMONTH, 'str');
		$db->query($query, $params);
		if ($db->numrows() == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "currentaccesses VALUES (:day, :month, :year, 0, 0, 0)";
			$params = array();
			$params[] = array(':day', $THISDAY, 'int');
			$params[] = array(':month', $THISMONTH, 'str');
			$params[] = array(':year', $THISYEAR, 'int');
			$db->query($query, $params);
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
		$query .= " WHERE day = :day AND month = :month AND year = :year";
		$params = array();
		$params[] = array(':day', $THISDAY, 'int');
		$params[] = array(':month', $THISMONTH, 'str');
		$params[] = array(':year', $THISYEAR, 'int');
		$db->query($query, $params);
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
			$os .= '5.1 (Windows XP or Windows Server 2003)';
		}
		elseif ($browser_info[6] == 5.2)
		{
			$os .= '5.2 (Windows XP Professional x64 or Windows Server 2003 R2)';
		}
		elseif ($browser_info[6] == 6.0)
		{
			$os .= '6.0 (Windows Vista or Windows Server 2008 R2)';
		}
		elseif ($browser_info[6] == 6.1)
		{
			$os .= '6.1 (Windows 7 or Windows Server 2008 R2)';
		}
		elseif ($browser_info[6] == 6.2)
		{
			$os .= '6.2 (Windows 8 or Windows Server 2012)';
		}
		elseif ($browser_info[6] == 6.3)
		{
			$os .= '6.3 (Windows 8.1 or Windows Server 2012 R2)';
		}
		elseif ($browser_info[6] == 10.0)
		{
			$os .= '10.0 (Windows 10)';
		}
		elseif ($browser_info[6] == '')
		{
			$os .= ' (Unknown Windows)';
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
		$query = "SELECT month FROM " . $DBPrefix . "currentbrowsers WHERE month = :month AND year = :year AND browser = :browser";
		$params = array();
		$params[] = array(':month', $THISMONTH, 'str');
		$params[] = array(':year', $THISYEAR, 'int');
		$params[] = array(':browser', $browser, 'str');
		$db->query($query, $params);
		if ($db->numrows() == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "currentbrowsers VALUES (:month, :year, :browser, 1)";
			$params = array();
			$params[] = array(':month', $THISMONTH, 'str');
			$params[] = array(':year', $THISYEAR, 'int');
			$params[] = array(':browser', $browser, 'str');
			$db->query($query, $params);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "currentbrowsers SET
						counter = counter + 1
						WHERE browser = :browser AND month = :month AND year = :year";
			$params = array();
			$params[] = array(':browser', $browser, 'str');
			$params[] = array(':month', $THISMONTH, 'str');
			$params[] = array(':year', $THISYEAR, 'int');
			$db->query($query, $params);
		}

		// Update the platfom stats
		$query = "SELECT month FROM " . $DBPrefix . "currentplatforms WHERE month = :month AND year = :year AND platform = :OS";
		$params = array();
		$params[] = array(':month', $THISMONTH, 'str');
		$params[] = array(':year', $THISYEAR, 'int');
		$params[] = array(':OS', $os, 'str');
		$db->query($query, $params);
		if ($db->numrows() == 0)
		{
			$query = "INSERT INTO " . $DBPrefix . "currentplatforms VALUES (:month, :year, :OS, 1)";
			$params = array();
			$params[] = array(':month', $THISMONTH, 'str');
			$params[] = array(':year', $THISYEAR, 'int');
			$params[] = array(':OS', $os, 'str');
			$db->query($query, $params);
		}
		else
		{
			$query = "UPDATE " . $DBPrefix . "currentplatforms
					SET counter = counter + 1
					WHERE platform = :OS AND month = :month AND year = :year";
			$params = array();
			$params[] = array(':OS', $os, 'str');
			$params[] = array(':month', $THISMONTH, 'str');
			$params[] = array(':year', $THISYEAR, 'int');
			$db->query($query, $params);
		}
	}
}
