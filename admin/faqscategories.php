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

define('InAdmin', 1);
include '../includes/common.inc.php';
include $include_path . 'functions_admin.php';
include 'loggedin.inc.php';

unset($ERR);

if (isset($_POST['InsertButton']) && isset($_POST['cat_name']) && strlen($_POST['cat_name']) > 0)
{
	$query = "insert into " . $DBPrefix . "faqscategories values(NULL,
		'".addslashes($_POST['cat_name'][$system->SETTINGS['defaultlanguage']])."')";
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	$id = mysql_insert_id();
	reset($LANGUAGES);
	while (list($k,$v) = each($LANGUAGES)){
		@mysql_query("INSERT INTO " . $DBPrefix . "faqscat_translated VALUES($id,'$k','".$system->cleanvars($_POST['cat_name'][$k])."')");
	}
}

#// Delete categories
if (isset($_POST['delete']) && is_array($_POST['delete']))
{
	while (list($k,$v) = each($_POST['delete']))
	{
		$query = "delete from " . $DBPrefix . "faqscategories WHERE id=$v";
		$r = mysql_query($query);
		$system->check_mysql($r, $query, __LINE__, __FILE__);
		@mysql_query("DELETE FROM " . $DBPrefix . "faqscat_translated WHERE id=$v");
	}
}


#// Get data from the database
$query = "select * from " . $DBPrefix . "faqscategories order by category";
$res__ = mysql_query($query);
$system->check_mysql($res__, $query, __LINE__, __FILE__);

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="categories" METHOD="post" action="">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_con.gif" ></td>
		  <td class=white><?php echo $MSG['25_0018']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5230']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
	<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#0083D7">
		<tr align=center>
			<td bgcolor="#ffffff">&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
					<tr bgcolor="#0083D7">
						<td colspan="3" class=title align=center>
								<?php echo $MSG['5230']; ?>
						</td>
					</tr>
					<?php
					if (!empty($ERR)){
					?>
					<tr bgcolor="#FFFF00">
						<td colspan="3"> <B>
							<?php echo $ERR; ?>
							</B></td>
					</tr>
					<?php } ?>
					<tr bgcolor="#EEEEEE">
						<td colspan="3">
						<?php echo $MSG['5234']; ?>
						</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="1">
								<tr>
									<td width="21%"><?php echo $MSG['165']; ?></td>
									<td width="79%">
										<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif">&nbsp;<input type="text" name="cat_name[<?php echo $system->SETTINGS['defaultlanguage']; ?>]" SIZE="25" MAXLENGTH="200">
										<?php
											reset($LANGUAGES);
											while (list($k,$v) = each($LANGUAGES)){
												if ($k!=$system->SETTINGS['defaultlanguage']) print '<BR><IMG SRC=../includes/flags/' . $k . '.gif>&nbsp;<input type=text name="' . $cat_name[$k] . '" SIZE=25 MAXLENGTH=200>';
											}
										?>
									</td>
								</tr>
								<tr>
									<td width="21%">
										<input type="hidden" name="action" value="insert">
									</td>
									<td width="79%">
										<input type="submit" name="InsertButton" value="INSERT CATEGORY">
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td colspan="3"><?php echo $MSG['5235']; ?></td>
					</tr>
					<tr bgcolor="#eeeeee">
						<td width="14%"><?php echo $MSG['5237']; ?></td>
						<td width="72%"><?php echo $MSG['316']; ?></td>
						<td width="14%" align="center">
							<input type="submit" name="Submit" value="Delete">
						</td>
					</tr>
					<?php
					while ($row = mysql_fetch_array($res__))
					{
						$row[category]=stripslashes($row['category']);
						#// Are there FAQs for this category?
						$query = "select id from " . $DBPrefix . "faqs WHERE category = " . $row['id'];
						$re = mysql_query($query);
						$system->check_mysql($re, $query, __LINE__, __FILE__);
						if (mysql_num_rows($re) > 0)
						{
							$HAVEFAQS = trUE;
						}
						else
						{
							$HAVEFAQS = FALSE;
						}
						
					?>
					<tr bgcolor="#eeeeee">
						<td width="7%" bgcolor="#FFFFFF">
							
							<?php echo $row['id']; ?>
							
						</td>
						<td width="79%" bgcolor="#FFFFFF">
							
							<A HREF=editfaqscategory.php?id=<?php echo $row['id']; ?>>
							<?php echo $row['category']; ?>
							</A>
							
							</td>
						<td width="14%" bgcolor="#FFFFFF" align="center">
						<?php
						if (!$HAVEFAQS)
						{
						?>
							<input type="checkbox" name="delete[<?php echo $row['id']; ?>]" value="<?php echo $row['id']; ?>">
						<?php
						} else {
						?>
						<IMG SRC="../images/nodelete.gif" ALT="You cannot delete this category">
						<?php
						}
						?>
						</td>
					</tr>
					<?php
					}
					?>
					<tr bgcolor="#eeeeee">
						<td width="7%" bgcolor="#FFFFFF">&nbsp;</td>
						<td width="79%" bgcolor="#FFFFFF">&nbsp;</td>
						<td width="14%" bgcolor="#FFFFFF" align="center">
							<input type="submit" name="Submit" value="Delete">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
</FOrM>
</body>
</html>