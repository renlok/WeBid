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

require('../includes/common.inc.php');
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
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<FORM NAME="categories" METHOD="post" ACTION="">
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
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" ALIGN="CENTER" BGCOLOR="#0083D7">
		<TR align=center>
			<TD BGCOLOR="#ffffff">&nbsp;</TD>
		</TR>
		<TR>
			<TD>
				<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="4" ALIGN="CENTER">
					<TR BGCOLOR="#0083D7">
						<TD COLSPAN="3" class=title align=center>
								<?php echo $MSG['5230']; ?>
						</TD>
					</TR>
					<?php
					if (!empty($ERR)){
					?>
					<TR BGCOLOR="#FFFF00">
						<TD COLSPAN="3"> <B>
							<?php echo $ERR; ?>
							</B></TD>
					</TR>
					<?php } ?>
					<TR BGCOLOR="#EEEEEE">
						<TD COLSPAN="3">
						<?php echo $MSG['5234']; ?>
						</TD>
					</TR>
					<TR BGCOLOR="#FFFFFF">
						<TD COLSPAN="3">
							<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="1">
								<TR>
									<TD WIDTH="21%"><?php echo $MSG['165']; ?></TD>
									<TD WIDTH="79%">
										<IMG SRC="../includes/flags/<?php echo $system->SETTINGS['defaultlanguage']; ?>.gif">&nbsp;<INPUT TYPE="text" NAME="cat_name[<?php echo $system->SETTINGS['defaultlanguage']; ?>]" SIZE="25" MAXLENGTH="200">
										<?php
											reset($LANGUAGES);
											while (list($k,$v) = each($LANGUAGES)){
												if ($k!=$system->SETTINGS['defaultlanguage']) print '<BR><IMG SRC=../includes/flags/' . $k . '.gif>&nbsp;<INPUT TYPE=text name="' . cat_name[$k] . '" SIZE=25 MAXLENGTH=200>';
											}
										?>
									</TD>
								</TR>
								<TR>
									<TD WIDTH="21%">
										<INPUT TYPE="hidden" NAME="action" VALUE="insert">
									</TD>
									<TD WIDTH="79%">
										<INPUT TYPE="submit" NAME="InsertButton" VALUE="INSERT CATEGORY">
									</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR BGCOLOR="#FFFFFF">
						<TD COLSPAN="3"><?php echo $MSG['5235']; ?></TD>
					</TR>
					<TR BGCOLOR="#eeeeee">
						<TD WIDTH="14%"><?php echo $MSG['5237']; ?></TD>
						<TD WIDTH="72%"><?php echo $MSG['316']; ?></TD>
						<TD WIDTH="14%" ALIGN=CENTER>
							<INPUT TYPE="submit" NAME="Submit" VALUE="Delete">
						</TD>
					</TR>
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
							$HAVEFAQS = TRUE;
						}
						else
						{
							$HAVEFAQS = FALSE;
						}
						
					?>
					<TR BGCOLOR="#eeeeee">
						<TD WIDTH="7%" BGCOLOR="#FFFFFF">
							
							<?php echo $row['id']; ?>
							
						</TD>
						<TD WIDTH="79%" BGCOLOR="#FFFFFF">
							
							<A HREF=editfaqscategory.php?id=<?php echo $row['id']; ?>>
							<?php echo $row['category']; ?>
							</A>
							
							</TD>
						<TD WIDTH="14%" BGCOLOR="#FFFFFF" ALIGN=CENTER>
						<?php
						if (!$HAVEFAQS)
						{
						?>
							<INPUT TYPE="checkbox" NAME="delete[<?php echo $row['id']; ?>]" VALUE="<?php echo $row['id']; ?>">
						<?php
						} else {
						?>
						<IMG SRC="../images/nodelete.gif" ALT="You cannot delete this category">
						<?php
						}
						?>
						</TD>
					</TR>
					<?php
					}
					?>
					<TR BGCOLOR="#eeeeee">
						<TD WIDTH="7%" BGCOLOR="#FFFFFF">&nbsp;</TD>
						<TD WIDTH="79%" BGCOLOR="#FFFFFF">&nbsp;</TD>
						<TD WIDTH="14%" BGCOLOR="#FFFFFF" ALIGN=CENTER>
							<INPUT TYPE="submit" NAME="Submit" VALUE="Delete">
						</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	</TABLE>
</TD>
</TR>
</TABLE>
</FOrM>
</BODY>
</HTML>