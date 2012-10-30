<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2012 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

if(isset($_SESSION['csrftoken']))
{
	# Token should exist as soon as a user is logged in
	if(1 < count($_POST))		# More than 2 parameters in a POST (csrftoken + 1 more) => check
		$valid_req = ($_POST['csrftoken'] == $_SESSION['csrftoken']);
	else
		$valid_req = true;		# Neither GET nor POST params exist => permit
	if(!$valid_req)
	{
		global $template, $MSG, $ERR_077;
		$template->assign_vars(array(
				'TITLE_MESSAGE' => $MSG['936'],
				'BODY_MESSAGE' => $ERR_077
				));
		include 'header.php';
		$template->set_filenames(array(
				'body' => 'message.tpl'
				));
		$template->display('body');
		include 'footer.php';
		exit; // kill the page
	}
}
else
{
	header("location: login.php");
	exit;
}

if (checklogin())
{
	header("location: login.php");
	exit;
}
else
{
	$mth = 'MON_0' . gmdate('m', $_SESSION['WEBID_ADMIN_TIME']);
	$return = gmdate('d', $_SESSION['WEBID_ADMIN_TIME']) . ' ' . $MSG[$mth] . ', ' . gmdate('Y - H:i', $_SESSION['WEBID_ADMIN_TIME']);
	$template->assign_vars(array(
			'DOCDIR' => $DOCDIR,
			'THEME' => $system->SETTINGS['theme'],
			'SITEURL' => $system->SETTINGS['siteurl'],
			'CHARSET' => $CHARSET,
			'EXTRAJS' => (isset($extraJs)) ? $extraJs : '',
			'ADMIN_USER' => $_SESSION['WEBID_ADMIN_USER'],
			'ADMIN_ID' => $_SESSION['WEBID_ADMIN_IN'],
			'CURRENT_PAGE' => $current_page,
			'LAST_LOGIN' => $return
			));
	foreach ($LANGUAGES as $lang => $value)
	{
		$template->assign_block_vars('langs', array(
				'LANG' => $value,
				'B_DEFAULT' => ($lang == $system->SETTINGS['defaultlanguage'])
				));
	}
}
?>