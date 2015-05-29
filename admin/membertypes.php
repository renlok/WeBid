<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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
$current_page = 'settings';
include '../common.php';
include $include_path . 'functions_admin.php';
include $include_path . 'functions_rebuild.php';
include $include_path . 'membertypes.inc.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']) && $_POST['action'] = 'update')
{
	$old_membertypes = $_POST['old_membertypes'];
	$new_membertypes = $_POST['new_membertypes'];
	$new_membertype = $_POST['new_membertype'];

	// delete with the deletes
	if (isset($_POST['delete']) && is_array($_POST['delete']))
	{
		$idslist = implode(',', $_POST['delete']);
		$query = "DELETE FROM " . $DBPrefix . "membertypes WHERE id IN (" . $idslist . ")";
		$db->direct_query($query);
	}

	// now update everything else
	if (is_array($old_membertypes))
	{
		foreach ($old_membertypes as $id => $val)
		{
			if ( $val != $new_membertypes[$id])
			{
				$query = "UPDATE " . $DBPrefix . "membertypes SET
						feedbacks = '" . $new_membertypes[$id]['feedbacks'] . "', 
						icon = '" . $system->cleanvars($new_membertypes[$id]['icon']) . "' 
						WHERE id = " . $id;
				$db->direct_query($query);
			}
		}
	}

	// If a new membertype was added, insert it into database
	if (!empty($new_membertype['feedbacks']))
	{
		$query = "INSERT INTO " . $DBPrefix . "membertypes VALUES (NULL, '" . $new_membertype['feedbacks'] . "', '" . $system->cleanvars($new_membertype['icon']) . "');";
		$db->direct_query($query);
	}
	rebuild_table_file('membertypes');
	$ERR = $MSG['836'];
}

foreach ($membertypes as $id => $quest)
{
    $template->assign_block_vars('mtype', array(
			'ID' => $id,
			'FEEDBACK' => $quest['feedbacks'],
			'ICON' => $quest['icon']
			));
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : ''
		));
		
$template->set_filenames(array(
		'body' => 'membertypes.tpl'
		));
$template->display('body');

?>