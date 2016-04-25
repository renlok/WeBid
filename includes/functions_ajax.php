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

if (!defined('InWeBid')) exit('Access denied');

// reload the gallery table on upldgallery.php page
function getupldtable()
{
	global $_SESSION;
	foreach ($_SESSION['UPLOADED_PICTURES'] as $k => $v)
	{
		echo '<tr>
			<td>
				<img src="' . UPLOAD_FOLDER . session_id() . '/' . $v . '" width="60" border="0">
			</td>
			<td width="46%">
				' . $v . '
			</td>
			<td align="center">
				<a href="?action=delete&img=' . $k . '"><IMG SRC="images/trash.gif" border="0"></a>
			</td>
			<td align="center">
				<a href="?action=makedefault&img=' . $v . '"><img src="images/' . (($v == $_SESSION['SELL_pict_url_temp']) ? 'selected.gif' : 'unselected.gif') . '" border="0"></a>
			</td>
		</tr>';
	}
}

// plupload images
function upload_images()
{
	global $user, $MSG, $system;

	if (!$user->logged_in)
	{
		// imitate code execution
		die(json_encode(array(
			'OK' => 0,
			'error' => array(
				'code' => '202', //random
				'message' => $MSG['login_required_text']
			)
		)));
	}
	else
	{
		require_once PACKAGE_PATH . 'PluploadHandler.php';
		$uploader = new PluploadHandler();
		$uploader->no_cache_headers();
		$uploader->cors_headers();

		$targetDir = UPLOAD_PATH . session_id();

		if (!$uploader->handle(array(
			'target_dir' => $targetDir,
			'allow_extensions' => 'jpg,jpeg,png,gif'
			)))
		{
			die(json_encode(array(
				'OK' => 0,
				'error' => array(
					'code' => $uploader->get_error_code(),
					'message' => $uploader->get_error_message()
				)
			)));
		}
		else
		{
			//upload was good
			$conf = $uploader->get_conf();
			$fileName = $conf['file_name'];
			// resize picture
			$uploader->resizeThumbnailImage($targetDir . '/' . $fileName, $system->SETTINGS['gallery_max_width_height']);
			if (!in_array($fileName, $_SESSION['UPLOADED_PICTURES']))
			{
				$final_file_name = strtolower($fileName);
				array_push($_SESSION['UPLOADED_PICTURES'], $final_file_name);
				if (count($_SESSION['UPLOADED_PICTURES']) == 1)
				{
					$_SESSION['SELL_pict_url_temp'] = $_SESSION['SELL_pict_url'] = $final_file_name;
				}
			}
			die(json_encode(array('OK' => 1)));
		}
	}
}
