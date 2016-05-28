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

include 'common.php';

if (!$user->checkAuth())
{
	//if your not logged in you shouldn't be here
	header("location: user_login.php");
	exit;
}

$cropdefault = false;
$width = $system->SETTINGS['thumb_show'];
$height = $width / 1.2;
unset($ERR);

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
{
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	// some error checks
	$start_width = ($start_width < 0) ? 0 : $start_width;
	$start_height = ($start_height < 0) ? 0 : $start_height;
	$width = ($imagewidth < $width) ? $imagewidth : $width;
	$height = ($imageheight < $height) ? $imageheight : $height;
	if (($width + $start_width) > $imagewidth)
	{
		$start_width = $imagewidth - $width;
	}
	if (($height + $start_height) > $imageheight)
	{
		$start_height = $imageheight - $height;
	}

	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
	// make the background white
	$bg = imagecolorallocate($newImage, 0, 0, 0);
	imagefill($newImage, 0, 0, $bg);
	switch ($imageType)
	{
		case 'image/gif':
			$source = imagecreatefromgif ($image);
			break;
		case 'image/pjpeg':
		case 'image/jpeg':
		case 'image/jpg':
			$source = imagecreatefromjpeg($image);
			break;
		case 'image/png':
		case 'image/x-png':
			$source = imagecreatefrompng($image);
			break;
	}
	imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
	switch ($imageType)
	{
		case 'image/gif':
			imagegif ($newImage, $thumb_image_name);
			break;
		case 'image/pjpeg':
		case 'image/jpeg':
		case 'image/jpg':
			imagejpeg($newImage, $thumb_image_name, 90);
			break;
		case 'image/png':
		case 'image/x-png':
			imagepng($newImage, $thumb_image_name);
			break;
	}
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

// Process delete
$default_deleted = false;
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['img']))
{
	if (isset($_SESSION['SELL_pict_url_temp']) && isset($_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]) && $_SESSION['SELL_pict_url_temp'] == $_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])])
	{
		if (isset($_SESSION['SELL_pict_url']) && !empty($_SESSION['SELL_pict_url']) )
		{
			unlink(UPLOAD_PATH . session_id() . '/' . $_SESSION['SELL_pict_url']);
		}
		unset($_SESSION['SELL_pict_url']);
		$default_deleted = true; // a selected as default has just been deleted.
	}
	else
	{
		if(isset($_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]) && is_writable(UPLOAD_PATH . session_id() . '/' . $_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]))
		{
			unlink(UPLOAD_PATH . session_id() . '/' . $_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]);
		}
	}
	unset($_SESSION['UPLOADED_PICTURES'][intval($_GET['img'])]);
	unset($_SESSION['UPLOADED_PICTURES_SIZE'][intval($_GET['img'])]);

	//if default deleted search $_SESSION['UPLOADED_PICTURES'] and make first one found default
	if ($default_deleted)
	{
		$first_value = reset($_SESSION['UPLOADED_PICTURES']);
		$_SESSION['SELL_pict_url_temp'] = $_SESSION['SELL_pict_url'] = $first_value;
	}
}

if (isset($_GET['action']) && $_GET['action'] == 'makedefault')
{
	$cropdefault = true;
	$image = $_GET['img'];
	$_SESSION['SELL_pict_url_temp'] = $_SESSION['SELL_pict_url'] = $_GET['img'];
}

if (isset($_GET['action']) && $_GET['action'] == 'crop' && !empty($_POST['w']) && $_POST['w'] != 0)
{
	if ($_POST['upload_thumbnail'] == $MSG['616'])
	{
		// Get the new coordinates to crop the image.
		$x1 = intval($_POST['x1']);
		$y1 = intval($_POST['y1']);
		$x2 = intval($_POST['x2']);
		$y2 = intval($_POST['y2']);
		$w = intval($_POST['w']);
		$h = intval($_POST['h']);
		// Scale the image to the thumb_width set above
		$scale = $width / $w;
		$large_image_location = UPLOAD_PATH . session_id() . '/' . $_GET['img'];
		$thumb_image_location = UPLOAD_PATH . session_id() . '/thumb-' . $_GET['img'];
		$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location, $w, $h, $x1, $y1, $scale);
		$_SESSION['SELL_pict_url'] = 'thumb-' . $_GET['img'];
		$_SESSION['SELL_pict_url_temp'] = $_GET['img'];
	}
	else
	{
		$_SESSION['SELL_pict_url_temp'] = $_SESSION['SELL_pict_url'] = $_GET['img'];
	}
}

// close window
if (!empty($_POST['creategallery']))
{
	echo '<script type="text/javascript">window.close()</script>';
	exit;
}

if ($cropdefault)
{
	list($imgwidth, $imgheight) = getimagesize(UPLOAD_PATH . session_id() . '/' . $image);
	$swidth = ($imgwidth < 380) ? '' : ' width: 380px;';
	$imgratio = ($imgwidth > 380) ? $imgwidth / 380 : 1;
	$whratio = $imgheight / $imgwidth;
	if ($imgwidth > $imgheight) //landscape
	{
		$ratio = '1.2:1';
		$thumbwh = 'width:' . $width . '; height:' . $height . ';';
		$scaleX = 120;
		$scaleY = 100;
		$startY = 380 * $whratio;
		$startX = $startY * 1.2;
	}
	else //portrait
	{
		$ratio = '1:1.2';
		$thumbwh = 'height:' . $width . '; width:' . $height . ';';
		$scaleX = 100;
		$scaleY = 120;
		$startX = 380 * $whratio;
		$startY = $startX * 1.2;
	}

	$template->assign_vars(array(
			'RATIO' => $ratio,
			'THUMBWH' => $thumbwh,
			'SCALEX' => $scaleX,
			'SCALEY' => $scaleY,
			'IMGRATIO' => $imgratio,
			'SWIDTH' => $swidth,
			'IMGWIDTH' => $imgwidth,
			'IMGHEIGHT' => $imgheight,
			'IMGPATH' => UPLOAD_FOLDER . session_id() . '/' . $image,
			'STARTX' => $startX,
			'STARTY' => $startY,
			'IMAGE' => $image
			));
}
else
{
	$template->assign_vars(array(
			'MAXIMAGES' => $system->SETTINGS['maxpictures'],
			'ERROR' => (isset($ERR)) ? $ERR : '',

			'B_CANUPLOAD' => (!isset($_SESSION['UPLOADED_PICTURES']) || count($_SESSION['UPLOADED_PICTURES']) < $system->SETTINGS['maxpictures'])
			));
}

// built gallery
foreach ($_SESSION['UPLOADED_PICTURES'] as $k => $v)
{
	$template->assign_block_vars('images', array(
			'IMGNAME' => $v,
			'ID' => $k,
			'DEFAULT' => ($v == $_SESSION['SELL_pict_url_temp']) ? 'selected.gif' : 'unselected.gif',
			'IMAGE' => UPLOAD_FOLDER . session_id() . '/' . $v
			));
}

if ($system->SETTINGS['fees'] == 'y')
{
	$query = "SELECT value FROM " . $DBPrefix . "fees WHERE type = 'picture_fee'";
	$db->direct_query($query);
	$image_fee = $db->result('value');
}
else
{
	$image_fee = 0;
}

// get decimals for javascript rounder
$decimals = '';
for ($i = 0; $i < $system->SETTINGS['moneydecimals']; $i++)
{
	$decimals .= 0;
}

$template->assign_vars(array(
		'SITENAME' => $system->SETTINGS['sitename'],
		'THEME' => $system->SETTINGS['theme'],
		'ERROR' => (isset($ERR)) ? $ERR : '',
		'IMAGE_COST' => ($image_fee != 0) ? sprintf($MSG['675'], $image_fee) : '',
		'IMAGE_COST_PLAIN' => ($image_fee != 0) ? $image_fee : 0,
		'PICINFO' => sprintf($MSG['673'], $system->SETTINGS['maxpictures'], $system->SETTINGS['maxuploadsize']/1024),
		'ERRORMSG' => sprintf($MSG['674'], $system->SETTINGS['maxpictures']),
		'MAXPICS' => $system->SETTINGS['maxpictures'],
		'MAXPICSIZE' => $system->SETTINGS['maxuploadsize']/1024,
		'MAXPICSIZE_MB' => $system->SETTINGS['maxuploadsize']/(1024*1024),  //kb to mb convertion
		'MAXWIDTHHEIGHT' => $system->SETTINGS['gallery_max_width_height'],
		'SESSION_ID' => session_id(),
		'UPLOADED' => intval(count($_SESSION['UPLOADED_PICTURES']))
		));
$template->set_filenames(array(
		'body' => 'upldgallery.tpl'
		));
$template->display('body');
