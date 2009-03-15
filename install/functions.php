<?php
/***************************************************************************
 *   copyright				: (C) 2008 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/
 
function getmainpath(){
	$path = getcwd();
	$path = str_replace('install', '', $path);
	return $path;
}

function getdomainpath(){
	$path = 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	if(strlen($path) < 12)
		$path = 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	$path = str_replace('install', '', $path);
	return $path;
}

function makeconfigfile($contents){
	global $_POST;
	$filename = $_POST['mainpath'] . "includes/data.inc.php";
    if (!file_exists($filename)) {
        touch($filename);
    }
	
	@chmod($filename,0777);
    
    if(is_writable($filename)){
		if (!$handle = fopen($filename, 'w')) 
			$return = false;
		else {
            if (fwrite($handle, $contents) === false)
                $return = false;
            else
                $return = true;
		}
        fclose($handle);
	} else
		$return = false;
	return $return;
}
?>