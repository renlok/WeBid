<?php
/***************************************************************************
 *   copyright              : (C) 2008 - 2016 WeBid
 *   site                   : http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

include 'common.php';

$w = (isset($_GET['w'])) ? intval($_GET['w']) : '';
$_w = $w;
$fromfile = (isset($_GET['fromfile'])) ? $_GET['fromfile'] : '';
$nomanage = false;
$accepted_widths = array(
	$system->SETTINGS['thumb_show'],
	$system->SETTINGS['thumb_list'],
	'' // load default image
);
$w = (in_array($w, $accepted_widths)) ? $w : '';

function ErrorPNG($err)
{
	header('Content-type: image/png');
	$im = imagecreate(100, 30);
	$bgc = imagecolorallocate($im, 255, 255, 255);
	$tc = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, 100, 30, $bgc);
	imagestring($im, 1, 5, 5, $err, $tc);
	imagepng($im);
}

function load_image($file, $mime, $image_type, $output_type)
{
	header('Content-Type: ' . $mime);
	$funcall = "imagecreatefrom$image_type";
	$image = $funcall($file);
	$funcall = "image$output_type";
	$funcall($image);
	exit;
}

// control parameters and file existence
if (!isset($_GET['fromfile']) || $fromfile == '')
{
	ErrorPNG($ERR_716);
	exit;
}
elseif (!file_exists($_GET['fromfile']) && !fopen($_GET['fromfile'], 'r'))
{
	ErrorPNG($ERR_716);
	exit;
}

if (file_exists(UPLOAD_PATH . 'cache/' . $w . '-' . md5($fromfile)))
{
	$img = getimagesize($fromfile);
	switch ($img[2])
	{
		case IMAGETYPE_GIF:
			if (!(imagetypes() &IMG_GIF))
			{
				if (!function_exists('imagecreatefromgif'))
				{
					$nomanage = true;
				}
				else
				{
					$img['mime'] = 'image/png';
				}
			}
			else
			{
				$img['mime'] = 'image/gif';
			}
			break;
		case IMAGETYPE_JPEG:
			if (!(imagetypes() &IMG_JPG)) $nomanage = true;
			$img['mime'] = 'image/jpeg';
			break;
		case IMAGETYPE_PNG:
			if (!(imagetypes() &IMG_PNG)) $nomanage = true;
			$img['mime'] = 'image/png';
			break;
		default:
			$nomanage = true;
			break;
	}
	if ($nomanage)
	{
		ErrorPNG($ERR_710);
		exit;
	}
	header('Content-type: ' . $img['mime']);
	echo file_get_contents(UPLOAD_PATH . 'cache/' . $w . '-' . md5($fromfile));
}
else
{
	if (function_exists('imagetypes'))
	{
		if (!is_dir(UPLOAD_PATH . 'cache')) mkdir(UPLOAD_PATH . 'cache', 0777);

		$img = @getimagesize($fromfile);
		if (is_array($img))
		{
			switch ($img[2])
			{
				case IMAGETYPE_GIF:
					if (!(imagetypes() &IMG_GIF))
					{
						if (!function_exists('imagecreatefromgif'))
						{
							$nomanage = true;
						}
						else
						{
							$output_type = 'png';
							$img['mime'] = 'image/png';
						}
					}
					else
					{
						$output_type = 'gif';
						$img['mime'] = 'image/gif';
					}
					$image_type = 'gif';
					break;
				case IMAGETYPE_JPEG:
					if (!(imagetypes() &IMG_JPG)) $nomanage = true;
					$output_type = 'jpeg';
					$img['mime'] = 'image/jpeg';
					$image_type = 'jpeg';
					break;
				case IMAGETYPE_PNG:
					if (!(imagetypes() &IMG_PNG)) $nomanage = true;
					$image_type = 'png';
					$img['mime'] = 'image/png';
					$output_type = 'png';
					break;
				default :
					ErrorPNG($ERR_710);
					exit;
			}
		}
		else
		{
			ErrorPNG($ERR_710);
			exit;
		}
		if ($w == '')
		{
			// just load the image
			load_image($fromfile, $img['mime'], $image_type, $output_type);
		}
		else
		{
			// check image orientation
			if ($img[0] < $img[1])
			{
				$h = $w;
				$ratio = floatval($img[1] / $h);
				$w = ceil($img[0] / $ratio);
			}
			else
			{
				$ratio = floatval($img[0] / $w);
				$h = ceil($img[1] / $ratio);
			}
		
			$ou = imagecreatetruecolor($w, $h);
			imagealphablending($ou, false);
			$funcall = "imagecreatefrom$image_type";
			imagecopyresampled($ou, $funcall($fromfile), 0, 0, 0, 0, $w, $h, $img[0], $img[1]);
			$funcall = "image$output_type";
			$funcall($ou, UPLOAD_PATH . 'cache/' . $_w . '-' . md5($fromfile));
			header('Content-type: ' . $img['mime']);
			$funcall($ou);
			exit;
		}
	}
	else
	{
		ErrorPNG($ERR_710);
		exit;
	}
}
