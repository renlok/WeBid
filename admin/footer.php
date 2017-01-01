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

if (!defined('InAdmin')) {
    exit();
}

$template->assign_vars(array(
        'L_COPY' => empty($system->SETTINGS['copyright']) ? '' : '<p>' . htmlspecialchars($system->SETTINGS['copyright']) . '</p>',
        'L_COPY_YEAR' => date("Y"),
        ));

$template->set_filenames(array(
        'footer' => 'footer.tpl'
        ));
$template->display('footer');
