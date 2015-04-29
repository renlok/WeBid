<?php

require_once "PluploadHandler.php";

$uploader = new PluploadHandler();
$uploader->no_cache_headers();
$uploader->cors_headers();

$targetDir = $upload_path . session_id();

if (!$uploader->handle(array(
	'target_dir' => $targetDir,
	'allow_extensions' => 'jpg,jpeg,png,gif'
))) {
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
	$fileName = $uploader->conf['file_name'];
	if (!in_array($fileName, $_SESSION['UPLOADED_PICTURES']))
	{
		array_push($_SESSION['UPLOADED_PICTURES'], $fileName);
		if (count($_SESSION['UPLOADED_PICTURES']) == 1)
		{
			$_SESSION['SELL_pict_url_temp'] = $_SESSION['SELL_pict_url'] = $fileName;
		}
	}
	die(json_encode(array('OK' => 1)));
}