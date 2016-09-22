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

define('InAdmin', 1);
$current_page = 'contents';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == "Yes")
{
	$query = "DELETE FROM " . $DBPrefix . "news WHERE id = :news_id";
	$params = array();
	$params[] = array(':news_id', $_POST['id'], 'int');
	$db->query($query, $params);
	header('location: news.php');
	exit;
}
elseif (isset($_POST['action']) && $_POST['action'] == "No")
{
	header('location: news.php');
	exit;
}

$query = "SELECT title FROM " . $DBPrefix . "news WHERE id = :news_id";
$params = array();
$params[] = array(':news_id', $_GET['id'], 'int');
$db->query($query, $params);
$title = $db->result('title');

$template->assign_vars(array(
		'ID' => $_GET['id'],
		'MESSAGE' => sprintf($MSG['832'], $title),
		'TYPE' => 1
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'confirm.tpl'
		));
$template->display('body');

include 'footer.php';
?>