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
$current_page = 'contents';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['action']))
{
	// add category
	if ($_POST['action'] == $MSG['5204'])
	{
		if (empty($_POST['cat_name'][$system->SETTINGS['defaultlanguage']]))
		{
			$ERR = $ERR_047;
		}
		else
		{
			$query = "INSERT INTO " . $DBPrefix . "faqscategories values (NULL,
				'" . $system->cleanvars($_POST['cat_name'][$system->SETTINGS['defaultlanguage']]) . "')";
			$db->direct_query($query);
			$id = $db->lastInsertId();
			reset($LANGUAGES);
			foreach ($LANGUAGES as $k => $v)
			{
				$query = "INSERT INTO " . $DBPrefix . "faqscat_translated VALUES (" . $id . ", '" . $k . "','" . $system->cleanvars($_POST['cat_name'][$k]) . "')";
				$db->direct_query($query);
			}
		}
	}

	// Delete categories
	if ($_POST['action'] == $MSG['030'] && isset($_POST['delete']) && is_array($_POST['delete']))
	{
		foreach ($_POST['delete'] as $k => $v)
		{
			if ($v == 'delete')
			{
				$query = "SELECT id FROM " . $DBPrefix . "faqs WHERE category = " . $k;
				$db->direct_query($query);
				$ids = '0';
				while ($row = $db->fetch())
				{
					$ids .= ',' . $row['id'];
				}
				$query = "DELETE FROM " . $DBPrefix . "faqs WHERE category = " . $k;
				$db->direct_query($query);
				$query = "DELETE FROM " . $DBPrefix . "faqs_translated WHERE id IN (" . $ids . ")";
				$db->direct_query($query);
			}
			else
			{
				$move = explode(':', $v);
				$query = "UPDATE " . $DBPrefix . "faqs SET category = " . $move[1] . " WHERE category = " . $k;
				$db->direct_query($query);
			}
			$query = "DELETE FROM " . $DBPrefix . "faqscategories WHERE id = " . $k;
			$db->direct_query($query);
			$query = "DELETE FROM " . $DBPrefix . "faqscat_translated WHERE id = " . $k;
			$db->direct_query($query);
		}
	}

	// delete check
	if ($_POST['action'] == $MSG['008'] && isset($_POST['delete']) && is_array($_POST['delete']))
	{
		// get cats FAQs can be moved to
		$query = "SELECT category, id FROM " . $DBPrefix . "faqscategories
					WHERE id NOT IN (" . implode(',', $_POST['delete']) . ")";
		$db->direct_query($query);
		$move = '';
		while ($row = $db->fetch())
		{
			$move .= '<option value="move:' . $row['id'] . '">' . $MSG['840'] . $row['category'] . '</option>';
		}
		// Get data from the database
		$query = "SELECT COUNT(f.id) as COUNT, c.category, c.id FROM " . $DBPrefix . "faqscategories c
					LEFT JOIN " . $DBPrefix . "faqs f ON ( f.category = c.id )
					WHERE c.id IN (" . implode(',', $_POST['delete']) . ")
					GROUP BY c.id ORDER BY category";
		$db->direct_query($query);
		$message = $MSG['839'] . '<table cellpadding="0" cellspacing="0">';
		$names = array();
		$counter = 0;
		while ($row = $db->fetch())
		{
			$names[] = $row['category'] . '<input type="hidden" name="delete[' . $row['id'] . ']" value="delete">';
			if ($row['COUNT'] > 0)
			{
				$message .= '<tr>';
				$message .= '<td>' . $row['category'] . '</td><td>';
				$message .= '<select name="delete[' . $row['id'] . ']">';
				$message .= '<option value="delete">' . $MSG['008'] . '</option>';
				$message .= $move;
				$message .= '</select>';
				$message .= '</td>';
				$message .= '</tr>';
				$counter++;
			}
		}
		$message .= '</table>';
		// build message
		$template->assign_vars(array(
				'ERROR' => (isset($ERR)) ? $ERR : '',
				'ID' => '',
				'MESSAGE' => (($counter > 0) ? $message : '') . '<p>' . $MSG['838'] . implode(', ', $names) . '</p>',
				'TYPE' => 1
				));

		$template->set_filenames(array(
				'body' => 'confirm.tpl'
				));
		$template->display('body');
		exit;
	}
}

// Get data from the database
$query = "SELECT COUNT(f.id) as COUNT, c.category, c.id FROM " . $DBPrefix . "faqscategories c
			LEFT JOIN " . $DBPrefix . "faqs f ON ( f.category = c.id )
			GROUP BY c.id ORDER BY category";
$db->direct_query($query);
$bg = '';
while ($row = $db->fetch())
{
	$template->assign_block_vars('cats', array(
			'ID' => $row['id'],
			'CATEGORY' => $row['category'],
			'FAQSTXT' => sprintf($MSG['837'], $row['COUNT']),
			'FAQS' => $row['COUNT'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

foreach ($LANGUAGES as $k => $v)
{
	$template->assign_block_vars('lang', array(
			'LANG' => $k,
			'B_NODEFAULT' => ($k != $system->SETTINGS['defaultlanguage'])
			));
}

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'B_ADDCAT' => (isset($_GET['do']) && $_GET['do'] == 'add')
		));

$template->set_filenames(array(
		'body' => 'faqscategories.tpl'
		));
$template->display('body');

?>
