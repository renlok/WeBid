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

define('InAdmin', 1);
include '../common.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

$banner = $_GET['banner'];

// Retrieve filters
$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE banner=$banner";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);

if (mysql_num_rows($res) > 0)
{
	while ($row = mysql_fetch_array($res))
	{
		$query = "SELECT cat_name FROM " . $DBPrefix . "categories WHERE cat_id=$row[category]";
		$res_ = @mysql_query($query);
		if ($res_ && @mysql_num_rows($res_) > 0)
		{
			$CATEGORIES .= mysql_result($res_,0,"cat_name")."<BR>";
		}
	}
}
$query = "SELECT * FROM " . $DBPrefix . "bannerskeywords WHERE banner=$banner";
$rr = mysql_query($query);
$system->check_mysql($rr, $query, __LINE__, __FILE__);
if (mysql_num_rows($rr) > 0)
{
	$i = 0;
	while ($i < mysql_num_rows($rr))
	{
		$KEYWORDS .= mysql_result($rr,$i,"keyword")."<BR>";
		$i++;
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
