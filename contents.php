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

require("includes/config.inc.php");
switch ($_GET['show']) {
    case "aboutus":
        $TITLE = $MSG['5085'];
        $CONTENT = stripslashes($system->SETTINGS['aboutustext']);
        break;
    case "terms":
        $TITLE = $MSG['5086'];
        $CONTENT = stripslashes($system->SETTINGS['termstext']);
        break;
}

$template->assign_vars(array(
        'TITLE' => $TITLE,
        'CONTENT' => $CONTENT
        ));

include "header.php";
$template->set_filenames(array(
        'body' => 'contents.html'
        ));
$template->display('body');
include "footer.php";

?>
