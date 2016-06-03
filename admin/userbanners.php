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
$current_page = 'banners';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';
include MAIN_PATH . 'language/' . $language . '/categories.inc.php';

$id = intval($_REQUEST['id']);

// insert a new banner
if (isset($_POST['action']) && $_POST['action'] == 'insert')
{
	// Data integrity
	if (empty($_FILES['bannerfile']) || empty($_POST['url']))
	{
		$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $ERR_047));
	}
	else
	{
		// Handle upload
		if (!file_exists(UPLOAD_PATH . 'banners'))
		{
			umask();
			mkdir(UPLOAD_PATH . 'banners', 0777);
		}
		if (!file_exists(UPLOAD_PATH . 'banners/' . $id))
		{
			umask();
			mkdir(UPLOAD_PATH . 'banners/' . $id, 0777);
		}

		$TARGET = UPLOAD_PATH . 'banners/' . $id . '/' . $_FILES['bannerfile']['name'];
		if (file_exists($TARGET))
		{
			$ERR = sprintf($MSG['_0047'], $TARGET);
		}
		else
		{
			list($imagewidth, $imageheight, $imageType) = getimagesize($_FILES['bannerfile']['tmp_name']);
			$filename = basename($_FILES['bannerfile']['name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
			$file_types = array('gif', 'jpg', 'jpeg', 'png', 'swf');
			if (!in_array(strtolower($file_ext), $file_types))
			{
				$template->assign_block_vars('alerts', array('TYPE' => 'error', 'MESSAGE' => $MSG['_0048']));
			}
			else
			{
				$imageType = image_type_to_mime_type($imageType);
				switch ($imageType)
				{
					case 'image/gif':
						$FILETYPE = 'gif';
						break;
					case 'image/pjpeg':
					case 'image/jpeg':
					case 'image/jpg':
						$FILETYPE = 'jpg';
						break;
					case 'image/png':
					case 'image/x-png':
						$FILETYPE = 'png';
						break;
					case 'application/x-shockwave-flash':
						$FILETYPE = 'swf';
						break;
				}
				if (!empty($_FILES['bannerfile']['tmp_name']) && $_FILES['bannerfile']['tmp_name'] != 'none')
				{
					move_uploaded_file($_FILES['bannerfile']['tmp_name'], $TARGET);
					chmod($TARGET, 0666);
				}

				// Update database
				$query = "INSERT INTO " . $DBPrefix . "banners VALUES
						(NULL, :name,
						:filetype, 0, 0, :url,
						:sponsortext, :alttext,
						:purchased, :imagewidth, :imageheight, :id)";
				$params = array();
				$params[] = array(':name', $_FILES['bannerfile']['name'], 'str');
				$params[] = array(':filetype', $FILETYPE, 'str');
				$params[] = array(':url', $_POST['url'], 'str');
				$params[] = array(':sponsortext', $_POST['sponsortext'], 'str');
				$params[] = array(':alttext', $_POST['alt'], 'str');
				$params[] = array(':purchased', $_POST['purchased'], 'int');
				$params[] = array(':imagewidth', $imagewidth, 'int');
				$params[] = array(':imageheight', $imageheight, 'int');
				$params[] = array(':id', $id, 'int');
				$db->query($query, $params);
				$ID = $db->lastInsertId();

				// Handle filters
				if (isset($_POST['category']) && is_array($_POST['category']))
				{
					foreach ($_POST['category'] as $k => $v)
					{
						$query = "INSERT INTO " . $DBPrefix . "bannerscategories VALUES (:id, :category)";
						$params = array();
						$params[] = array(':id', $ID, 'int');
						$params[] = array(':category', $v, 'int');
						$db->query($query, $params);
					}
				}
				if (!empty($_POST['keywords']))
				{
					$KEYWORDS = explode("\n", $_POST['keywords']);

					foreach ($KEYWORDS as $k => $v)
					{
						if (!empty($v))
						{
							$query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES (:id, :keyword)";
							$params = array();
							$params[] = array(':id', $ID, 'int');
							$params[] = array(':keyword', $system->cleanvars(trim($v)), 'str');
							$db->query($query, $params);
						}
					}
				}
				header('location: userbanners.php?id=' . $id);
				exit;
			}
		}
	}
}

$BANNERS = array();
// Retrieve user's information
$query = "SELECT id, name, company, email FROM " . $DBPrefix . "bannersusers WHERE id = :id";
$params = array();
$params[] = array(':id', $id, 'int');
$db->query($query, $params);
$USER = $db->result();

// retrieve user's banners
$query = "SELECT * FROM " . $DBPrefix . "banners WHERE user = :user_id";
$params = array();
$params[] = array(':user_id', $USER['id'], 'int');
$db->query($query, $params);
$bg = '';
while ($row = $db->fetch())
{
	$template->assign_block_vars('banners', array(
			'ID' => $row['id'],
			'TYPE' => $row['type'],
			'NAME' => $row['name'],
			'BANNER' => UPLOAD_FOLDER . 'banners/' . $id . '/' . $row['name'],
			'WIDTH' => $row['width'],
			'HEIGHT' => $row['height'],
			'URL' => $row['url'],
			'ALT' => $row['alt'],
			'SPONSERTEXT' => $row['sponsortext'],
			'VIEWS' => $row['views'],
			'CLICKS' => $row['clicks'],
			'PURCHASED' => $row['purchased'],
			'BG' => $bg
			));
	$bg = ($bg == '') ? 'class="bg"' : '';
}

// category
$TPL_categories_list = '<select name="category[]" rows="12" multiple>' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	foreach ($category_plain as $k => $v)
	{
		if (isset($_POST['categories']) && is_array($_POST['categories']))
			$select = (in_array($k, $_POST['categories'])) ? ' selected="true"' : '';
		else
			$select = '';
		$TPL_categories_list .= "\t" . '<option value="' . $k . '" ' . $select . '>' . $v . '</option>' . "\n";
	}
}
$TPL_categories_list .= '</select>' . "\n";

$template->assign_vars(array(
		'ID' => $id,
		'NAME' => $USER['name'],
		'COMPANY' => $USER['company'],
		'EMAIL' => $USER['email'],
		// form values
		'BANNERID' => '',
		'URL' => (isset($_POST['url'])) ? $_POST['url'] : '',
		'SPONSORTEXT' => (isset($_POST['sponsortext'])) ? $_POST['sponsortext'] : '',
		'ALT' => (isset($_POST['alt'])) ? $_POST['alt'] : '',
		'PURCHASED' => (isset($_POST['purchased'])) ? $_POST['purchased'] : '',
		'KEYWORDS' => (isset($_POST['keywords'])) ? $_POST['keywords'] : '',
		'CATEGORIES' => $TPL_categories_list,
		'NOTEDIT' => true
		));

include 'header.php';
$template->set_filenames(array(
		'body' => 'userbanners.tpl'
		));
$template->display('body');
include 'footer.php';
?>
