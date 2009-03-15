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

require('includes/config.inc.php');

$query = "SELECT id, title FROM " . $DBPrefix . "news WHERE suspended = 0 ORDER BY new_date";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

while ($new = mysql_fetch_array($res)) {
    $template->assign_block_vars('news', array(
            'TITLE' => stripslashes($new['title']),
            'ID' => $new['id']
            ));
}

require("header.php");
$template->set_filenames(array(
        'body' => 'view_allnews.html'
        ));
$template->display('body');
require("footer.php");

?>