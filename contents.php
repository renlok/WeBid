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

include 'common.php';

switch ($_GET['show']) {
    case 'terms':
        $TITLE = $MSG['5086'];
        $CONTENT = $system->SETTINGS['termstext'];
        break;
    case 'priv':
        $TITLE = $MSG['401'];
        $CONTENT = $system->SETTINGS['privacypolicytext'];
        break;
    case 'cookies':
        $TITLE = $MSG['cookie_policy'];
        $CONTENT = $system->SETTINGS['cookiespolicytext'];
        break;
    default:
    case 'aboutus':
        $TITLE = $MSG['5085'];
        $CONTENT = $system->SETTINGS['aboutustext'];
        break;
}

$template->assign_vars(array(
        'TITLE' => $TITLE,
        'CONTENT' => $CONTENT
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'contents.tpl'
        ));
$template->display('body');
include 'footer.php';
