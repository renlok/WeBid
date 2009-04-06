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
$language = (isset($_GET['lang'])) ? $_GET['lang'] : 'EN';

$colourrow[0] = '#FFFFFF';
$colourrow[1] = '#EEEEEE';

function search_cats($parent_id, $level){
	global $DBPrefix;
	$query = "SELECT cat_id, cat_name FROM " . $DBPrefix . "categories
			WHERE deleted = 0 AND parent_id = $parent_id ORDER BY cat_name";
	$result = mysql_query($query);
	$cats = array();
	$catstr = '';
	$stringstart = '';
	if ($level > 0) {
		for ($i = 0; $i < $level; $i++){
			$stringstart .= '|___';
		}		
	}
		
	while ($cats = mysql_fetch_array($result)){
		$catstr .= ",\n{$cats['cat_id']} => '$stringstart{$cats['cat_name']}'";
		$catstr .= search_cats($cats['cat_id'], $level+1);
	}
	unset($cats);
	return $catstr;
}

function rebuild_cat_file($cats)
{
	global $language, $main_path;
	$output = "<?\n";
	$output.= "$" . "category_names = array(\n";
	
	$num_rows = count($cats);
	
	$i = 0;
	foreach ($cats as $k => $v) {
		$output .= "$k => '$v'";
		$i++;
		if ($i < $num_rows)
			$output .= ",\n";
		else
			$output .= "\n";
	}
	
	$output .= ");\n\n";
	
	$output .= "$" . "category_plain = array(\n0 => ''";
	
	$output .= search_cats(0, 0);
	
	$output .= ");\n?>";
	
	$handle = fopen ($main_path."language/".$language."/categories.inc.php", "w");
	fputs($handle, $output);
	fclose($handle);
}

if (isset($_POST['categories'])){
	rebuild_cat_file($_POST['categories']);
	include "util_cc1.php";
}

include $main_path."language/".$language."/categories.inc.php";

?>
<html>
<head>
<link rel='stylesheet' type='text/css' href='style.css' />
<script type="text/javascript">
function window_open(pagina,titulo,ancho,largo,x,y){
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['132']; ?></td>
		</tr>
	  </table></td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD ALIGN=CENTER><BR>
<FORM NAME=conf ACTION="" METHOD=POST>
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
		<TR> 
			<TD ALIGN=CENTER class=title>
				<?php	print $MSG['078']; ?>
				</B></TD>
		</TR>
		<TR> 
			<TD> 
				<TABLE WIDTH=100% CELLPADDING=2 BGCOLOR="#FFFFFF">
					<TR> 
						<TD COLSPAN=3> <P> 
						<?php 
						print $MSG['161'];
						echo '<p>';
						if (count($LANGUAGES) > 1){
							foreach ($LANGUAGES as $lang => $value)
							{
								print "<a href='categoriestrans.php?lang=$lang'><img align='middle' vspace=2 hspace=2 src='".$system->SETTINGS['siteurl']."includes/flags/".$lang.".gif' border='0'></a>";
							}
						}
						echo '</p>';
						if ($$ERR) {
							print "<FONT COLOR=red><BR><BR>".$$ERR;
						} else {
							if ($$MSG) {
								print "<FONT COLOR=red><BR><BR>".$$MSG;
							} else {
								print "<BR><BR>";
							}
						}
							?>
						</P></TD>
					</TR>
				</table>
				<TABLE WIDTH=100% CELLPADDING=4 cellspacing="4" BGCOLOR="#FFFFFF">
					<TR style="background-color: #eee;">
						<TD WIDTH="72"> 
							<B> 
							Default Name
							</B> </TD>
						<TD WIDTH="72">
							<B> 
							Translation
							</B> </TD>
						<td>&nbsp;</td>
					</TR>
					<?php
					$query = "select * from " . $DBPrefix . "categories WHERE deleted=0 order by cat_name";
					$result = mysql_query($query);
					if (!$result) {
						print "Database access error - abnormal termination".mysql_error();
						exit;
					}
					$num_cats = mysql_num_rows($result);
					$i = 0;
					$z = 0;
					while ($i < $num_cats ) {
						//-- Get category's data
						$cat_id = mysql_result($result,$i,"cat_id");
						$cat_name = stripslashes(mysql_result($result,$i,"cat_name"));
						$counter = mysql_result($result,$i,"counter");
						$sub_counter = mysql_result($result,$i,"sub_counter");
						$cat_colour = mysql_result($result, $i, "cat_colour");
						$cat_image = mysql_result($result, $i, "cat_image");
						print "<TR valign=top style=\"background-color: $colourrow[$z];\">
							 <TD VALIGN=top>
							 <INPUT TYPE=hidden NAME=categories_id[$i] VALUE=\"$cat_id\">
							 <INPUT TYPE=text NAME=categories_o[$cat_id] VALUE=\"$cat_name\" SIZE=45 disabled></TD>
							 <td><INPUT TYPE=text NAME=categories[$cat_id] VALUE=\"$category_names[$cat_id]\" SIZE=40></td>
							 <td>&nbsp;</td>
							 </TR>";
						$i++;
						$z = ($z == 1) ? 0 : 1;
					}
			?>
					<TR> </TR>
				</TABLE>	
				<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="5" BGCOLOR="#FFFFFF">
					<TR>
						<TD> 
							<CENTER>
								<INPUT TYPE="submit" NAME="act" VALUE="<?php print $MSG['089']; ?>">
							</CENTER>
						</TD>
					</TR>
				</TABLE>
				
			</TD>
		</TR>
	</TABLE>
	</FORM>
</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</body>
</html>