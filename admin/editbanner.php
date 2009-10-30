<?php
/***************************************************************************
 *   copyright				: (C) 2008, 2009 WeBid
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
include $main_path."language/".$language."/categories.inc.php";

$banner = (isset($_GET['banner']) && !empty($_GET['banner'])) ? $_GET['banner'] : $_POST['banner'];

if ($_POST['action'] == 'update')
{
	// Data integrity
	if (empty($_FILES['bannerfile']) || empty($_POST['url']))
	{
		$ERR = $ERR_047;
	}
	else
	{
		if ($_FILES['bannerfile']['tmp_name'] != "" && $_FILES['bannerfile']['tmp_name'] != 'none')
		{
			// Handle upload
			if (!file_exists($upload_path."banners")) {
				umask();
				mkdir($upload_path."banners",0777);
			}
			if (!file_exists($upload_path."banners/$id")) {
				umask();
				mkdir($upload_path."banners/$id",0777);
			}
			
			$TARGET = $upload_path . 'banners/' . $id . '/' . $_FILES['bannerfile']['name'];
			list($imagewidth, $imageheight, $imageType) = getimagesize($_FILES['bannerfile']['tmp_name']);
			$filename = basename($_FILES['bannerfile']['tmp_name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
			$file_types = array('gif', 'jpg', 'jpeg', 'png', 'swf');
			if (!in_array($file_ext, $file_types)) {
				$ERR = $MSG['_0048'];
			} else {
				$imageType = image_type_to_mime_type($imageType);
				switch ($imageType) {
					case "image/gif":
						$FILETYPE = 'gif';
						break;
					case "image/pjpeg":
					case "image/jpeg":
					case "image/jpg":
						$FILETYPE = 'jpg';
						break;
					case "image/png":
					case "image/x-png":
						$FILETYPE = 'png';
						break;
					case "application/x-shockwave-flash":
						$FILETYPE = 'swf';
						break;
				}
				if (!empty($_FILES['bannerfile']['tmp_name']) && $_FILES['bannerfile']['tmp_name'] != "none") {
					move_uploaded_file($_FILES['bannerfile']['tmp_name'], $TARGET);
					chmod($TARGET, 0666);
				}
			}
		}
		
		// Update database
		if ($_FILES['bannerfile']['tmp_name'] != "" && $_FILES['bannerfile']['tmp_name'] != 'none')
		{
			$query = "UPDATE " . $DBPrefix . "banners
						SET name = '".addslashes($_FILES['bannerfile']['name'])."',
						type = '$FILETYPE',
						width = $imagewidth,
						height = $imageheight,
						url = '".$_POST['url']."',
						sponsortext = '".$_POST['sponsortext']."',
						alt = '".$_POST['alt']."',
						purchased = ".intval($_POST['purchased'])."
						WHERE id = ".$_POST['banner'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
		} elseif ($_FILES['bannerfile']['tmp_name'] == "" || $_FILES['bannerfile']['tmp_name'] == 'none')
		{
			$query = "UPDATE " . $DBPrefix . "banners
					  SET url='".$_POST['url']."',
					  sponsortext = '".$_POST['sponsortext']."',
					  alt = '".$_POST['alt']."',
					  purchased = ".intval($_POST['purchased'])."
					  WHERE id = ".$_POST['banner'];
			$res = mysql_query($query);
			$system->check_mysql($res, $query, __LINE__, __FILE__);
		}
		
		$ID = $banner;
		@mysql_query("DELETE FROM " . $DBPrefix . "bannerscategories WHERE banner=$ID");
		@mysql_query("DELETE FROM " . $DBPrefix . "bannerskeywords WHERE banner=$ID");
		
		// Handle filters
		if (is_array($_POST['category']))
		{
			foreach ($_POST['category'] as $k => $v)
			{
				$query = "INSERT INTO " . $DBPrefix . "bannerscategories VALUES ($ID,$v)";
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
			}
		}
		if (!empty($_POST['keywords']))
		{
			$KEYWORDS = explode("\n",$_POST['keywords']);
			foreach ($KEYWORDS as $k => $v)
			{
				if (!empty($v))
				{
					$query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES ($ID,'".chop($v)."')";
					$res = mysql_query($query);
					$system->check_mysql($res, $query, __LINE__, __FILE__);
				}
			}
		}
	}
}

// Retrieve user's banners
$query = "SELECT * FROM " . $DBPrefix . "banners WHERE id = $banner";
$res = mysql_query($query);
$system->check_mysql($res, $query, __LINE__, __FILE__);
if (mysql_num_rows($res) > 0)
{
	$BANNER = mysql_fetch_array($res);
}

// Retrieve user's information
$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = '".$BANNER['user']."';";

$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);
if (mysql_num_rows($res_) > 0)
{
	$USER = mysql_fetch_array($res_);
}

// Retrieve filters
$query = "SELECT * FROM " . $DBPrefix . "bannerscategories WHERE banner = ".$BANNER['id'];
$resres = mysql_query($query);

$system->check_mysql($resres, $query, __LINE__, __FILE__);
if (mysql_num_rows($resres) > 0)
{
	while ($row = mysql_fetch_array($resres))
	{
		$CATEGORIES[] = $row['category'];
	}
}
$query = "SELECT * FROM " . $DBPrefix . "bannerskeywords WHERE banner = ".$BANNER['id'];
$resres = mysql_query($query);
$system->check_mysql($resres, $query, __LINE__, __FILE__);
if (mysql_num_rows($resres) > 0)
{
	while ($row = mysql_fetch_array($resres))
	{
		$KEYWORDS .= $row['keyword']."\n";
	}
}

// -------------------------------------- category
$TPL_categories_list = '<select name="category[]" ROWS=12 MULTIPLE>'."\n";
if (isset($category_plain) && count($category_plain) > 0) {
	foreach ($category_plain as $k => $v) {
		if (is_array($CATEGORIES))
			$select = (in_array($k, $CATEGORIES)) ? " selected=true" : "";
		else
			$select = '';
		$TPL_categories_list .= "<option value=\"".$k."\" ".$select.">".$v."</option>\n";
	}
}
$TPL_categories_list .= "</select>\n";

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<SCRIPT type="text/javascript">
function window_open(pagina,titulo,ancho,largo,x,y){
	
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
	
}
</SCRIPT>
</head>
<body style="margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
	<td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr> 
		  <td width="30"><img src="images/i_ban.gif" ></td>
		  <td class=white><?php echo $MSG['25_0011']; ?>&nbsp;&gt;&gt;&nbsp;<?php echo $MSG['5205']; ?></td>
		</tr>
	  </table></td>
  </tr>
  <tr>
	<td align="center" valign="middle">&nbsp;</td>
  </tr>
	<tr> 
	<td align="center" valign="middle">

<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
<tr>
<td align="center">
	<BR>
	<form NAME=conf action="" method="post" ENCTYPE="multipart/form-data">
		  <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#0083D7">
			<tr>
			  <td align="center" class=title>
				<?php print $MSG['_0024']; ?>
				</td>
			</tr>
			<tr>
			  <td>
				<table width=100% cellpadding=2 align="center" bgcolor="#FFFFFF">
				  <?php
				  if (!empty($ERR))
				  {
						?>
				  <tr>
					<td colspan="4" align="center" bgcolor=yellow> <B>
					  <?php echo $ERR; ?>
					   </B></td>
				  </tr>
				  <?php
				  }
						?>
				  <tr valign="top">
					<td colspan="4" align="center">
					  <A HREF=userbanners.php?id=<?php echo $USER['id']; ?>>
					  <?php echo $MSG['270']; ?>
					  </A> </td>
				  </tr>
				  <tr valign="top" bgcolor="#FFFFFF">
					<td colspan="4" height="22">
					  <table width="90%" border="0" cellspacing="1" cellpadding="4" align="center" bgcolor="#999900">
						<tr bgcolor="#FFFF33">
						  <td width="6%" bgcolor="#EEEECC"> 
							<?php echo $MSG['5180']; ?>
							 </td>
						  <td width="90%" bgcolor="#EEEECC"> 
							<B>
							<?php echo $USER['name']; ?>
							</B>  </td>
						</tr>
						<tr bgcolor="#FFFF33">
						  <td width="6%" bgcolor="#EEEECC"> 
							<?php echo $MSG['_0022']; ?>
							 </td>
						  <td width="90%" bgcolor="#EEEECC"> 
							<B>
							<?php echo $USER['company']; ?>
							</B>  </td>
						</tr>
						<tr bgcolor="#FFFF33">
						  <td width="6%" bgcolor="#EEEECC"> 
							<?php echo $MSG['303']; ?>
							 </td>
						  <td width="90%" bgcolor="#EEEECC"> 
							<B><A HREF="<?php echo $USER['email']; ?>">
							<?php echo $USER['email']; ?>
							</A></B>  </td>
						</tr>
					  </table>
					</td>
				  </tr>
				  <tr valign="top">
					<td colspan="4" height="22">&nbsp;</td>
				  </tr>
				  <tr valign="top" bgcolor="#999999">
					<td colspan="4" height="22" class=title>
					  <?php echo $MSG['_0055']; ?></td>
				  </tr>
				  <tr>
					<td colspan=4>
					  <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#aaaaaa">
						<tr>
						  <td>
							<table border=0 cellpadding=4 cellspacing=1 align="center" width=100% bgcolor=<?php echo $BG; ?>>
							  <tr valign="top" bgcolor="#FFFFFF">
								<td height="22" colspan="6" align="center">
								  <?php
								  if ($BANNER[type] == 'swf')
								  {
									?>
								  <OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" CODEBASE="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="468" height="60">
									<PARAM NAME=movie value="<?php echo '../'.$uploaded_path.'banners/'.$USER['id'].'/'.$BANNER['name']; ?>">
									<PARAM NAME=quality VALUE=high>
									<EMBED SRC="<?php echo '../'.$uploaded_path.'banners/'.$USER['id'].'/'.$BANNER['name']; ?>" QUALITY=high PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" TYPE="application/x-shockwave-flash" width="468" height="60">
									</EMBED>
								  </OBJECT>
								  <?php
								  }
								  else
								  {
									?>
								  <A TARGET=_blank HREF=<?php echo $BANNER['url']; ?>><IMG border=0 ALT="<?php echo $BANNER['alt']; ?>" SRC="<?php echo '../'.$uploaded_path.'banners/'.$USER['id'].'/'.$BANNER['name']; ?>"></A>
								  <?php
								  }
									?>
								  <BR>
								  <A TARGET=_blank HREF=<?php echo $BANNER['url']; ?>>
								  <?php echo $BANNER['sponsortext']; ?>
								  </A> </td>
							  </tr>
							  <tr valign="top" bgcolor="#eeeeee">
								<td width="33%" height="22"> 
								  <?php echo $MSG['_0050']; ?>
								  &nbsp;<B><A HREF=<?php echo $BANNER['url']; ?> target=_BLANK>
								  <?php echo $BANNER['url']; ?>
								  </a></B>  </td>
								<td height="22" width="16%"> 
								  <?php echo $MSG['_0049']; ?>
								  &nbsp;<B>
								  <?php echo $BANNER[views]; ?>
								  </B>  </td>
								<td height="22" width="17%"> 
								  <?php echo $MSG['_0051']; ?>
								  &nbsp;<B>
								  <?php echo $BANNER['clicks']; ?>
								  </B>  </td>
								<td height="22" width="13%"> 
								  <?php echo $MSG['_0045']; ?>
								  &nbsp;<B>
								  <?php echo $BANNER['purchased']; ?>
								  </B>  </td>
								<td height="22" width="16%"> 
								  <A HREF="javascript:window_open('viewfilters.php?banner=<?php echo $BANNER['id']; ?>','Viewfilters',400,500,30,30)">
								  <?php echo $MSG['_0052']; ?>
								 </a>  </td>
							  </tr>
							</table>
						  </td>
						</tr>
					  </table>
					  <BR>
					</td>
				  </tr>
				  <tr>
					<td colspan="4"> </td>
				  </tr>
				</table>
			  </td>
			</tr>
		  </table>

		 <table width="95%" border="0" cellspacing="0" cellpadding="1" bgcolor="#296FAB">
			<tr>
			  <td>
				<table width=100% cellpadding=2 align="center" bgcolor="#CED6E1">
				  <tr valign="top" bgcolor="#A8C8E2">
					<td colspan="2" height="22">
					  <?php echo $MSG['_0041']; ?>
					   </td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140"> 
					  <?php echo $MSG['_0056']; ?>
					   </td>
					<td width="492">
					  <input type="file" name="bannerfile" SIZE=40>
					  <BR>
					  <?php echo $MSG['_0036']; ?>
					   </td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140"> 
					  <?php echo $MSG['_0030']; ?>
					   </td>
					<td width="492">
					  <input type="text" name="url" SIZE="45" value="<?php echo $BANNER['url']; ?>">
						<BR>
					  <?php echo $MSG['_0037']; ?>
					   </td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140"> 
					  <?php echo $MSG['_0031']; ?>
					   </td>
					<td width="492">
					  <input type="text" name="sponsortext" SIZE="45" value="<?php echo $BANNER['sponsortext']; ?>">
					  <BR>
					  <?php echo $MSG['_0038']; ?>
					   </td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140"> 
					  <?php echo $MSG['_0032']; ?>
					   </td>
					<td width="492">
					  <input type="text" name="alt" SIZE="45" value="<?php echo $BANNER['alt']; ?>">
					  <BR>
					  <?php echo $MSG['_0038']; ?>
					   </td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140"> 
					  <?php echo $MSG['_0045']; ?>
					   </td>
					<td width="492">
					  <input type="text" name="purchased" SIZE="8" value="<?php echo $_POST['purchased']; ?>">
					  <BR>
					  <?php echo $MSG['_0046']; ?>
					   </td>
				  </tr>
				  <tr valign="top" bgcolor="#CADCDF">
					<td colspan="2"> 
					  <?php echo $MSG['_0033']; ?>
					  <BR>
					  <?php echo $MSG['_0039']; ?>
					   </td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140"> 
					  <?php echo $MSG['276']; ?>
					   </td>
					<td width="492">
					  <?php echo $TPL_categories_list; ?>
					</td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140"> 
					  <?php echo $MSG['_0035']; ?>
					   </td>
					<td width="492">
					  <TEXTAREA name="keywords" COLS="45" ROWS="8"><?php echo $KEYWORDS; ?></TEXTAREA>
					</td>
				  </tr>
				  <tr valign="top" bgcolor="#DEE9EB">
					<td width="140">&nbsp;</td>
					<td width="492">
					  <input type="hidden" name="action" value="update">
					  <input type="hidden" name="banner" value="<?php echo $banner; ?>">
					  <input type="hidden" name="id" value="<?php echo $USER['id']; ?>">
					  <input type="submit" name="Submit2" value="<?php echo $MSG['_0040']; ?>">
					</td>
				  </tr>
				  <tr>
					<td colspan="2"> </td>
				  </tr>
				</table>
			  </td>
			</tr>
		  </table>
		</form>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>