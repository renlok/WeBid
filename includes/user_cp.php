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

$template->assign_vars(array(
	'B_ISERROR' => (!empty($ERR)),
	'B_MENUTITLE' => (!empty($TMP_usmenutitle)),
	'UCP_ERROR' => (isset($ERR)) ? $ERR : '',
	'UCP_TITLE' => (isset($TMP_usmenutitle)) ? $TMP_usmenutitle : ''
));