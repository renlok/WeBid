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

include 'includes/common.inc.php';

if ($user->logged_in && $user->user_data['suspended'] == 7)
{
	$title = $MSG['753'];
	$body = $MSG['754'];
}
else
{
	header('location: index.php');
	exit;
}

$template->assign_vars(array(
		'TITLE_MESSAGE' => $title,
		'BODY_MESSAGE' => $body
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'message.tpl'
		));
$template->display('body');
include 'footer.php';
?>
