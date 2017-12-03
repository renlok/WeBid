<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

$error = true;
include 'common.php';

$template->assign_vars(array(
        'ERROR' => print_r($_SESSION['SESSION_ERROR'], true),
        'DEBUGGING' => false, // set to true when trying to fix the script
        'ERRORTXT' => $system->SETTINGS['errortext']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'error.tpl'
        ));
$template->display('body');
include 'footer.php';
