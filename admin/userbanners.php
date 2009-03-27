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
include "loggedin.inc.php";
include $main_path."language/".$language."/categories.inc.php";
#//
$id = (int)$_REQUEST['id'];
if(isset($_POST['action']) && $_POST['action'] == "insert") {
	#// Data integrity
	if(empty($_FILES['bannerfile']) || empty($_POST['url'])) {
		$ERR = $ERR_047;
	} else {
		#// Handle upload
		if(!file_exists($upload_path."banners")) {
			umask();
			mkdir($upload_path."banners",0777);
		}
		if(!file_exists($upload_path."banners/$id")) {
			umask();
			mkdir($upload_path."banners/$id",0777);
		}
		
		$TARGET = $upload_path."banners/$id/".$_FILES['bannerfile']['name'];
		if(file_exists($TARGET)) {
			$ERR = sprintf($MSG['_0047'], $TARGET);
		} else {
			list($imagewidth, $imageheight, $imageType) = getimagesize($_FILES['bannerfile']['tmp_name']);
			$filename = basename($_FILES['bannerfile']['name']);
			$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
			$file_types = array('gif', 'jpg', 'jpeg', 'png', 'swf', 'GIF', 'JPG', 'JPEG', 'PNG', 'SWF');
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
				if(!empty($_FILES['bannerfile']['tmp_name']) && $_FILES['bannerfile']['tmp_name'] != "none") {
					move_uploaded_file($_FILES['bannerfile']['tmp_name'],$TARGET);
					chmod($TARGET,0666);
				}
				
				#// Update database
				$query = "INSERT INTO " . $DBPrefix . "banners
						  VALUES (
						  NULL,
						  '".addslashes($_FILES['bannerfile']['name'])."',
						  '$FILETYPE',
						  0,
						  0,
						  '".$_POST['url']."',
						  '".$_POST['sponsortext']."',
						  '".$_POST['alt']."',
						  ".intval($_POST['purchased']).",
						  $imagewidth,
						  $imageheight,
						  $id)";
				$res = mysql_query($query);
				$system->check_mysql($res, $query, __LINE__, __FILE__);
				$ID = mysql_insert_id();
				
				#// Handle filters
				if(is_array($_POST['categories'])) {
					while(list($k,$v) = each($_POST['categories'])) {
						$query = "INSERT INTO " . $DBPrefix . "bannerscategories VALUES ($ID,$v)";
						$res = mysql_query($query);
						$system->check_mysql($res, $query, __LINE__, __FILE__);
					}
				}
				if(!empty($_POST['keywords'])) {
					$KEYWORDS = explode("\n",$_POST['keywords']);
					
					while(list($k,$v) = each($KEYWORDS)) {
						if(!empty($v)) {
							$query = "INSERT INTO " . $DBPrefix . "bannerskeywords VALUES ($ID,'".chop($v)."')";
							$res = mysql_query($query);
							$system->check_mysql($res, $query, __LINE__, __FILE__);
						}
					}
				}
				header("Location: userbanners.php?id=$id");
				exit;
			}
		}
	}
}

$BANNERS = array();
#// Retrieve user's information
$query = "SELECT * FROM " . $DBPrefix . "bannersusers WHERE id = $id";
$res_ = mysql_query($query);
$system->check_mysql($res_, $query, __LINE__, __FILE__);
if(mysql_num_rows($res_) > 0)
{
	$USER = mysql_fetch_array($res_);
	
	#// REtrieve user's banners
	$query = "SELECT * FROM " . $DBPrefix . "banners WHERE user = ".$USER['id'];
	$res = mysql_query($query);
	$system->check_mysql($res, $query, __LINE__, __FILE__);
	if(mysql_num_rows($res) > 0)
	{
		while($row = mysql_fetch_array($res))
		{
			$BANNERS[] = $row;
		}
	}
}

// -------------------------------------- category
$TPL_categories_list= "<select name=\"category[]\" ROWS=12 MULTIPLE>\n";
if(isset($category_plain) && count($category_plain) > 0) {
	foreach($category_plain as $k => $v) {
		if(isset($_POST['categories']) && is_array($_POST['categories']))
			$select = (in_array($k, $_POST['categories'])) ? " selected=true" : "";
		else
			$select = '';
		$TPL_categories_list .= "		<option value=\"".$k."\" ".$select.">".$v."</option>\n";
	}
}
$TPL_categories_list .= "</select>\n";

?>
<HTML>
<HEAD>
<link rel='stylesheet' type='text/css' href='style.css' />
<SCRIPT type="text/javascript">
function window_open(pagina,titulo,ancho,largo,x,y){
	var Ventana= 'toolbar=0,location=0,directories=0,scrollbars=1,screenX='+x+',screenY='+y+',status=0,menubar=0,resizable=0,width='+ancho+',height='+largo;
	open(pagina,titulo,Ventana);
}
</SCRIPT>
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" link="#0066FF" vlink="#666666" alink="#000066" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/bac_barint.gif"><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="30"><img src="images/i_ban.gif" ></td>
          <td class=white>
            <?php echo $MSG['25_0011']; ?>
&nbsp;&gt;&nbsp;
            <?php echo $MSG['_0008']; ?>
            </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><TABLE BORDER=0 WIDTH=100% CELLPADDING=0 CELLSPACING=0 BGCOLOR="#FFFFFF">
        <TR>
          <TD><CENTER>
            <BR>
            <FORM NAME=conf ACTION="" METHOD=POST ENCTYPE="multipart/form-data">
              <TABLE WIDTH="90%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#0083D7">
                <TR>
                  <TD ALIGN=CENTER class=title><?php print $MSG['_0024']; ?></TD>
                </TR>
                <TR>
                  <TD><TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#FFFFFF">
                      <?php
                      if(!empty($ERR)) {
					  ?>
                      <TR>
                        <TD COLSPAN="4" ALIGN=CENTER BGCOLOR=yellow><B>
                          <?php echo $ERR; ?>
                           </B></TD>
                      </TR>
                      <?php
                      }
					  ?>
                      <TR VALIGN="TOP">
                        <TD COLSPAN="4" ALIGN=CENTER> <A HREF=managebanners.php>
                          <?php echo $MSG['270']; ?>
                          </A> </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#FFFFFF">
                        <TD COLSPAN="4" HEIGHT="22"><TABLE WIDTH="95%" BORDER="0" CELLSPACING="1" CELLPADDING="4" ALIGN="CENTER" BGCOLOR="#999900">
                            <TR BGCOLOR="#FFFF33">
                              <TD WIDTH="6%" BGCOLOR="#EEEECC">
                                <?php echo $MSG['5180']; ?>
                                 </TD>
                              <TD WIDTH="90%" BGCOLOR="#EEEECC"> <B>
                                <?php echo $USER['name']; ?>
                                </B>  </TD>
                              <TD ROWSPAN="3" WIDTH="4%" BGCOLOR="#FFFFFF"><A HREF=editbannersuser.php?id=<?php echo $id; ?>><IMG BORDER=0 ALT="Edit user's data" SRC="images/tool.gif" WIDTH="24" HEIGHT="20"></a> </TD>
                            </TR>
                            <TR BGCOLOR="#FFFF33">
                              <TD WIDTH="6%" BGCOLOR="#EEEECC">
                                <?php echo $MSG['_0022']; ?>
                                 </TD>
                              <TD WIDTH="90%" BGCOLOR="#EEEECC"> <B>
                                <?php echo $USER['company']; ?>
                                </B>  </TD>
                            </TR>
                            <TR BGCOLOR="#FFFF33">
                              <TD WIDTH="6%" BGCOLOR="#EEEECC">
                                <?php echo $MSG['303']; ?>
                                 </TD>
                              <TD WIDTH="90%" BGCOLOR="#EEEECC"> <B><A HREF="<?php echo $USER['email']; ?>">
                                <?php echo $USER['email']; ?>
                                </A></B>  </TD>
                            </TR>
                          </TABLE></TD>
                      </TR>
                      <TR VALIGN="TOP">
                        <TD COLSPAN="4" HEIGHT="22">&nbsp;</TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#999999">
                        <TD COLSPAN="4" HEIGHT="22" class=title>
                          <?php echo $MSG['_0043']; ?>
                          </TD>
                      </TR>
                      <TR>
                        <TD colspan=4>
                        <?php
                        if(is_array($BANNERS)) {
                        	$BG = "#eeeeee";
                        	while(list($k,$v) = each($BANNERS)) {
                        		if($BG == "#eeeeee")
                        		$BG = "#dddddd";
                        		else
                        		$BG = "#eeeeee";
		  				?>
                          <TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#aaaaaa">
                            <TR>
                              <TD><TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 ALIGN=CENTER WIDTH=100% BGCOLOR=<?php echo $BG; ?>>
                                  <TR VALIGN="TOP" BGCOLOR="#FFFFFF">
                                    <TD HEIGHT="22" COLSPAN="7" ALIGN=CENTER>
                                    <?php
                                    if($v['type'] == 'swf') {
									?>
                                      <OBJECT CLASSID="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" CODEBASE="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" WIDTH="<?php echo $v['width']; ?>" HEIGHT="<?php echo $v['height']; ?>">
                                        <PARAM NAME=movie VALUE="<?php echo '../'.$uploaded_path.'banners/'.$id.'/'.$v['name']; ?>">
                                        <PARAM NAME=quality VALUE=high>
                                        <EMBED SRC="<?php echo '../'.$uploaded_path.'banners/'.$id.'/'.$v['name']; ?>" QUALITY=high PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" TYPE="application/x-shockwave-flash" WIDTH="468" HEIGHT="60"> </EMBED>
                                      </OBJECT>
                                    <?php
                                    } else {
									?>
                                      <A TARGET=_blank HREF=<?php echo $v['url']; ?>><IMG BORDER=0 ALT="<?php echo $v['alt']; ?>" SRC="<?php echo '../'.$uploaded_path.'banners/'.$id.'/'.$v['name']; ?>"></A>
                                    <?php
                                    }
									?>
                                      <BR>
                                      <A TARGET=_blank HREF=<?php echo $v['url']; ?>>
                                      <?php echo $v['sponsortext']; ?>
                                      </A> </TD>
                                  </TR>
                                  <TR VALIGN="TOP" BGCOLOR="#eeeeee">
                                    <TD WIDTH="29%" HEIGHT="22">
                                      <?php echo $MSG['_0050']; ?>&nbsp;<B><A HREF=<?php echo $v['url']; ?> target=_BLANK>
                                      <?php echo $v['url']; ?>
                                      </a></B>  </TD>
                                    <TD HEIGHT="22" WIDTH="13%">
                                      <?php echo $MSG['_0049']; ?>&nbsp;<B>
                                      <?php echo $v['views']; ?>
                                      </B>  </TD>
                                    <TD HEIGHT="22" WIDTH="15%">
                                      <?php echo $MSG['_0051']; ?>&nbsp;<B>
                                      <?php echo $v['clicks']; ?>
                                      </B>  </TD>
                                    <TD HEIGHT="22" WIDTH="25%">
                                      <?php echo $MSG['_0045']; ?>&nbsp;<B>
                                      <?php echo $v['purchased']; ?>
                                      </B>  </TD>
                                    <TD HEIGHT="22" WIDTH="9%"> <A HREF="javascript:window_open('viewfilters.php?banner=<?php echo $v['id']; ?>','Viewfilters',400,500,30,30)">
                                      <?php echo $MSG['_0052']; ?>
                                      </a>  </TD>
                                    <TD HEIGHT="22" VALIGN=MIDDLE ALIGN=CENTER WIDTH="5%" BGCOLOR="#FFFFFF"><A HREF="editbanner.php?banner=<?php echo $v['id']; ?>"><IMG SRC="images/tool.gif" WIDTH="24" HEIGHT="20" BORDER="0"></A></TD>
                                    <TD HEIGHT="22" VALIGN=MIDDLE ALIGN=CENTER WIDTH="4%" BGCOLOR="#FFFFFF"><A HREF="deletebanner.php?banner=<?php echo $v['id']; ?>&user=<?php echo $v['user']; ?>&name=<?php echo $v['name']; ?>"><IMG SRC="images/trash.png" WIDTH="18" HEIGHT="26" BORDER="0"></A></TD>
                                  </TR>
                                </TABLE></TD>
                            </TR>
                          </TABLE>
                          <BR>
                        <?php
                        	}
                        }
		  				?>
                        </TD>
                      </TR>
                      <TR>
                        <TD COLSPAN="4"></TD>
                      </TR>
                    </TABLE></TD>
                </TR>
              </TABLE>
              <TABLE WIDTH="90%" BORDER="0" CELLSPACING="0" CELLPADDING="1" BGCOLOR="#296FAB">
                <TR>
                  <TD><TABLE WIDTH=100% CELLPADDING=2 ALIGN="CENTER" BGCOLOR="#CED6E1">
                      <TR VALIGN="TOP" BGCOLOR="#A8C8E2">
                        <TD COLSPAN="2" HEIGHT="22">
                          <?php echo $MSG['_0041']; ?>
                           </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">
                          <?php echo $MSG['_0029']; ?>
                           </TD>
                        <TD WIDTH="492"><INPUT TYPE="file" NAME="bannerfile" SIZE=40>
                          
                          <?php echo $MSG['_0042']; ?>
                           <BR>
                          
                          <?php echo $MSG['_0036']; ?>
                           </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">
                          <?php echo $MSG['_0030']; ?>
                           </TD>
                        <TD WIDTH="492"><INPUT TYPE="text" NAME="url" SIZE="45" VALUE="<?php echo $_POST['url']; ?>">
                          
                          <?php echo $MSG['_0042']; ?>
                           <BR>
                          
                          <?php echo $MSG['_0037']; ?>
                           </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">
                          <?php echo $MSG['_0031']; ?>
                           </TD>
                        <TD WIDTH="492"><INPUT TYPE="text" NAME="sponsortext" SIZE="45" VALUE="<?php echo $_POST['sponsortext']; ?>">
                          <BR>
                          
                          <?php echo $MSG['_0038']; ?>
                           </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">
                          <?php echo $MSG['_0032']; ?>
                           </TD>
                        <TD WIDTH="492"><INPUT TYPE="text" NAME="alt" SIZE="45" VALUE="<?php echo $_POST['alt']; ?>">
                          <BR>
                          
                          <?php echo $MSG['_0038']; ?>
                           </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">
                          <?php echo $MSG['_0045']; ?>
                           </TD>
                        <TD WIDTH="492"><INPUT TYPE="text" NAME="purchased" SIZE="8" VALUE="<?php echo $_POST['purchased']; ?>">
                          <BR>
                          
                          <?php echo $MSG['_0046']; ?>
                           </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#CADCDF">
                        <TD COLSPAN="2">
                          <?php echo $MSG['_0033']; ?>
                          <BR>
                          <?php echo $MSG['_0039']; ?>
                           </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">
                          <?php echo $MSG['276']; ?>
                           </TD>
                        <TD WIDTH="492"><?php echo $TPL_categories_list; ?>
                        </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">
                          <?php echo $MSG['_0035']; ?>
                           </TD>
                        <TD WIDTH="492">
                        <TEXTAREA NAME="keywords" COLS="45" ROWS="8"><?php echo $_POST['keywords']; ?></TEXTAREA>
                        </TD>
                      </TR>
                      <TR VALIGN="TOP" BGCOLOR="#DEE9EB">
                        <TD WIDTH="140">&nbsp;</TD>
                        <TD WIDTH="492"><INPUT TYPE="hidden" NAME="action" VALUE="insert">
                          <INPUT TYPE="hidden" NAME="id" VALUE="<?php echo $id; ?>">
                          <INPUT TYPE="submit" NAME="Submit2" VALUE="<?php echo $MSG['_0040']; ?>">
                        </TD>
                      </TR>
                      <TR>
                        <TD COLSPAN="2"></TD>
                      </TR>
                    </TABLE></TD>
                </TR>
              </TABLE>
            </FORM></CENTER></TD>
        </TR>
      </TABLE></TD>
  </TR>
</TABLE>
</BODY>
</HTML>
