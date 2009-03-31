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

function ToBeDeleted($index) {
	global $delete;
	@reset($delete);
	while (list($k,$v) = @each($delete)){
		if ($delete[$k] == $index) return true;
	}
	return false;
}

function search_cats($parent_id, $level) {
	global $DBPrefix;
	$query = "SELECT cat_id, cat_name FROM " . $DBPrefix . "categories
			WHERE deleted = 0 AND parent_id = $parent_id ORDER BY cat_name";
	$result = mysql_query($query);
	$cats = array();
	$catstr = '';
	$stringstart = '';
	if ($level > 0) {
		for ($i = 0; $i < $level; $i++) {
			$stringstart .= '|___';
		}		
	}
	while ($cats = mysql_fetch_assoc($result)) {
		$catstr .= ",\n{$cats['cat_id']} => '$stringstart{$cats['cat_name']}'";
		$catstr .= search_cats($cats['cat_id'], $level+1);
	}
	unset($cats);
	return $catstr;
}

function rebuild_cat_file() {
	global $system, $main_path, $DBPrefix;
	$query = "SELECT cat_id, cat_name, parent_id FROM " . $DBPrefix . "categories WHERE deleted = 0 order by cat_name";
	$result = mysql_query($query);
	$cats = array();
	while ($catarr = mysql_fetch_array($result)){
		$cats[$catarr['cat_id']] = $catarr['cat_name'];
		$allcats[] = $catarr;
	}
	
	$output = "<?php\n";
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
	
	$handle = fopen ($main_path . "language/" . $system->SETTINGS['defaultlanguage'] . "/categories.inc.php", "w");
	fputs($handle, $output);
}


if (!ini_get('register_globals')) {
   $superglobales = array($_SERVER, $_ENV,
	   $_FILES, $_COOKIE, $_POST, $_GET);
   if (isset($_SESSION)) {
	   array_unshift($superglobales, $_SESSION);
   }
   foreach ($superglobales as $superglobal) {
	   extract($superglobal, EXTR_SKIP);
   }
}

$colourrow[0] = '#FFFFFF';
$colourrow[1] = '#EEEEEE';

if ($_POST['act'] && strstr(basename($_SERVER['HTTP_REFERER']),basename($_SERVER['PHP_SELF']))) {
	$delete = $_POST['delete'];
	$categories_id = $_POST['categories_id'];
	$new_category = $_POST['new_category'];
	
	//-- Parse the categories array to update
	$i = 0;
	if (is_array($_POST['categories'])){
		reset($_POST['categories']);
		while (list($t,$h) = each($_POST['categories'])) {
			if ($_POST['categories'][$t] != $_POST['old_categories'][$t] ||
			$_POST['old_colour'][$t] != $_POST['colour'][$t] || 
			$_POST['old_image'][$t] != $image[$t] ) {
				$query = "UPDATE " . $DBPrefix . "categories 
							SET cat_name=\"".$system->cleanvars($_POST['categories'][$t])."\", 
								cat_colour=\"".$_POST['colour'][$t]."\", 
								cat_image=\"$image[$t]\" 
							WHERE cat_id=$t";
				$result = mysql_query($query);
				if (!$result) {
					print "Database access error - abnormal termination ".mysql_error();
					exit;
				}
				$updated = TRUE;
			}
			$i++;
		}
	}
	
	//-- Parse the categories array to delete
	if (is_array($delete)) {
		reset($delete);
		while (list($k,$v) = each($delete)) {
			$query = "delete from " . $DBPrefix . "categories WHERE cat_id=$v";
			$result = mysql_query($query);
			if (!$result) {
				print "Database access error - abnormal termination ".mysql_error();
				exit;
			}
			$updated = TRUE;
		}
	}
	
	//-- Add new category (if present)
	if ($new_category) {
		if (!$parent) $parent = 0;
		$query = "INSERT INTO " . $DBPrefix . "categories (parent_id, cat_name, deleted, sub_counter, counter, cat_colour, cat_image) VALUES ($parent,'".$system->cleanvars($new_category)."', 0,0,0, '$cat_colour', '$cat_image')";
		$result = mysql_query($query);
		if (!$result) {
			print "Database access error - abnormal termination ".mysql_error();
			exit;
		}
		$updated = TRUE;
	}

	//-- If something has been modified or deleted
	//-- some HTML code pieces must be rebuilt.
	if ($updated) {
		rebuild_cat_file();
		include "util_cc1.php";
	}
}
?>
<html>
<head>
<link rel='stylesheet' type='text/css' href='style.css' />
<script type="text/javascript">
function window_open(pagina,titulo,ancho,largo,x,y){
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
}
function selectAllDelete(formObj, isInverse) 
{
   for (var i=0;i < formObj.length;i++) 
   {
	  fldObj = formObj.elements[i];
	  if (fldObj.type == 'checkbox' && fldObj.name.substring(0,6)=='delete')
	  { 
		 if (isInverse)
			fldObj.checked = (fldObj.checked) ? false : true;
		 else fldObj.checked = true; 
	   }
   }
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_set.gif" width="21" height="19"></td>
		  <td class=white><?php echo $MSG['5142']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['078']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">At the moment if you change the catorgories here you must also changes the tranlations <a href="categoriestrans.php">here</a></td>
  </tr>
	<tr> 
	<td align="center" valign="middle">
<TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
<TR>
<TD ALIGN=CENTER><BR>
<form name="conf" action="" method="post">
	<TABLE WIDTH="95%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
		<TR> 
			<TD ALIGN=CENTER class=title>
				<?php print $MSG['078']; ?>
				</B></TD>
		</TR>
		<TR> 
			<TD> 
				<TABLE WIDTH=100% CELLPADDING=2 BGCOLOR="#FFFFFF">
					<TR> 
						<TD WIDTH=10></TD>
						<TD COLSPAN=4> <P> 
						<?php 
						print $MSG['161'];
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
						</P>
						  <P><img src="../images/nodelete.gif" width="20" height="21"> 
						  <?php echo $MGS_2__0030; ?>
							</P></TD>
					</TR>
					<TR> 
						<TD WIDTH=10 HEIGHT="21"></TD>
						<TD COLSPAN=4 HEIGHT="21"> 
						<?php 
						if ($parent > 0) {
							$father = $parent;
							$navigation = "";
							$counter = 0;
							do {
								$query = "select cat_id,cat_name,parent_id from " . $DBPrefix . "categories WHERE cat_id=$father";
								$result = mysql_query($query);
								
								$id 		= mysql_result($result,0,"cat_id");
								$descr 		= stripslashes(mysql_result($result,0,"cat_name"));
								$granfather = mysql_result($result,0,"parent_id");
								
								
								if ($counter == 0) {
									$navigation = "$descr ";
								} else {
									if ($parent != $father) {
										$navigation = "<A HREF=\"categories.php?parent=$id&name=$descr\">
																$descr</A>"." > ".$navigation;
									}
								}
								$counter++;
								$father = $granfather;
							} while ($father > 0);
							$navigation = "<A HREF=\"categories.php\">".$MSG['276'].":</A> ".$navigation;
							print $navigation;
						}
						?>
						</TD>
					</TR>
					<TR> 
						<TD WIDTH=10></TD>
						<TD BGCOLOR="#EEEEEE" WIDTH="40%"> 
							<B> 
							<?php print $MSG['087']; ?>
							</B> </TD>
						<TD BGCOLOR="#EEEEEE" WIDTH="20%"> 
							<!-- Category colour -->
							<B> 
							<?php print $MSG['328']; ?>
							</B> </TD>
						<TD BGCOLOR="#EEEEEE" WIDTH="20%"> 
							<!-- Image location -->
							<B> 
							<?php print $MSG['329']; ?>
							</B> </TD>
						<TD BGCOLOR="#EEEEEE" WIDTH="20%"> 
							<B> 
							<?php print $MSG['008']; ?>
							</B> </TD>
					</TR>
					<?php
					
					//-- Get first level categories
					
					$query = "select * from " . $DBPrefix . "categories WHERE parent_id=".intval($parent)." and deleted=0 order by cat_name";
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
						//-- Check if this category has sub_categories
						$query = "select count(cat_id) as subcats from " . $DBPrefix . "categories WHERE parent_id=$cat_id and deleted=0";
						$resultsub = mysql_query($query);
						if (!$resultsub) {
							print "Database access error - abnormal termination ".mysql_error();
							exit;
						}
						if (mysql_result($resultsub,0,"subcats") > 0) {
							$hassubs = 1;
						} else {
							$hassubs = 0;
						}
						print "<TR valign=top style=\"background-color: $colourrow[$z];\">
							 <TD WIDTH=10 ALIGN=RIGHT VALIGN=TOP>
							 <A HREF=\"categories.php?parent=$cat_id&name=".urlencode($cat_name)."\">
							 <IMG SRC=\"../images/plus.gif\" BORDER=0 ALT=\"Browse Subcategories\">
							 </A>
							 </TD>
							 <TD VALIGN=top>
							 <INPUT TYPE=hidden NAME=categories_id[$i] VALUE=\"$cat_id\">
							 <INPUT TYPE=hidden NAME=old_categories[$i] VALUE=\"$cat_name\">
							 <table width=100% boder=0 cellpadding=1 cellspacing=0>
							 <TR>
							 <TD><INPUT TYPE=text NAME=categories[$cat_id] VALUE=\"$cat_name\" SIZE=50></TD></TR>
							 </table></TD>
							 <TD>
							 <INPUT TYPE=hidden NAME=old_colour[$cat_id] VALUE=\"$cat_colour\">
							 <INPUT TYPE=text NAME=colour[$cat_id] VALUE=\"$cat_colour\" SIZE=25>
							 </TD>
							 <TD>
							 <INPUT TYPE=hidden NAME=old_image[$cat_id] VALUE=\"$cat_image\">
							 <INPUT TYPE=text NAME=image[$cat_id] VALUE=\"$cat_image\" SIZE=25>
							 </TD>
							 <TD align=center>";
						
						if ($counter == 0 && $sub_counter == 0 && $hassubs == 0) {
							print "<INPUT TYPE=checkbox NAME=delete[$cat_id] VALUE=$cat_id>";
						} else {
							print "<IMG SRC=\"../images/nodelete.gif\" ALT=\"You cannot delete this category\">";
						}
						print "</TD>
									 </TR>";
						$i++;
						$z = ($z == 1) ? 0 : 1;
					}
			?>
			<TR>
			<TD colspan=4>&nbsp;</TD>
			<TD align=center><a href="javascript: void(0)" onClick="selectAllDelete(document.forms[0],1)"><?php echo $MSG['30_0102']; ?></A></TD>
			</TR>
		<TR>
		 <TD WIDTH=50>
		  Add
		 </TD>
		 <TD>
		 <INPUT TYPE=hidden NAME=parent VALUE="<?php echo $parent; ?>">
		 <INPUT TYPE=hidden NAME=name VALUE="<?php echo $name; ?>">
		 <INPUT TYPE=text NAME=new_category SIZE=25>
		 </TD>
		 <TD>
		 <INPUT TYPE=text NAME=cat_colour SIZE=25>
		 </TD>
		 <TD>
		 <INPUT TYPE=text NAME=cat_image SIZE=25>
		 </TD>
		 <TD align=center>
		 </TD>
		 <TD>
		 </TD>
		 </TR>
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