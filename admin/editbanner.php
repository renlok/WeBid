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
$current_page = 'banners';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $main_path . 'language/' . $language . '/categories.inc.php';

unset($ERR);
$banner = (isset($_GET['banner']) && !empty($_GET['banner'])) ? $_GET['banner'] : '';
$banner = (isset($_POST['banner']) && !empty($_POST['banner'])) ? $_POST['banner'] : $banner;
$id = intval($_REQUEST['id']);

if (isset($_POST['action']) && $_POST['action'] == 'insert')
{
	// Data integrity
	if (empty($_FILES['bannerfile']) || empty($_POST['url']))
	{
		$ERR = $ERR_047;
	}
	else
	{
		if ($_FILES['bannerfile']['tmp_name'] != '' && $_FILES['bannerfile']['tmp_name'] != 'none')
		{
			// Handle upload
			if (!file_exists($upload_path . 'banners'))
			{
				umask();
				mkdir($upload_path . 'banners', 0777);
			}
			if (!file_exists($upload_path . 'banners/' . $id))
			{
				umask();
				mkdir($upload_path . 'banners/' . $id, 0777);
			}

			$TARGET = $upload_path . 'banners/' . $id . '/' . $_FILES['bannerfile']['name'];
			list($imagewidth, $imageheight, $imageType) = getimagesize($_FILES['bannerfile']['tmp_name']);
			$filename = basename($_FILES['bannerfile']['tmp_name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
			$file_types = array('gif', 'jpg', 'jpeg', 'png', 'swf');
			if (!in_array($file_ext, $file_types))
			{
				$ERR = $MSG['_0048'];
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
			}
		}

		// Update database
		$extrasql = '';
		if ($_FILES['bannerfile']['tmp_name'] != '' && $_FILES['bannerfile']['tmp_name'] != 'none')
		{
			$extrasql = "name = '" . $system->cleanvars($_FILES['bannerfile']['name']) . "',
					type = '" . $FILETYPE . "',
					width = " . intval($imagewidth) . ",
					height = " . intval($imageheight) . ",";
		}		

		$query = "UPDATE " . $DBPrefix . "banners
					SET " . $extrasql . "
					url = '" . $_POST['url'] . "',
					sponsortext = '" . $system->cleanvars($_POST['sponsortext']) . "',
					alt = '" . $system->cleanvars($_POST['alt']) . "',
					purchased = " . intval($_POST['purchased']) . "
					WHERE id = " . $banner;
		$db->direct_query($query);

		$query = "DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner = " . $banner;
		$db->direct_query($query);
		$query = "DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner = " . $banner;
		$db->direct_query($query);

		// Handle filters
		if (is_array($_POST['category']))
		{
			foreach ($_POST['category'] as $k => $v)
			{
				$query = "INSERT INTO " . $DBPrefix . "bannerscategories VALUES (" . $banner . ", " . $v . ")";
				$db->direct_query($query);
			}
		}
		if (!empty($_POST['keywords']))
		{
			$KEYWORDS = explode("\n", $_POST['keywords']);
			foreach ($KEYWORDS as $k => $v)
			{
				if (!empty($v))
				{
					$query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES (" . $banner . ", '" . $system->cleanvars(trim($v)) . "')";
					$db->direct_query($query);
				}
			}
		}
	}
}

// Retrieve user's banners
$query = "SELECT * FROM " . $DBPrefix . "banners WHERE id = " . $banner;
$db->direct_query($query);
$bg = '';
while ($row = $db->fetch())
{
	$BANNER = $row;
	$template->assign_block_vars('banners', array(
			'ID' => $row['id'],
			'TYPE' => $row['type'],
			'NAME' => $row['name'],
			'BANNER' => $uploaded_path . 'banners/' . $id . '/' . $row['name'],
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

// Retrieve user's information
$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = " . $id;
$db->direct_query($query);
if ($db->numrows() > 0)
{
	$USER = $db->fetch();
}

// Retrieve filters
$CATEGORIES = array();
$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE banner = " . $banner;
$db->direct_query($query);
if ($db->numrows() > 0)
{
	while ($row = $db->result())
	{
		$CATEGORIES[] = $row['category'];
	}
}
$KEYWORDS = '';
$query = "SELECT * FROM " . $DBPrefix . "bannerskeywords WHERE banner = " . $banner;
$db->direct_query($query);
if ($db->numrows() > 0)
{
	while ($row = $db->result())
	{
		$KEYWORDS .= $row['keyword'] . "\n";
	}
}

// -------------------------------------- category
$TPL_categories_list = '<select name="category[]" rows="12" multiple>' . "\n";
if (isset($category_plain) && count($category_plain) > 0)
{
	foreach ($category_plain as $k => $v)
	{
		if (is_array($CATEGORIES))
			$select = (in_array($k, $CATEGORIES)) ? ' selected="true"' : '';
		else
			$select = '';
		$TPL_categories_list .= '<option value="'.$k.'" ' . $select . '>' . $v . '</option>' . "\n";
	}
}
$TPL_categories_list .= '</select>';

$template->assign_vars(array(
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'ID' => $id,
		'NAME' => $USER['name'],
		'COMPANY' => $USER['company'],
		'EMAIL' => $USER['email'],
		// form values
		'BANNERID' => $banner,
		'URL' => $BANNER['url'],
		'SPONSORTEXT' => $BANNER['sponsortext'],
		'ALT' => $BANNER['alt'],
		'PURCHASED' => $BANNER['purchased'],
		'KEYWORDS' => $KEYWORDS,
		'CATEGORIES' => $TPL_categories_list,
		'NOTEDIT' => false
		));

$template->set_filenames(array(
		'body' => 'userbanners.tpl'
		));
$template->display('body');
?>
