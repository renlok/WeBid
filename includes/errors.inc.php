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

if (!defined('InWeBid')) exit();

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
	// log the error
	$system->log('error', $error);
	if ($errno == E_USER_ERROR)
		exit(1);
	return true;
}
