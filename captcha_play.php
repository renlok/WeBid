<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2013 WeBid
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
include $main_path . 'inc/captcha/securimage.php';

$img = new Securimage();

header('Content-type: audio/x-wav');
header('Content-Disposition: attachment; name="securimage.wav"');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Expires: Sun, 1 Jan 2000 12:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');

echo $img->getAudibleCode();
exit;

?>