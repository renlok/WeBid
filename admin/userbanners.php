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

define('InAdmin', 1);
$current_page = 'banners';
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';
include $main_path . 'language/' . $language . '/categories.inc.php';

unset($ERR);
$id = intval($_REQUEST['id']);

// insert a new banner
if (isset($_POST['action']) && $_POST['action'] == 'insert')
{
	// Data integrity
	if (empty($_FILES['bannerfile']) || empty($_POST['url']))
	{
		$ERR = $ERR_047;
	}
	else
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

				// Update database
				$query = "INSERT INTO " . $DBPrefix . "banners VALUES
						(NULL, '" . mysql_escape_string($_FILES['bannerfile']['name']) . "',
						'" . $FILETYPE . "', 0, 0, '" . $_POST['url'] . "',
						'" . mysql_escape_string($_POST['sponsortext']) . "', '" . mysql_escape_string($_POST['alt']) . "',
						" . intval($_POST['purchased']) . ", " . $imagewidth . ", " . $imageheight . ", " . $id . ")";
				$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
				$ID = mysql_insert_id();

				// Handle filters
				if (isset($_POST['category']) && is_array($_POST['category']))
				{
					foreach ($_POST['category'] as $k => $v)
					{
						$query = "INSERT INTO " . $DBPrefix . "bannerscategories VALUES (" . $ID . ", " . $v . ")";
						$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
					}
				}
				if (!empty($_POST['keywords']))
				{
					$KEYWORDS = explode("\n", $_POST['keywords']);
					
					foreach ($KEYWORDS as $k => $v)
					{
						if (!empty($v))
						{
							$query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES (" . $ID . ",'" . $system->cleanvars(trim($v)) . "')";
							$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
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
$query = "SELECT id, name, company, email FROM " . $DBPrefix . "bannersusers WHERE id = " . $id;
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$USER = mysql_fetch_assoc($res);
	
// REtrieve user's banners
$query = "SELECT * FROM " . $DBPrefix . "banners WHERE user = " . $USER['id'];
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
$bg = '';
while ($row = mysql_fetch_assoc($res))
{
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
		'ERROR' => (isset($ERR)) ? $ERR : '',
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

$template->set_filenames(array(
		'body' => 'userbanners.tpl'
		));
$template->display('body');
?>
