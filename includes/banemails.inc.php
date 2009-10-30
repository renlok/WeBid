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

// Retrieve banned free mail domains
if (!defined('InWeBid')) exit();

$DOMAINS = $system->SETTINGS['banemail'];

$BANNEDDOMAINS = array_filter(explode("\n", $DOMAINS), 'chop');
if (count($BANNEDDOMAINS) > 0)
{
	$TPL_domains_alert = $MSG['30_0053'] . '<ul>';
	foreach ($BANNEDDOMAINS as $k => $v)
	{
		$TPL_domains_alert .= '<li><b>' . $v . '</b></li>';
	}
	$TPL_domains_alert .= '</ul>';
}
else
{
	$TPL_domains_alert = '';
}

function BannedEmail($email, $domains)
{
	$dom = explode('@', $email);
	$domains = array_map('chop', $domains);
	if (in_array($dom[1],$domains))
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>