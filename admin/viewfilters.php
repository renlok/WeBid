<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
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
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$banner = $_GET['banner'];

// Retrieve filters
$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE banner=$banner";
$db->direct_query($query);
$res = $db->fetchall('FETCH_BOTH'); //puttng data into an array to free up the $db object for next loop

if (count($res) > 0)
{
	foreach ($res as $k => $v)
	{
		$query = "SELECT cat_name FROM " . $DBPrefix . "categories WHERE cat_id=" . $v['category'];
		$db->direct_query($query);
		if ($db->numrows() > 0)
		{
			$CATEGORIES .= $db->result('cat_name')."<BR>";
		}
	}
}
$query = "SELECT * FROM " . $DBPrefix . "bannerskeywords WHERE banner=$banner";
$db->direct_query($query);
if ($db->numrows() > 0)
{
	while ($row = $db->fetch())
	{
		$KEYWORDS .= $row['keyword']."<BR>";
	}
}
?>

<html><head>

<title>Untitled Document</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#ffffff">
<center>
  <p><b> 
	Banner filter</b> </p>
   <p align="center"><a href="javascript:window.close()" class="bluelink">Close</a></p>

  <table width="352" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td bgcolor="#eeeeee">
	  
	  <?php echo $MSG['_0053']; ?>
	  
	  </td>
	</tr>
	<tbody>
	<tr>
	  <td> 
	  <?php echo $CATEGORIES; ?></td>
	</tr>
	<tr>
	  <td bgcolor="#ffffff">&nbsp;
	  
	  </td>
	</tr>
	<tr>
	  <td bgcolor="#eeeeee">
	  
	  <?php echo $MSG['_0054']; ?>
	  
	  </td>
	</tr>
	<tr>
	  <td>
	  	
		<?php echo $KEYWORDS; ?>
		
	  </td>
	</tr>
	</tbody>
  </table>
  </center>
 <p align="center"><a href="javascript:window.close()" class="bluelink">Close</a></p>

</body></html>
