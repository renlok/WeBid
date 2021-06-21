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

define('InAdmin', 1);
$current_page = 'admin';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

unset($_SESSION['WEBID_ADMIN_NUMBER'], $_SESSION['WEBID_ADMIN_PASS'], $_SESSION['WEBID_ADMIN_IN'], $_SESSION['WEBID_ADMIN_USER']);
?>
<script type="text/javascript">
parent.location.href = 'index.php';
</script>