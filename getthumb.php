<?php
/***************************************************************************
 *   copyright              : (C) 2008 - 2015 WeBid
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

if (file_exists($upload_path . 'cache/' . $w . '-' . md5($fromfile)))
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
		default :
			$nomanage = true;
			break;
	}
	if ($nomanage)
	{
		ErrorPNG($ERR_710);
		exit;
	}
	header('Content-type: ' . $img['mime']);
	echo file_get_contents($upload_path . 'cache/' . $w . '-' . md5($fromfile));
}
else
{
	if (function_exists('imagetypes'))
	{
		if (!is_dir($upload_path . 'cache')) mkdir($upload_path . 'cache', 0777);

		if (!isset($_GET['w'])) $w = 100;
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
							$outype = 'png';
							$img['mime'] = 'image/png';
						}
					}
					else
					{
						$outype = 'gif';
						$img['mime'] = 'image/gif';
					}
					$imtype = 'gif';
					break;
				case IMAGETYPE_JPEG:
					if (!(imagetypes() &IMG_JPG)) $nomanage = true;
					$outype = 'jpeg';
					$img['mime'] = 'image/jpeg';
					$imtype = 'jpeg';
					break;
				case IMAGETYPE_PNG:
					if (!(imagetypes() &IMG_PNG)) $nomanage = true;
					$imtype = 'png';
					$img['mime'] = 'image/png';
					$outype = 'png';
					break;
				default :
					ErrorPNG($ERR_710);
					exit;
			}
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
		}
		else
		{
			ErrorPNG($ERR_710);
			exit;
		}
	}
	else
	{
		$nomanage = true;
	}
	if ($nomanage)
	{
		ErrorPNG($ERR_710);
		exit;
	}

	$ou = imagecreatetruecolor($w, $h);
	imagealphablending($ou, false);
	$funcall = "imagecreatefrom$imtype";
	imagecopyresampled($ou, $funcall($fromfile), 0, 0, 0, 0, $w, $h, $img[0], $img[1]);
	$funcall = "image$outype";
	$funcall($ou, $upload_path . 'cache/' . $_w . '-' . md5($fromfile));
	header('Content-type: ' . $img['mime']);
	$funcall($ou);
}
?>