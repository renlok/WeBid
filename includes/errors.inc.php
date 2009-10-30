<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/
 
if (!defined('InWeBid')) exit();

// Errors handling functions
if (!function_exists('openeLogFile'))
{
	function openeLogFile()
	{
		global $logFileHandle, $logPath;
		$logFileHandle = @fopen($logPath . 'error.log', 'a');
	}
}

if (!function_exists('closeeLogFile'))
{
	function closeeLogFile()
	{
		global $logFileHandle;
		if ($logFileHandle)
			fclose ($logFileHandle);
	}
}

if (!function_exists('printeLog'))
{
	function printeLog ($str)
	{
		global $logFileHandle;
		if ($logFileHandle)
		{
			if (substr($str, strlen($str)-1, 1) != "\n")
				$str .= "\n";
			fwrite ($logFileHandle, $str);
		}
	}
}
	
if (!function_exists('MySQLError'))
{
	function MySQLError($Q, $line = '', $page = '')
	{
		global 	$SESSION_ERROR, $ERR_001, $system, $_SESSION;
		
		$SESSION_ERROR = $ERR_001 . "\t" . $Q . "\n\t" . mysql_error() . "\n\tpage:" . $page . " line:" . $line;
		if (!isset($_SESSION['SESSION_ERROR']) || !is_array($_SESSION['SESSION_ERROR']))
		{
			$_SESSION['SESSION_ERROR'] = array();
		}
		$_SESSION['SESSION_ERROR'][] = $SESSION_ERROR;
		openeLogFile();
		printeLog(gmdate('d-m-Y, H:i:s', $system->ctime) . ':: ' . $SESSION_ERROR);
		closeeLogFile();
	}
}

if (!function_exists('WeBidErrorHandler'))
{
	function WeBidErrorHandler($errno, $errstr, $errfile, $errline)
	{
		global $system, $_SESSION;
		switch ($errno)
		{
			case E_USER_ERROR:
				$error = "<b>My ERROR</b> [$errno] $errstr\n";
				$error .= "  Fatal error on line $errline in file $errfile";
				$error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")\n";
				$error .= "Aborting...\n";
				break;
		
			case E_USER_WARNING:
				$error = "<b>My WARNING</b> [$errno] $errstr on $errfile line $errline\n";
				break;
		
			case E_USER_NOTICE:
				$error = "<b>My NOTICE</b> [$errno] $errstr on $errfile line $errline\n";
				break;
		
			default:
				$error = "Unknown error type: [$errno] $errstr on $errfile line $errline\n";
				break;
		}
		if (!isset($_SESSION['SESSION_ERROR']) || !is_array($_SESSION['SESSION_ERROR']))
		{
			$_SESSION['SESSION_ERROR'] = array();
		}
		$_SESSION['SESSION_ERROR'][] = $error;
		openeLogFile();
		printeLog(gmdate('d-m-Y, H:i:s', $system->ctime) . ':: ' . $error);
		closeeLogFile();
		if ($errno == E_USER_ERROR)
			exit(1);
		return true;
	}
}
?>